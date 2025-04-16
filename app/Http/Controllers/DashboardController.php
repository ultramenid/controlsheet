<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        // dd(session()->all());
        $title = 'Dashboard - Mapbiomas Indonesia';
        $nav = 'dashboard';
        return view('dashboard', compact('nav', 'title'));
    }
}
