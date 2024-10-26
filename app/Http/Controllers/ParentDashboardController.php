<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Récupérer les inscriptions des enfants du parent
        $registrations = $user->children()
                              ->with(['registrations.classroom', 'registrations.schoolYear'])
                              ->get()
                              ->flatMap->registrations;

        // Récupérer les notifications non lues
        $notifications = $user->unreadNotifications()->latest()->take(5)->get();

        return view('parent.dashboard', compact('registrations', 'notifications'));
    }
}
