<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function addalert(){
        $title = 'Add alert - Mapbiomas Indonesia';
        $nav = 'dashboard';
        return view('addalert', compact('title', 'nav'));
    }
    public function index(){
        $title = 'Alerts - Mapbiomas Indonesia';
        $nav = 'alerts';
        return view('alerts', compact('title', 'nav'));

    }
}
