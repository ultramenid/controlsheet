<?php

namespace App\Livewire;

use App\Events\UpdateAuditor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class TableAnalisis extends Component
{
    use WithPagination;
    public $isReason = false;
    public $search = '';
    public $alertId, $alertStatus, $alertReason;
    public $dataField = 'alertId', $dataOrder = 'asc', $paginate = 10;

    public function sortingField($field){
        $this->dataField = $field;
        $this->dataOrder = $this->dataOrder == 'asc' ? 'desc' : 'asc';
    }

    public function closeReason(){
        $this->isReason = false;
        $this->alertId = null;
        $this->alertStatus = null;
        $this->alertReason = null;
    }

    public function showReason($id){
        $this->isReason = true;
        //load data to delete function
        $data = DB::table('alerts')->where('id', $id)->first();
        $this->alertId = $data->alertId;
        $this->alertStatus = $data->auditorStatus;
        $this->alertReason = $data->auditorReason;
    }


    public function fixAlert($id){
        event(new UpdateAuditor);
        DB::table('alerts')->where('alertId', $id)->update([
            'auditorStatus' => null,
            'auditorReason' => null,
            'updated_at' => Carbon::now('Asia/Jakarta')
        ]);
        $this->dispatch('fix-alert');
        $this->closeReason();
    }

    public function updatedSearch(){
        $this->resetPage();
    }

    #[On('echo:analis-data,UpdateAnalis')]
    public function getAlerts(){
        $sc = '%' . $this->search . '%';
        try {
            return  DB::table('alerts')
                        ->select('id','alertId', 'alertStatus','detectionDate', 'region', 'province', 'auditorStatus', 'auditorReason', 'created_at')
                        ->where('analisId', session('id'))
                        ->where('auditorStatus', '!=', null)
                        ->where('auditorStatus', '!=', 'approved')
                        ->where('auditorStatus', '!=', 'rejected')
                        ->where('auditorStatus', '!=', 'duplicate')
                        ->where('alertId', 'like' , $sc)
                        ->where('isActive', 1)
                        ->orderBy($this->dataField, $this->dataOrder)
                        ->paginate($this->paginate);
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function render()
    {
        $databases = $this->getAlerts();
        return view('livewire.table-analisis', compact('databases'));
    }
}
