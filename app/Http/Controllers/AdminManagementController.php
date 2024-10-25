<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewAdminAccount;
use Illuminate\Support\Facades\Validator;

class AdminManagementController extends Controller
{
    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Erreur de validation. Veuillez vérifier les champs.');
        }

        $temporaryPassword = Str::random(10);

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($temporaryPassword),
            'role_id' => Role::where('wording', 'admin')->first()->id,
            'password_change_required' => true,
        ]);

        Mail::to($user->email)->send(new NewAdminAccount($user, $temporaryPassword));

        return redirect()->route('dashboard')->with('success', 'Nouvel administrateur créé avec succès.');
    }
}
