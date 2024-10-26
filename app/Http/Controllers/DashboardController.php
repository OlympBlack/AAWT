<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        switch ($user->role_id) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 2:
                return redirect()->route('parent.dashboard');
            case 3:
                return redirect()->route('teacher.dashboard');
            default:
                return redirect()->route('login')->with('error', 'Rôle non reconnu');
        }
    }
}
