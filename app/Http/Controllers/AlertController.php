<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function auditing($id){
        $id = $id;
        $title = 'Auditing alert - Mapbiomas Indonesia';
        $nav = 'alerts';
        return view('auditing', compact('id', 'title', 'nav'));
    }

    public function checkAnalis($id){
        return DB::table('alerts')->where('alertId', $id)->first();
    }

    public function editalert($id){
        if(!$this->checkAnalis($id) or $this->checkAnalis($id)->analisId != session('id')  ){
            return redirect('alerts');
        }
        $id = $id;
        $title = 'Edit alert - Mapbiomas Indonesia';
        $nav = 'alerts';
        return view('editalert', compact('id', 'title', 'nav'));
    }
}
