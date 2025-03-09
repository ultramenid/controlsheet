<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
        $title = 'Alerta - Mapbiomas Indonesia';
        return view('login', compact('title'));
    }
}
