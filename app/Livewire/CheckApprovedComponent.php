<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

#[On('echo:analis-data,UpdateAnalis')]
class CheckApprovedComponent extends Component
{
    #[On('fix-alert')]
    public function checkAlert(){
        return DB::table('alerts')->where('analisId', session('id'))->where('auditorStatus', '=', 'approved')->count();
    }

    public function render()
    {
        $totalAlert = $this->checkAlert();
        return view('livewire.check-approved-component', compact('totalAlert'));
    }
}
