<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\SchoolYear;
use App\Models\SchoolYearSemester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semesters = Semester::with('schoolYears')->get();
        return view('semesters.index', compact('semesters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schoolYears = SchoolYear::all();
        return view('semesters.create', compact('schoolYears'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'wording' => 'required|string|max:255',
            'school_years' => 'required|array',
            'school_years.*' => 'exists:school_years,id',
        ]);

        $semester = Semester::create($request->only('wording'));
        $semester->schoolYears()->attach($request->school_years);

        return redirect()->route('semesters.index')
            ->with('success', 'Semestre créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $semester = Semester::with('schoolYears')->find($id);
        if (!$semester) {
            return redirect()->route('semesters.index')->with('error', 'Semestre non trouvé.');
        }
        return view('semesters.show', compact('semester'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $semester = Semester::with('schoolYears')->find($id);
        if (!$semester) {
            return redirect()->route('semesters.index')->with('error', 'Semestre non trouvé.');
        }
        $schoolYears = SchoolYear::all();
        return view('semesters.edit', compact('semester', 'schoolYears'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $semester = Semester::find($id);
        if (!$semester) {
            return redirect()->route('semesters.index')->with('error', 'Semestre non trouvé.');
        }

        $request->validate([
            'wording' => 'required|string|max:255',
            'school_years' => 'required|array',
            'school_years.*' => 'exists:school_years,id',
        ]);

        $semester->update($request->only('wording'));
        $semester->schoolYears()->sync($request->school_years);

        return redirect()->route('semesters.index')
            ->with('success', 'Semestre mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $semester = Semester::find($id);
        if (!$semester) {
            return redirect()->route('semesters.index')->with('error', 'Semestre non trouvé.');
        }
        $semester->schoolYears()->detach();
        $semester->delete();

        return redirect()->route('semesters.index')
            ->with('success', 'Semestre supprimé avec succès.');
    }

    public function toggleActive(Request $request, $id)
    {
        $request->validate([
            'school_year_id' => 'required|exists:school_years,id',
        ]);
    
        $schoolYear = SchoolYear::findOrFail($request->school_year_id);
        
        if (!$schoolYear->is_current) {
            return redirect()->back()->with('error', 'Vous ne pouvez modifier le statut d\'un semestre que pour l\'année scolaire courante.');
        }
    
        $semester = Semester::findOrFail($id);
        $schoolYearSemester = SchoolYearSemester::where('school_year_id', $schoolYear->id)
                                                ->where('semester_id', $semester->id)
                                                ->first();
    
        if (!$schoolYearSemester) {
            return redirect()->back()->with('error', 'Ce semestre n\'est pas associé à l\'année scolaire courante.');
        }
    
        DB::transaction(function () use ($schoolYear, $schoolYearSemester) {
            $newStatus = !$schoolYearSemester->is_active;
            
            // Si on active le semestre, désactiver tous les autres
            if ($newStatus) {
                SchoolYearSemester::where('school_year_id', $schoolYear->id)
                                   ->where('id', '!=', $schoolYearSemester->id)
                                   ->update(['is_active' => false]);
            }
            
            $schoolYearSemester->update(['is_active' => $newStatus]);
        });
    
        $message = $schoolYearSemester->is_active 
            ? "Le semestre {$semester->wording} a été activé pour l'année scolaire courante." 
            : "Le semestre {$semester->wording} a été désactivé pour l'année scolaire courante.";
    
        return redirect()->back()->with('success', $message);
    }
}
