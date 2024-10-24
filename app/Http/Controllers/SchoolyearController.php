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
        $request->validate([
            'wording' => 'required|string|max:255|unique:school_years',
        ]);

        SchoolYear::create($request->only('wording'));

        return redirect()->route('school_years.index')
            ->with('success', 'Année scolaire créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $schoolYear = SchoolYear::find($id);
        if (!$schoolYear) {
            return redirect()->route('school_years.index')->with('error', 'Année scolaire non trouvée.');
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
            return redirect()->route('school_years.index')->with('error', 'Année scolaire non trouvée.');
        }
        return view('school_years.edit', compact('schoolYear'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SchoolYear $schoolYear)
    {
        $request->validate([
            'wording' => 'required|string|max:255|unique:school_years,wording,' . $schoolYear->id,
        ]);

        $schoolYear->update($request->only('wording'));

        return redirect()->route('school_years.index')
            ->with('success', 'Année scolaire mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        $schoolYear = SchoolYear::find($id);
        if (!$schoolYear) {
            return redirect()->route('school_years.index')->with('error', 'Année scolaire non trouvée.');
        }
        $schoolYear->delete();

        return redirect()->route('school_years.index')
            ->with('success', 'Année scolaire supprimée avec succès.');
    }
}
