<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class AddUserComponent extends Component
{
    public $email, $name, $password, $contact, $level;


    public function render()
    {
        return view('livewire.add-user-component');
    }

    public function storeUser(){
        if($this->manualValidation()){
            DB::table('users')->insert([
                'name' => $this->name,
                'email' => $this->email,
                'contact' => $this->contact,
                'role_id' => $this->level,
                'password' => Hash::make($this->password),
                'created_at' => Carbon::now('Asia/Jakarta')
            ]);
            redirect()->to('/users');
        }
    }

    public function checkUser(){
        return DB::table('users')->where('email', $this->email)->first();
    }

    public function manualValidation(){
        if($this->name == ''){
            Toaster::error('Name is required!');
            return;
        }elseif($this->email == ''){
            Toaster::error('Email is required!');
            return;
        }elseif($this->contact == ''){
            Toaster::error('Contact is required!');
            return;
        }elseif($this->level == ''){
            Toaster::error('Level is required!');
            return;
        }elseif($this->password == ''){
            Toaster::error('Name is required!');
            return;
        }elseif($this->checkUser()){
            Toaster::error($this->email.' already in database');
            return;
        }
        return true;
    }


}
