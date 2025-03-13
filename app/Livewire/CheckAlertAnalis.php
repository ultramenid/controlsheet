<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class CheckAlertAnalis extends Component
{
    use WithPagination;
    public $searchName;
    public $dataField = 'name', $dataOrder = 'asc', $paginate = 5;

    public function sortingField($field){
        $this->dataField = $field;
        $this->dataOrder = $this->dataOrder == 'asc' ? 'desc' : 'asc';
    }

    public function updatedSearchName(){
        $this->resetPage();
    }

    #[On('echo:analis-data,UpdateAnalis')]
    #[On('echo:auditor-data,UpdateAuditor')]
    public function getAlerts(){
        $sc = '%' . $this->searchName . '%';
        $query = DB::table('alerts')
                ->join('users', 'alerts.analisId', '=', 'users.id')
                ->selectRaw("
                    users.name,
                    alerts.analisId,
                    SUM(CASE WHEN alerts.auditorStatus = 'approved' THEN 1 ELSE 0 END) AS approved,
                    SUM(CASE WHEN alerts.auditorStatus = 'rejected' THEN 1 ELSE 0 END) AS rejected,
                    SUM(CASE WHEN alerts.auditorStatus = 'duplicate' THEN 1 ELSE 0 END) AS duplicate,
                    SUM(CASE WHEN alerts.auditorStatus IS NULL OR alerts.auditorStatus NOT IN ('approved', 'rejected', 'duplicate') THEN 1 ELSE 0 END) AS pending,
                    COUNT(alerts.alertId) AS total
                ")
                ->where('name', 'like' , $sc)
                ->groupBy('alerts.analisId', 'users.name')
                ->paginate($this->paginate);
        return $query;
    }
    public function render()
    {
        $alerts = $this->getAlerts();
        return view('livewire.check-alert-analis', compact('alerts'));
    }
}
