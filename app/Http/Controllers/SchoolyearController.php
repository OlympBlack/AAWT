<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use Illuminate\Http\Request;

class SchoolYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schoolYears = SchoolYear::all();
        return view('school_years.index', compact('schoolYears'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('school_years.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'wording' => 'required|string|max:255',
            'is_current' => 'boolean',
        ]);

        if ($validatedData['is_current']) {
            SchoolYear::where('is_current', true)->update(['is_current' => false]);
        }

        SchoolYear::create($validatedData);

        return redirect()->route('school-years.index')->with('success', 'Année scolaire créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $schoolYear = SchoolYear::find($id);
        if (!$schoolYear) {
            return redirect()->route('school-years.index')->with('error', 'Année scolaire non trouvée.');
        }
        return view('school_years.show', compact('schoolYear'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $schoolYear = SchoolYear::find($id);
        if (!$schoolYear) {
            return redirect()->route('school-years.index')->with('error', 'Année scolaire non trouvée.');
        }
        return view('school_years.edit', compact('schoolYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $schoolYear = SchoolYear::findOrFail($id);

        $validatedData = $request->validate([
            'wording' => 'required|string|max:255',
            'is_current' => 'nullable',
        ]);

        // Convertir la valeur de is_current en booléen
        $validatedData['is_current'] = $request->has('is_current');

        if ($validatedData['is_current'] && !$schoolYear->is_current) {
            SchoolYear::where('is_current', true)->update(['is_current' => false]);
        }

        $schoolYear->update($validatedData);

        return redirect()->route('school-years.index')->with('success', 'Année scolaire mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $schoolYear = SchoolYear::findOrFail($id);
            
            if ($schoolYear->semesters()->count() > 0) {
                return redirect()->route('school-years.index')
                    ->with('error', 'Impossible de supprimer cette année scolaire car elle est associée à des semestres.');
            }
            
            if ($schoolYear->classrooms()->count() > 0) {
                return redirect()->route('school-years.index')
                    ->with('error', 'Impossible de supprimer cette année scolaire car elle est associée à des classes.');
            }
    
            if ($schoolYear->students()->count() > 0) {
                return redirect()->route('school-years.index')
                    ->with('error', 'Impossible de supprimer cette année scolaire car elle est associée à des étudiants.');
            }
    
            $schoolYear->delete();
            return redirect()->route('school-years.index')
                ->with('success', 'Année scolaire supprimée avec succès.');
        } catch (\Exception $e) {
            return redirect()->route('school-years.index')
                ->with('error', 'Une erreur est survenue lors de la suppression.');
        }
    }
    public function toggleCurrent($id)
    {
        SchoolYear::toggleCurrent($id);
        return redirect()->back()->with('success', 'Année scolaire courante mise à jour avec succès.');
    }
}
