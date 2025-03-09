<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class CheckUserAlertAudit extends Component
{
    public function checkAlert(){
        return DB::table('alerts')->where('analisId', session('id'))->where('auditorStatus', '!=', 'approve')->count();
    }
    public function render()
    {
        // dd($this->checkAlert());
        $totalAlert = $this->checkAlert();
        return view('livewire.check-user-alert-audit', compact('totalAlert'));
    }
}
