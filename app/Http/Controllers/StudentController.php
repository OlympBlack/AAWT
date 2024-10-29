<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function verify($id)
    {
        $student = User::with(['registrations' => function($query) {
            $query->latest()->with(['classroom.serie', 'schoolYear']);
        }])->findOrFail($id);

        $currentRegistration = $student->registrations->first();

        if (!$currentRegistration) {
            abort(404, 'Aucune inscription trouvée pour cet étudiant.');
        }

        return view('student.verify', compact('student', 'currentRegistration'));
    }
}