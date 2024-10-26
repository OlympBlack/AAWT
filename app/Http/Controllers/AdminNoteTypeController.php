<?php

namespace App\Http\Controllers;

use App\Models\NoteType;
use Illuminate\Http\Request;

class AdminNoteTypeController extends Controller
{
    public function index()
    {
        $noteTypes = NoteType::all();
        return view('note-types.index', compact('noteTypes'));
    }

    public function create()
    {
        return view('note-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'wording' => 'required|string|max:255|unique:note_types',
        ]);

        NoteType::create($request->all());

        return redirect()->route('note-types.index')
            ->with('success', 'Type de note créé avec succès.');
    }

    public function edit(NoteType $noteType)
    {
        return view('note-types.create', compact('noteType'));
    }

    public function update(Request $request, NoteType $noteType)
    {
        $request->validate([
            'wording' => 'required|string|max:255|unique:note_types,wording,' . $noteType->id,
        ]);

        $noteType->update($request->all());

        return redirect()->route('note-types.index')
            ->with('success', 'Type de note mis à jour avec succès.');
    }

    public function destroy(NoteType $noteType)
    {
        $noteType->delete();

        return redirect()->route('note-types.index')
            ->with('success', 'Type de note supprimé avec succès.');
    }
}
