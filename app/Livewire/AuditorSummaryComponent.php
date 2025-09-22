<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AuditorSummaryComponent extends Component
{
    public $startDate , $endDate , $rangeAuditor;

    public function filter(){
        $rows = DB::table('auditorlog')
            ->join('users', 'users.id', '=', 'auditorlog.auditorId')
            ->select(
                'users.name as auditorName',
                DB::raw("DATE(auditorlog.created_at) as d"),
                DB::raw("COUNT(auditorlog.alertId) as total")
            )
            ->whereBetween(DB::raw("DATE(auditorlog.created_at)"), [$this->startDate, $this->endDate])
            ->groupBy('users.name', 'd')
            ->get();

        $results = [];

        foreach ($rows as $row) {
            if (!isset($results[$row->auditorName])) {
                $results[$row->auditorName]['auditorName'] = $row->auditorName;
            }
            $results[$row->auditorName][$row->d] = $row->total;
        }
        return $results;
    }



    public function render()
    {
        // dd($this->filter());
        $results = $this->filter();
        return view('livewire.auditor-summary-component', compact('results'));
    }
}
