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
        return DB::table('alerts')
        ->join('users', 'users.id', '=', 'alerts.analisId')
        ->where('alerts.analisId', session('id'))
        ->whereNotIn('alerts.auditorStatus', ['approved', 'duplicate', 'rejected'])
        ->where('alerts.isActive', 1)
        ->where('users.is_active', 1)
        ->count();

    }


    public function render()
    {
        // dd($this->checkAlert());
        $totalAlert = $this->checkAlert();
        return view('livewire.check-user-alert-audit', compact('totalAlert'));
    }
}
