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

    public function studentNotes(Classroom $classroom, User $student)
    {
        $teacher = Auth::user();
        $currentSchoolYear = SchoolYear::current();
        $currentSemester = SchoolYearSemester::where('school_year_id', $currentSchoolYear->id)
                                         ->first(); // Retiré where('is_active', true) pour voir tous les semestres

        if (!$currentSemester) {
            return redirect()->back()->with('error', 'Aucun semestre trouvé pour l\'année scolaire en cours.');
        }

        $subjects = $teacher->teachingSubjects()
                        ->where('subject_teacher.classroom_id', $classroom->id)
                        ->get();

        $noteTypes = NoteType::all();

        // Récupérer toutes les notes et les trier par date d'ajout
        $notes = Note::where('student_id', $student->id)
                 ->whereIn('subject_id', $subjects->pluck('id'))
                 ->where('school_year_semester_id', $currentSemester->id)
                 ->orderBy('created_at', 'asc')
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
        if (!$teacher->teachingSubjects()->where('subjects.id', $request->subject_id)->exists()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à ajouter des notes pour cette matière.');
        }

        $semester = SchoolYearSemester::find($request->school_year_semester_id);
        if (!$semester->is_active) {
            return redirect()->back()->with('error', 'Impossible d\'ajouter une note pour un semestre inactif.');
        }

        // Vérifier le nombre exact de notes
        $existingNotes = Note::where([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'note_type_id' => $request->note_type_id,
            'school_year_semester_id' => $request->school_year_semester_id,
        ])->count();

        $noteType = NoteType::find($request->note_type_id);
        $requiredNotes = $noteType->wording === 'Interrogation' ? 3 : 2;

        if ($existingNotes >= $requiredNotes) {
            return redirect()->back()->with('error', "Le nombre maximum de notes pour ce type d'évaluation est déjà atteint ({$requiredNotes} notes).");
        }

        Note::create([
            'student_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'note_type_id' => $request->note_type_id,
            'school_year_semester_id' => $request->school_year_semester_id,
            'value' => $request->value
        ]);

        if ($existingNotes + 1 === $requiredNotes) {
            $message = "Note ajoutée avec succès. Vous avez atteint le nombre maximum de notes pour ce type d'évaluation.";
        } else {
            $message = "Note ajoutée avec succès. Il vous reste " . ($requiredNotes - ($existingNotes + 1)) . " note(s) à ajouter.";
        }

        return redirect()->back()->with('success', $message);
    }

    public function updateNote(Request $request, Note $note)
    {
        $request->validate([
            'value' => 'required|numeric|min:0|max:20',
        ]);

        $teacher = Auth::user();
        if (!$teacher->teachingSubjects()->where('subjects.id', $note->subject_id)->exists()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à modifier cette note.');
        }

        $note->update(['value' => $request->value]);

        return redirect()->back()->with('success', 'Note mise à jour avec succès.');
    }

    public function deleteNote(Note $note)
    {
        $teacher = Auth::user();
        if (!$teacher->teachingSubjects()->where('subjects.id', $note->subject_id)->exists()) {
            return redirect()->back()->with('error', 'Vous n\'êtes pas autorisé à supprimer cette note.');
        }

        $note->delete();

        return redirect()->back()->with('success', 'Note supprimée avec succès.');
    }
}
