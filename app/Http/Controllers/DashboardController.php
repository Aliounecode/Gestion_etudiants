<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Module;
use App\Models\Scan;
use App\Models\Grade;

class DashboardController extends Controller
{
    public function index()
    {
        // On récupère les vraies statistiques (même si c'est 0 pour l'instant)
        $stats = [
            'students_count' => Student::count(),
            'modules_active' => Module::where('status', true)->count(),
            'scans_count' => Scan::count(),
            'pending_grades' => Grade::where('status', 'pending')->count(),
        ];

        // On simule des activités récentes pour l'instant (car la DB est vide)
        // Plus tard, on remplacera par : Scan::latest()->take(5)->get();
        $recent_activities = []; 

        return view('dashboard', compact('stats', 'recent_activities'));
    }
}