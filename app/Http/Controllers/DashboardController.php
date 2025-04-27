<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Maskapai;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return view('dashboard.admin');
        } elseif ($user->isPetugas()) {
            $maskapais = Maskapai::all();
            return view('dashboard.petugas', compact('maskapais'));
        } else {
            return view('dashboard.user');
        }
    }
} 