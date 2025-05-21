<?php

namespace App\Livewire;

use App\Events\UpdateAnalis;
use App\Exports\ValidatorExport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class AlertAnalisComponent extends Component
{
    public $analisId;

    use WithPagination;
    public $isAudit = false;
    public $alertId, $alertStatus, $alertReason, $analis, $alertNote, $observation;
    public $dataField = 'alertId', $dataOrder = 'asc', $paginate = 10, $searchId;
    public $deleter = false, $alertDeleteId, $selectStatus, $yearAlert;


     // https://laravel-excel.com/
    public function exportExcel(){
        return  Excel::download(new ValidatorExport($this->selectStatus, $this->yearAlert, $this->analisId), 'ValidatorExport.xlsx');
    }

    public function getAnalisName($id){
        return DB::table('users')->where('id', $id)->first();
    }
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
        $this->dispatch('alert-deleted');
        $this->closeDelete();
    }

    public function mount($id)
    {
        $this->analisId = $id;
        $this->selectStatus = session('selectStatus');
        $this->yearAlert = session('yearAlert');
    }
    public function updatedYearAlert($value){
        session(['yearAlert' => $value]);
        $this->resetPage();
    }
    public function sortingField($field){
        $this->dataField = $field;
        $this->dataOrder = $this->dataOrder == 'asc' ? 'desc' : 'asc';
    }
    public function updatedSearchId(){
        $this->resetPage();
    }

    public function updatedSelectStatus($value){
        session(['selectStatus' => $value]);
        // dd(session()/->all());
        $this->resetPage();
    }

    #[On('echo:analis-data,UpdateAnalis')]
    #[On('echo:auditor-data,UpdateAuditor')]
    public function getAlerts(){
        $sc = '%' . $this->searchId . '%';
        try {
            return  DB::table('alerts')
                        ->where('alertId', 'like' , $sc)
                        ->where('analisId', $this->analisId)
                        ->when($this->selectStatus === 'pending', function ($query) {
                            return $query->whereNull('auditorStatus');
                        })
                        ->when($this->yearAlert != 'all', function ($query) {
                            return $query->whereYear('detectionDate', $this->yearAlert);
                        })
                        ->orderBy($this->dataField, $this->dataOrder)
                        ->paginate($this->paginate);
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function closeReason(){
        $this->selectStatus = session('selectStatus');
        redirect()->to(url()->previous());
        // dd(session()->all());
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
    public function showAudit($id){
        $this->isAudit = true;
        //load data to delete function
        $data = DB::table('alerts')
        ->join('users', 'analisId', '=', 'users.id')
        ->select('alerts.*', 'users.*')
        ->where('alertId', $id)->first();
        $this->alertId = $data->alertId;
        $this->analis = $data->name;
        $this->observation = $data->observation;
        $this->alertNote = $data->alertNote;

    }

    public function render()
    {
        // dd($this->getAlerts());
        $databases = $this->getAlerts();
        $analisName = $this->getAnalisName($this->analisId);
        return view('livewire.alert-analis-component', compact('databases', 'analisName'));
    }
}
