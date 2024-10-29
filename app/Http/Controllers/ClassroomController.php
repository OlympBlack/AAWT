<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Serie;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classrooms = Classroom::with('serie')->get();
        return view('classrooms.index', compact('classrooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $series = Serie::all();
        return view('classrooms.create', compact('series'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'wording' => 'required|string|max:255',
            'costs' => 'required|numeric',
            'serie_id' => 'required|exists:series,id',
        ]);

        Classroom::create($validatedData);

        return redirect()->route('classrooms.index')->with('success', 'Salle de classe créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Classroom $classroom)
    {
        return view('classrooms.show', compact('classroom'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Classroom $classroom)
    {
        $series = Serie::all();
        return view('classrooms.edit', compact('classroom', 'series'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Classroom $classroom)
    {
        $validatedData = $request->validate([
            'wording' => 'required|string|max:255',
            'costs' => 'required|numeric',
            'serie_id' => 'required|exists:series,id',
        ]);

        $classroom->update($validatedData);

        return redirect()->route('classrooms.index')->with('success', 'Salle de classe mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $classroom = Classroom::findOrFail($id);

    try {

        if ($classroom->registrations()->exists()) {
            return back()->with('error', 'Impossible de supprimer cette classe car elle contient des étudiants.');
        }

        if ($classroom->subjects()->exists()) {
            return back()
                ->with('error', 'Impossible de supprimer cette classe car elle est associée à des matières.');
        }

        $classroom->delete();
        return back()->with('success', 'Classe supprimée avec succès.');
    } catch (\Exception $e) {
        return back()->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }
}
