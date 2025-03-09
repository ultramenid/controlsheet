<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('fix-alert')]
class CheckUserAlertAudit extends Component
{

    public function checkAlert(){
        return DB::table('alerts')->where('analisId', session('id'))->where('auditorStatus', '!=', 'approved')->count();
    }


    public function render()
    {
        // dd($this->checkAlert());
        $totalAlert = $this->checkAlert();
        return view('livewire.check-user-alert-audit', compact('totalAlert'));
    }
}
