<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Attributes\On;
use Masmerise\Toaster\Toaster;

class AuditorSummaryComponent extends Component
{
    public $startDate , $endDate , $rangeAuditor, $alertCode, $alertCodeValidator;

    public function mount(){
        $this->startDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $this->endDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $this->rangeAuditor = $this->startDate.' to '.$this->endDate;
    }


    public function find(){
        $find = DB::table('auditorlog')
            ->where('alertId', $this->alertCode)
            ->join('users', 'users.id', '=', 'auditorlog.auditorId')
            ->select('users.name as auditorName', 'users.id as auditorId')
            ->orderBy('auditorlog.created_at', 'desc')
            ->first();

        try {
            Toaster::success('Alert ID '.$this->alertCode.' audited by '.$find->auditorName);
        } catch (\Exception $e) {
            Toaster::error('Alert ID '.$this->alertCode.' not found in auditor log');
            return;
        }

    }

    public function getStatus($alertId){
        // if the auditorStatus == null return 'Pending'
        $status = DB::table('alerts')
            ->where('alertId', $alertId)
            ->select('auditorStatus')
            ->first();
        if($status->auditorStatus == null){
            return 'pending';
        }else{
            return $status->auditorStatus ;
        }
    }
    public function findValidator(){
        // dd($this->getStatus($this->alertCodeValidator));
        $find = DB::table('alerts')
            ->where('alertId', $this->alertCodeValidator)
            ->join('users', 'users.id', '=', 'alerts.analisId')
            ->select('users.name as auditorName', 'users.id as auditorId')
            ->first();

        try {
            Toaster::success('Alert ID '.$this->alertCode.' validated by '.$find->auditorName. ' with status '.$this->getStatus($this->alertCodeValidator));
        } catch (\Exception $e) {
            Toaster::error('Alert ID '.$this->alertCode.' not found in alert database');
            return;
        }

    }

    #[On('echo:analis-data,UpdateAnalis')]
    #[On('echo:auditor-data,UpdateAuditor')]
    public function filter(){
        $rows = DB::table('auditorlog')
            ->join('users', 'users.id', '=', 'auditorlog.auditorId')
            ->select(
                'users.name as auditorName',
                'users.id as auditorId',
                DB::raw("DATE(auditorlog.created_at) as d"),
                DB::raw("COUNT(auditorlog.alertId) as total")
            )
            ->whereBetween(DB::raw("DATE(auditorlog.created_at)"), [$this->startDate, $this->endDate])
            ->where('ngapain', '=' ,'auditing')
            ->groupBy('users.name', 'users.id', DB::raw("DATE(auditorlog.created_at)"))
            ->get();

        $results = [];

        foreach ($rows as $row) {
            if (!isset($results[$row->auditorName])) {
                $results[$row->auditorName]['auditorName'] = $row->auditorName;
                $results[$row->auditorName]['auditorId']   = $row->auditorId;
            }
            $results[$row->auditorName][$row->d] = $row->total;
        }

        $period = new \DatePeriod(
            new \DateTime($this->startDate),
            new \DateInterval('P1D'),
            (new \DateTime($this->endDate))->modify('+1 day')
        );

        foreach ($period as $dt) {
            $allDates[] = $dt->format('Y-m-d');
        }

        // fill missing dates with 0 + add Total
        foreach ($results as &$row) {
            $total = 0;

            foreach ($allDates as $d) {
                if (!isset($row[$d])) {
                    $row[$d] = 0;
                }
                $total += $row[$d];
            }

            $row['Total'] = $total;

            // reorder keys: auditorName, auditorId, dates..., Total
            $ordered = [
                'auditorName' => $row['auditorName'],
                'auditorId'   => $row['auditorId']
            ];

            foreach ($allDates as $d) {
                $ordered[$d] = $row[$d];
            }

            $ordered['Total'] = $total;

            $row = $ordered;
        }
        unset($row);

        return $results;

    }



    public function render()
    {
        // dd($this->filter());
        $results = $this->filter();
        return view('livewire.auditor-summary-component', compact('results'));
    }
}
