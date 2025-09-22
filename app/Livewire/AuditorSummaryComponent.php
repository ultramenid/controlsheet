<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Livewire\Attributes\On;

class AuditorSummaryComponent extends Component
{
    public $startDate, $endDate , $rangeAuditor;

    public function mount(){
        $this->startDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $this->endDate = Carbon::now('Asia/Jakarta')->format('Y-m-d');
        $this->rangeAuditor = $this->startDate.' to '.$this->endDate;
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
            ->groupBy( 'users.name', 'users.id', DB::raw("DATE(auditorlog.created_at)"))
            ->get();

        $results = [];

        foreach ($rows as $row) {

            if (!isset($results[$row->auditorName])) {
                $results[$row->auditorName]['auditorName'] = $row->auditorName;
                $results[$row->auditorName]['auditorId'] = $row->auditorId;

            }
            $results[$row->auditorName][$row->d] = $row->total;
        }

        $period = new \DatePeriod(
            new \DateTime($this->startDate),
            new \DateInterval('P1D'),
            (new \DateTime($this->endDate))->modify('+1 day')
        );
        foreach ($period as $dt) { $allDates[] = $dt->format('Y-m-d'); }
        // fill missing dates with 0
        foreach ($results as &$row) {
            foreach ($allDates as $d) {
                if (!isset($row[$d])) {
                    $row[$d] = 0;
                }
            }
            ksort($row); // keep auditorName first, then dates in order
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
