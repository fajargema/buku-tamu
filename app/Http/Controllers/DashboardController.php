<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Guest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $guest = Guest::count();
        $trash = Guest::onlyTrashed()->count();
        $log = ActivityLog::count();
        return view('dashboard', compact('guest', 'trash', 'log'));
    }
}
