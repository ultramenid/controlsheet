<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class CheckApprovedComponent extends Component
{
    #[On('fix-alert')]
    #[On('echo:analis-data,UpdateAnalis')]
    public function checkAlert(){
        return DB::table('alerts')->where('analisId', session('id'))->where('auditorStatus', '=', 'approved')->where('isActive', 1)->count();
    }

    public function render()
    {
        $totalAlert = $this->checkAlert();
        return view('livewire.check-approved-component', compact('totalAlert'));
    }
}
