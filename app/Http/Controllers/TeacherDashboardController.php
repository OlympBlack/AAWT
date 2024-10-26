<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Classroom;
use App\Models\Subject;
use App\Models\Note;
use App\Models\NoteType;
use App\Models\SchoolYearSemester;
use App\Models\SchoolYear;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();
        $classrooms = $teacher->teachingSubjects->pluck('classroom')->unique();
        $totalStudents = Registration::whereIn('classroom_id', $classrooms->pluck('id'))->count();
        $totalSubjects = $teacher->teachingSubjects->count();

        return view('dashboard', compact('teacher', 'classrooms', 'totalStudents', 'totalSubjects'));
    }

    public function classes()
    {
        $teacher = Auth::user();
        $classrooms = $teacher->teachingSubjects->pluck('classroom')->unique();
        
        return view('teacher.classes', compact('classrooms'));
    }

    public function students(Classroom $classroom)
    {
        $teacher = Auth::user();
        if (!$teacher->teachingSubjects()
                     ->wherePivot('classroom_id', $classroom->id)
                     ->exists()) {
            abort(403, 'Vous n\'êtes pas autorisé à accéder à cette classe.');
        }

        $currentSchoolYear = SchoolYear::current();
        
        if (!$currentSchoolYear) {
            // Gérer le cas où aucune année scolaire active n'est trouvée
            abort(404, 'Aucune année scolaire active n\'a été trouvée.');
        }

        $registrations = Registration::where('classroom_id', $classroom->id)
                                     ->where('school_year_id', $currentSchoolYear->id)
                                     ->with('student')
                                     ->get();
        
        $subjects = $classroom->subjects()->whereHas('teachers', function($query) use ($teacher) {
            $query->where('users.id', $teacher->id);
        })->get();
        
        return view('teacher.students', compact('classroom', 'registrations', 'subjects'));
    }

    public function studentNotes(User $student, Classroom $classroom)
    {
        $teacher = Auth::user();
        $currentSchoolYear = SchoolYear::current();
        $registration = Registration::where('student_id', $student->id)
                                    ->where('classroom_id', $classroom->id)
                                    ->where('school_year_id', $currentSchoolYear->id)
                                    ->first();

        if (!$registration) {
            abort(404, 'Cet étudiant n\'est pas inscrit dans cette classe pour l\'année scolaire en cours.');
        }

        $subjects = $teacher->teachingSubjects()
                            ->where('classroom_id', $classroom->id)
                            ->get();
        
        if ($subjects->isEmpty()) {
            abort(403, 'Vous n\'enseignez aucune matière dans cette classe.');
        }

        $currentSemester = SchoolYearSemester::where('school_year_id', $currentSchoolYear->id)
                            ->where('is_active', true)
                            ->first();
        
        if (!$currentSemester) {
            abort(404, 'Aucun semestre actif n\'a été trouvé pour l\'année scolaire en cours.');
        }

        $noteTypes = NoteType::all();
        
        // Récupérer toutes les notes de l'étudiant pour les matières enseignées par ce professeur
        $notes = Note::where('student_id', $student->id)
                     ->whereIn('subject_id', $subjects->pluck('id'))
                     ->where('school_year_semester_id', $currentSemester->id)
                     ->get()
                     ->groupBy(['subject_id', 'note_type_id']);
        
        return view('teacher.student_notes', compact('student', 'subjects', 'currentSemester', 'noteTypes', 'classroom', 'notes'));
    }

    public function storeNote(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'note_type_id' => 'required|exists:note_types,id',
            'school_year_semester_id' => 'required|exists:school_year_semesters,id',
            'value' => 'required|numeric|min:0|max:20',
        ]);

        $teacher = Auth::user();
        $subject = Subject::findOrFail($request->subject_id);

        if (!$teacher->teachingSubjects()->where('subjects.id', $subject->id)->exists()) {
            abort(403, 'Vous n\'êtes pas autorisé à ajouter des notes pour cette matière.');
        }

        $currentSchoolYear = SchoolYear::current();
        $currentSemester = SchoolYearSemester::where('school_year_id', $currentSchoolYear->id)
                            ->where('is_active', true)
                            ->first();

        if ($request->school_year_semester_id != $currentSemester->id) {
            abort(403, 'Vous ne pouvez ajouter des notes que pour le semestre actif.');
        }

        Note::updateOrCreate(
            [
                'student_id' => $request->student_id,
                'subject_id' => $request->subject_id,
                'note_type_id' => $request->note_type_id,
                'school_year_semester_id' => $request->school_year_semester_id,
            ],
            ['value' => $request->value]
        );

        return redirect()->back()->with('success', 'Note enregistrée avec succès.');
    }

    public function updateNote(Request $request, Note $note)
    {
        $request->validate([
            'value' => 'required|numeric|min:0|max:20',
        ]);

        $teacher = Auth::user();
        if (!$teacher->teachingSubjects()->where('subjects.id', $note->subject_id)->exists()) {
            abort(403, 'Vous n\'êtes pas autorisé à modifier cette note.');
        }

        $note->update(['value' => $request->value]);

        return redirect()->back()->with('success', 'Note mise à jour avec succès.');
    }

    public function deleteNote(Note $note)
    {
        $teacher = Auth::user();
        if (!$teacher->teachingSubjects()->where('subjects.id', $note->subject_id)->exists()) {
            abort(403, 'Vous n\'êtes pas autorisé à supprimer cette note.');
        }

        $note->delete();

        return redirect()->back()->with('success', 'Note supprimée avec succès.');
    }
}
