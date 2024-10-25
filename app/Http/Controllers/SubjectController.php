<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Classroom;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = Subject::with('classroom')->get();
        return view('subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classrooms = Classroom::all();
        $teachers = User::whereHas('role', function($query) {
            $query->where('wording', 'teacher');
        })->get();
        return view('subjects.create', compact('classrooms', 'teachers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'wording' => 'required|string|max:255',
            'coefficient' => 'required|numeric|min:0',
            'classroom_id' => 'required|exists:classrooms,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $subject = Subject::create($request->except('teacher_id'));
        $subject->teachers()->attach($request->teacher_id, ['classroom_id' => $request->classroom_id]);

        return redirect()->route('subjects.index')
            ->with('success', 'Matière créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $subject = Subject::with('classroom')->find($id);
        if (!$subject) {
            return redirect()->route('subjects.index')->with('error', 'Matière non trouvée.');
        }
        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $subject = Subject::with('teachers')->find($id);
        if (!$subject) {
            return redirect()->route('subjects.index')->with('error', 'Matière non trouvée.');
        }
        $classrooms = Classroom::all();
        $teachers = User::whereHas('role', function($query) {
            $query->where('wording', 'teacher');
        })->get();
        return view('subjects.edit', compact('subject', 'classrooms', 'teachers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $subject = Subject::find($id);
        if (!$subject) {
            return redirect()->route('subjects.index')->with('error', 'Matière non trouvée.');
        }

        $request->validate([
            'wording' => 'required|string|max:255',
            'coefficient' => 'required|numeric|min:0',
            'classroom_id' => 'required|exists:classrooms,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $subject->update($request->except('teacher_id'));
        $subject->teachers()->sync([$request->teacher_id => ['classroom_id' => $request->classroom_id]]);

        return redirect()->route('subjects.index')
            ->with('success', 'Matière mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $subject = Subject::find($id);
        if (!$subject) {
            return redirect()->route('subjects.index')->with('error', 'Matière non trouvée.');
        }
        $subject->delete();

        return redirect()->route('subjects.index')
            ->with('success', 'Matière supprimée avec succès.');
    }
}
