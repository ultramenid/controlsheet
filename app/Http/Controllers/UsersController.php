<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(){
        $title = 'Users - Mapbiomas Indonesia';
        $nav = 'users';
        return view('users', compact('title', 'nav'));
    }

    public function adduser(){
        $title = 'Add user - Mapbiomas Indonesia';
        $nav = 'users';
        return view('adduser', compact('title', 'nav'));
    }

    public function edituser($id){
        $title = 'Edit User - Mapbiomas Indonesia';
        $nav = 'users';
        $id = $id;
        return view('edituser', compact('title', 'nav', 'id'));
    }
}
