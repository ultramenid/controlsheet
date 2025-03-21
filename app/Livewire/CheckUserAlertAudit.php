<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;


class CheckUserAlertAudit extends Component
{

    #[On('fix-alert')]
    #[On('echo:analis-data,UpdateAnalis')]
    public function checkAlert(){
        return DB::table('alerts')->where('analisId', session('id'))
        ->where('auditorStatus', '!=', 'approved')
        ->Where('auditorStatus', '!=', 'duplicate')
        ->Where('auditorStatus', '!=', 'rejected')
        ->count();
    }


    public function render()
    {
        // dd($this->checkAlert());
        $totalAlert = $this->checkAlert();
        return view('livewire.check-user-alert-audit', compact('totalAlert'));
    }
}
