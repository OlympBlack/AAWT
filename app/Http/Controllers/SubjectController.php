<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Classroom;
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
        return view('subjects.create', compact('classrooms'));
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
        ]);

        Subject::create($request->all());

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
        $subject = Subject::find($id);
        if (!$subject) {
            return redirect()->route('subjects.index')->with('error', 'Matière non trouvée.');
        }
        $classrooms = Classroom::all();
        return view('subjects.edit', compact('subject', 'classrooms'));
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
        ]);

        $subject->update($request->all());

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
