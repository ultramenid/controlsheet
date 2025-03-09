<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ChangePasswordComponent extends Component
{
    public $oldpassword, $newpassword, $confirmpassword;


    public function render()
    {
        return view('livewire.change-password-component');
    }

    public function storePassword(){

        if($this->manualValidation()){
            DB::table('users')->where('id', session('id'))->update([
                'password' => Hash::make($this->confirmpassword),
                'updated_at' => Carbon::now('Asia/Jakarta')
            ]);
            Toaster::success('Success updating your password 🤙');
        }
    }

    public function getUser(){
        return DB::table('users')->where('id', session('id'))->first();
    }

    public function manualValidation(){

        if($this->oldpassword == ''){
            Toaster::error('Old passsword is required!');
            return;
        }elseif(!Hash::check($this->oldpassword, $this->getUser()->password ) ){
            Toaster::error('Your old password is incorect, contact Auditor for recovery passord');
            return;
        }elseif($this->newpassword == ''){
            Toaster::error('New password is required!');
            return;
        }elseif($this->confirmpassword == ''){
            Toaster::error('Confirm password is required');
            return;
        }elseif($this->newpassword != $this->confirmpassword){
            Toaster::error('Please check your new password and confirm it again.');
            return;
        }elseif(strlen($this->confirmpassword) < 6 ){
            Toaster::error('Password min 6 character!');
            return;
        }
        return true;
    }
}
