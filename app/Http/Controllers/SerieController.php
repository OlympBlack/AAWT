<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function index()
    {
        $series = Serie::all();
        return view('series.index', compact('series'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'wording' => 'required|string|max:255',
        ]);

        Serie::create($request->all());

        return redirect()->route('series.index')
            ->with('success', 'Série créée avec succès.');
    }

    public function show($id)
    {
        $serie = Serie::find($id);
        if (!$serie) {
            return redirect()->route('series.index')->with('error', 'Série non trouvée.');
        }
        return view('series.show', compact('serie'));
    }

    public function edit($id)
    {
        $serie = Serie::find($id);

        if (!$serie) {
            return redirect()->route('series.index')->with('error', 'Série non trouvée.');
        }
        return view('series.edit', compact('serie'));
    }

    public function update(Request $request, Serie $serie)
    {
        $request->validate([
            'wording' => 'required|string|max:255',
        ]);

        $serie->update($request->all());

        return redirect()->route('series.index')
            ->with('success', 'Série mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $serie = Serie::find($id);
        $serie->delete();

        return redirect()->route('series.index')
            ->with('success', 'Série supprimée avec succès.');
    }
}
