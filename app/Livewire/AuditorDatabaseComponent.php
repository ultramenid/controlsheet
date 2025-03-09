<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class AuditorDatabaseComponent extends Component
{
    use WithPagination;
    public $isAudit = false;
    public $alertId, $alertStatus, $alertReason, $analis;
    public $dataField = 'alertId', $dataOrder = 'asc', $paginate = 10;

    public function sortingField($field){
        $this->dataField = $field;
        $this->dataOrder = $this->dataOrder == 'asc' ? 'desc' : 'asc';
    }

    public function closeReason(){
        redirect()->to(url()->previous());
    }

    public function auditing($alertId){
        if($this->manualValidation()){
            DB::table('alerts')->where('alertId', $alertId)->update([
                'auditorStatus' => $this->alertStatus,
                'auditorReason' => $this->alertReason,
                'updated_at' => Carbon::now('Asia/Jakarta')
            ]);
            redirect()->to(url()->previous());
        }
    }

    public function showAudit($id){
        $this->isAudit = true;
        //load data to delete function
        $data = DB::table('alerts')
        ->join('users', 'analisId', '=', 'users.id')
        ->select('alerts.*', 'users.*')
        ->where('alertId', $id)->first();
        $this->alertId = $data->alertId;
        $this->analis = $data->name;

    }

    public function getAlerts(){
        // $sc = '%' . $this->search . '%';
        try {
            return  DB::table('alerts')
                        ->join('users', 'analisId', '=', 'users.id')
                        ->select('alerts.*', 'users.*')
                        // ->where('analisId', session('id'))
                        ->orderBy($this->dataField, $this->dataOrder)
                        ->paginate($this->paginate);
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function render()
    {
        $databases = $this->getAlerts();
        return view('livewire.auditor-database-component', compact('databases'));
    }

    public function manualValidation(){
        if($this->alertStatus == ''){
            Toaster::error('Alert status is required!');
            return;
        }elseif($this->alertReason == '' and $this->alertStatus != 'approved'){
            Toaster::error('Alert reason is required!');
            return;
        }
        return true;
    }
}
