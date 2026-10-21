<?php

namespace App\Http\Controllers;

use App\Models\PgEnrollment;
use App\Models\PgSupervisor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pre_master' => PgEnrollment::where('program_type', 'pre_master')->count(),
            'master' => PgEnrollment::where('program_type', 'master')->count(),
            'phd' => PgEnrollment::where('program_type', 'phd')->count(),
            'supervisors' => PgSupervisor::count(),
            'inactive_accounts' => PgEnrollment::whereNull('activation_token')->count(),
        ];

        return view('dashboard.index', compact('stats'));
    }
}