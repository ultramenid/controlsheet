<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SummaryAlertCommponent extends Component
{
    public function getAlerts(){
        return $query = DB::table('alerts')
        ->selectRaw("
            COALESCE(auditorStatus, 'Grand Total') AS auditorStatus,
            SUM(CASE WHEN region = 'Bali & Nusa Tenggara' THEN 1 ELSE 0 END) AS `Balinusatenggara`,
            SUM(CASE WHEN region = 'Java' THEN 1 ELSE 0 END) AS `Java`,
            SUM(CASE WHEN region = 'Kalimantan' THEN 1 ELSE 0 END) AS `Kalimantan`,
            SUM(CASE WHEN region = 'Maluku' THEN 1 ELSE 0 END) AS `Maluku`,
            SUM(CASE WHEN region = 'Papua' THEN 1 ELSE 0 END) AS `Papua`,
            SUM(CASE WHEN region = 'Sulawesi' THEN 1 ELSE 0 END) AS `Sulawesi`,
            SUM(CASE WHEN region = 'Sumatra' THEN 1 ELSE 0 END) AS `Sumatra`,
            COUNT(*) AS `grandtotal`
        ")
        ->whereNotNull('auditorStatus')
        ->groupBy('auditorStatus')
        ->union(
            DB::table('alerts')
                ->selectRaw("
                    'Grand Total' AS auditorStatus,
                    SUM(CASE WHEN region = 'Bali & Nusa Tenggara' THEN 1 ELSE 0 END) AS `Balinusatenggara`,
                    SUM(CASE WHEN region = 'Java' THEN 1 ELSE 0 END) AS `Java`,
                    SUM(CASE WHEN region = 'Kalimantan' THEN 1 ELSE 0 END) AS `Kalimantan`,
                    SUM(CASE WHEN region = 'Maluku' THEN 1 ELSE 0 END) AS `Maluku`,
                    SUM(CASE WHEN region = 'Papua' THEN 1 ELSE 0 END) AS `Papua`,
                    SUM(CASE WHEN region = 'Sulawesi' THEN 1 ELSE 0 END) AS `Sulawesi`,
                    SUM(CASE WHEN region = 'Sumatra' THEN 1 ELSE 0 END) AS `Sumatra`,
                    COUNT(*) AS `grandtotal`
                ")
                ->whereNotNull('auditorStatus')
        )
        ->orderByRaw("CASE WHEN auditorStatus = 'Grand Total' THEN 1 ELSE 0 END, grandtotal DESC")
        ->get();

    }
    public function render()
    {
        // dd($this->getAlerts());
        $alerts = $this->getAlerts();
        return view('livewire.summary-alert-commponent', compact('alerts'));
    }
}
