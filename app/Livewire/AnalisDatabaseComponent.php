<?php

namespace App\Livewire;

use App\Events\UpdateAuditor;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class AnalisDatabaseComponent extends Component
{
    use WithPagination;
    public $isReason = false;
    public $search = '';
    public $alertId, $alertStatus, $alertReason;
    public $dataField = 'alertId', $dataOrder = 'asc', $paginate = 50, $yearAlert, $selectStatus;

     public function mount(){
        $this->yearAlert = session('yearAlert');
        session()->has('selectStatus') ? $this->selectStatus = session('selectStatus') : $this->selectStatus = 'all';
    }

    public function updatedYearAlert($value){
        session(['yearAlert' => $value]);
        $this->resetPage();
    }

    public function updatedSelectStatus($value){
        session(['selectedStatus' => $value]);
        $this->resetPage();
    }

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
        if ($this->alertStatus === 'reexportimage') {
            $newStatus = 'pre-approved';
        } elseif ($this->alertStatus === 'reclassification') {
            $newStatus = 'refined';
        } else {
            $newStatus = null;
        }


        event(new UpdateAuditor);
        DB::table('alerts')->where('alertId', $id)->update([
            'auditorStatus' => $newStatus,
            'auditorReason' => null,
            'updated_at' => Carbon::now('Asia/Jakarta')
        ]);
        $this->dispatch('fix-alert');
        $this->closeReason();
    }

    public function updatedSearch(){
        $this->resetPage();
    }


    #[On('updateStatus')]
    public function updateStatus($id, $status) {
        DB::table('alerts')->where('alertId', $id)->update([
            'auditorStatus' => $status,
            'updated_at' => Carbon::now('Asia/Jakarta')
        ]);
        Toaster::success('Succesfully change platform status');
     }

    #[On('echo:analis-data,UpdateAnalis')]
    public function getAlerts(){
        $sc = '%' . $this->search . '%';
        try {
            $query = DB::table('alerts')
                ->select('id', 'alertId', 'alertStatus', 'detectionDate', 'region', 'province', 'auditorStatus', 'auditorReason', 'created_at', 'platformStatus')
                ->where('analisId', session('id'))
                ->where('isActive', 1);

            if (!empty($this->search)) {
                $query->where('alertId', $this->search);
            }

            if ($this->selectStatus !== 'all') {
                $query->where('auditorStatus', $this->selectStatus);
            }

            if ($this->yearAlert !== 'all') {
                $query->whereYear('detectionDate', $this->yearAlert);
            }

            return $query
                ->paginate($this->paginate);
        } catch (\Throwable $th) {
            return [];
        }
    }
    public function render()
    {
        $databases = $this->getAlerts();
        return view('livewire.analis-database-component', compact('databases'));
    }
}
