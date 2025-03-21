<?php

namespace App\Livewire;

use App\Events\UpdateAnalis;
use App\Events\UpdateAuditor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class AuditorDatabaseComponent extends Component
{
    use WithPagination;
    public $isAudit = false;
    public $alertId, $alertStatus, $alertReason, $analis, $alertNote;
    public $dataField = 'alertId', $dataOrder = 'asc', $paginate = 10, $searchId;
    public $deleter = false, $alertDeleteId, $selectStatus = 'all';

    public function closeDelete(){
        $this->deleter = false;
        $this->alertDeleteId = null;
    }
    public function deleteAlert($alertId){

        //load data to delete function
        $dataDelete = DB::table('alerts')->where('alertId', $alertId)->first();
        $this->alertDeleteId = $dataDelete->alertId;
        $this->deleter = true;
    }
    public function deleting($alertId){
        DB::table('alerts')->where('alertId', $alertId)->delete();
        Toaster::success('Success deleting Alert');
        $this->closeDelete();
        event(new UpdateAnalis);
        event(new UpdateAuditor);

    }

    public function sortingField($field){
        $this->dataField = $field;
        $this->dataOrder = $this->dataOrder == 'asc' ? 'desc' : 'asc';
    }

    public function closeReason(){
        redirect()->to(url()->previous());
    }

    public function auditing($alertId){
        event(new UpdateAnalis);
        if($this->manualValidation()){
            DB::table('alerts')->where('alertId', $alertId)->update([
                'auditorStatus' => $this->alertStatus,
                'auditorReason' => $this->alertReason,
                'updated_at' => Carbon::now('Asia/Jakarta')
            ]);
            redirect()->to(url()->previous());
        }

    }

    public function updatedSearchId(){
        $this->resetPage();
    }

    public function updatedSelectStatus(){
        $this->resetPage();
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
        $this->alertNote = $data->alertNote;

    }

    #[On('echo:auditor-data,UpdateAuditor')]
    public function getAlerts(){
        $sc = '%' . $this->searchId . '%';
        try {
            return  DB::table('alerts')
                        ->join('users', 'analisId', '=', 'users.id')
                        ->select('alerts.*', 'users.*')
                        ->where('alertId', 'like' , $sc)
                        ->when($this->selectStatus === 'pending', function ($query) {
                            return $query->whereNull('alerts.auditorStatus');
                        })
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
