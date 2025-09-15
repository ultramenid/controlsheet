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

    public $alertId;

    public $alertStatus;

    public $alertReason;

    public $analis;

    public $alertNote;

    public $observation;

    public $dataField = 'alertId';

    public $dataOrder = 'asc';

    public $paginate = 25;

    public $searchId;

    public $deleter = false;

    public $alertDeleteId;

    public $selectStatus;

    public $yearAlert;

    public function mount()
    {
        $this->selectStatus = session('selectStatus');
        $this->yearAlert = session('yearAlert');
    }

    public function updatedYearAlert($value)
    {
        session(['yearAlert' => $value]);
        $this->resetPage();
    }

    public function closeDelete()
    {
        $this->deleter = false;
        $this->alertDeleteId = null;
    }

    public function deleteAlert($alertId)
    {

        // load data to delete function
        $dataDelete = DB::table('alerts')->where('alertId', $alertId)->first();
        $this->alertDeleteId = $dataDelete->alertId;
        $this->deleter = true;
    }

    public function deleting($alertId)
    {
        DB::table('alerts')
            ->where('alertId', $alertId)
            ->delete();

        DB::table('auditorlog')->insert([
            'auditorId' => session('id'),
            'alertId' => $alertId,
            'ngapain' => 'deleting',
            'created_at' => Carbon::now('Asia/Jakarta'),
        ]);
        Toaster::success('Success deleting Alert');
        $this->closeDelete();
        event(new UpdateAnalis);
        event(new UpdateAuditor);

    }

    public function sortingField($field)
    {
        $this->dataField = $field;
        $this->dataOrder = $this->dataOrder == 'asc' ? 'desc' : 'asc';
    }

    public function closeReason()
    {
        $this->selectStatus = session('selectStatus');
        redirect()->to(url()->previous());
        // dd(session()->all());
    }

    public function auditing($alertId)
    {
        event(new UpdateAnalis);
        if ($this->manualValidation()) {
            DB::table('alerts')->where('alertId', $alertId)->update([
                'auditorStatus' => $this->alertStatus,
                'auditorReason' => $this->alertReason,
                'updated_at' => Carbon::now('Asia/Jakarta'),
            ]);
            DB::table('auditorlog')->insert([
                'auditorId' => session('id'),
                'alertId' => $alertId,
                'ngapain' => 'auditing',
                'created_at' => Carbon::now('Asia/Jakarta'),
            ]);
            redirect()->to(url()->previous());
        }

    }

    public function updatedSearchId()
    {
        $this->resetPage();
    }

    public function updatedSelectStatus($value)
    {
        session(['selectStatus' => $value]);
        // dd(session()/->all());
        $this->resetPage();
    }

    public function showAudit($id)
    {
        $this->isAudit = true;
        // load data to delete function
        $data = DB::table('alerts')
            ->join('users', 'analisId', '=', 'users.id')
            ->select('alerts.*', 'users.*')
            ->where('alertId', $id)->first();
        $this->alertId = $data->alertId;
        $this->analis = $data->name;
        $this->observation = $data->observation;
        $this->alertNote = $data->alertNote;

    }

    #[On('echo:analis-data,UpdateAnalis')]
    #[On('echo:auditor-data,UpdateAuditor')]
    public function getAlerts()
    {
        // $sc = '%'.$this->searchId.'%';
        try {
            return DB::table('alerts')
                ->when(!empty($this->searchId), function ($query) {
                    return $query->where('alertId', $this->searchId);
                })
                ->when($this->selectStatus === 'pending', function ($query) {
                    return $query->whereNull('auditorStatus');
                })
                ->when($this->yearAlert != 'all', function ($query) {
                    return $query->whereYear('detectionDate', $this->yearAlert);
                })
                ->where('isActive', 1)
                ->orderBy($this->dataField, $this->dataOrder)
                ->cursorPaginate($this->paginate);
        } catch (\Throwable $th) {
            return [];
        }
    }

    public function render()
    {
        $databases = $this->getAlerts();

        // dd($databases);
        return view('livewire.auditor-database-component', compact('databases'));
    }

    public function manualValidation()
    {
        if ($this->alertStatus == '') {
            Toaster::error('Alert status is required!');

            return;
        } elseif ($this->alertReason == '' and $this->alertStatus != 'approved') {
            Toaster::error('Alert reason is required!');

            return;
        }

        return true;
    }
}
