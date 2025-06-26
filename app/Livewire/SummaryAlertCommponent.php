<?php

namespace App\Livewire;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class SummaryAlertCommponent extends Component
{

    public $yearAlert;

    public function mount(){
        $this->yearAlert = Carbon::now()->format('Y');
    }

    #[On('filterYear')]
    public function updateData($year)
    {
        $this->yearAlert = $year;
    }

    #[On('echo:analis-data,UpdateAnalis')]
    #[On('echo:auditor-data,UpdateAuditor')]
    public function getAlerts(){
        $query = DB::table('alerts')
        ->selectRaw("
            COALESCE(auditorStatus, 'Pending') AS auditorStatus,
            SUM(CASE WHEN region = 'Bali & Nusa Tenggara' THEN 1 ELSE 0 END) AS `Balinusatenggara`,
            SUM(CASE WHEN region = 'Java' THEN 1 ELSE 0 END) AS `Java`,
            SUM(CASE WHEN region = 'Kalimantan' THEN 1 ELSE 0 END) AS `Kalimantan`,
            SUM(CASE WHEN region = 'Maluku' THEN 1 ELSE 0 END) AS `Maluku`,
            SUM(CASE WHEN region = 'Papua' THEN 1 ELSE 0 END) AS `Papua`,
            SUM(CASE WHEN region = 'Sulawesi' THEN 1 ELSE 0 END) AS `Sulawesi`,
            SUM(CASE WHEN region = 'Sumatra' THEN 1 ELSE 0 END) AS `Sumatra`,
            COUNT(*) AS `TOTAL`
        ")
        ->when($this->yearAlert !== 'all', function ($query) {
            $query->whereYear('detectionDate', $this->yearAlert);
        })
        ->where('isActive', 1)
        ->groupBy('auditorStatus')
        ->get();

    // Add Grand Total manually
    $grandTotal = [
        'auditorStatus' => 'Grand Total',
        'Balinusatenggara' => $query->sum('Balinusatenggara'),
        'Java' => $query->sum('Java'),
        'Kalimantan' => $query->sum('Kalimantan'),
        'Maluku' => $query->sum('Maluku'),
        'Papua' => $query->sum('Papua'),
        'Sulawesi' => $query->sum('Sulawesi'),
        'Sumatra' => $query->sum('Sumatra'),
        'TOTAL' => $query->sum('TOTAL'),
    ];

    // Convert Laravel collection to array of associative arrays
    $finalResults = json_decode(json_encode($query), true);

    // Append Grand Total
    $finalResults[] = $grandTotal;

    // Sort manually: Place "Pending" first, then by TOTAL descending, and "Grand Total" at the end
    usort($finalResults, function ($a, $b) {
        if ($a['auditorStatus'] === 'Grand Total') return 1;
        if ($b['auditorStatus'] === 'Grand Total') return -1;
        if ($a['auditorStatus'] === 'Pending') return -1;
        if ($b['auditorStatus'] === 'Pending') return 1;
        return $b['TOTAL'] <=> $a['TOTAL'];
    });

    // Return the final sorted result
    return $finalResults;

    }
    public function render()
    {
        // dd($this->getAlerts());
        $alerts = $this->getAlerts();
        return view('livewire.summary-alert-commponent', compact('alerts'));
    }
}
