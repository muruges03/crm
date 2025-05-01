<?php

namespace App\Http\Controllers;

use App\Models\OmTicketSystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{

    public function index()
    {
        $Tickets = OmTicketSystem::where('entity_id', session('entity_id'))
            ->with('type:id,type', 'personal:id,first_name,last_name', 'customer:id,legal_name')
            ->get();

        $months = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        $currentYear = date('Y');
        $startYear = $currentYear - 5;

        $rawData = OmTicketSystem::where('entity_id', session('entity_id'))
            ->whereYear('created_at', '>=', $startYear)
            ->selectRaw('YEAR(date) as year, MONTH(date) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderByRaw('year ASC, month ASC')
            ->get()
            ->groupBy('year')
            ->map(function ($yearlyData) {
                return $yearlyData->mapWithKeys(function ($item) {
                    return [$item->month => $item->total];
                })->toArray();
            })
            ->toArray();

        $formattedData = [];
        foreach (range($startYear, $currentYear) as $year) {
            $yearData = [];

            foreach ($months as $index => $monthName) {
                $monthNumber = $index + 1;

                $total = $rawData[$year][$monthNumber] ?? 0;

                $yearData[] = [
                    'month' => $monthName,
                    'year' => $year,
                    'total' => $total
                ];
            }

            $formattedData[] = [
                'year' => $year,
                'data' => $yearData
            ];
        }

        return Inertia::render('Dashboard', compact('Tickets', 'formattedData'));
    }


    public function EngineerData(Request $request)
    {
        if ($request->date) {
            $startDate = $request->date[0];
            $endDate = $request->date[1];
        } else {
            $startDate = now()->toDateString();
            $endDate = now()->toDateString();
        }
        $Tickets = OmTicketSystem::whereBetween(DB::raw('DATE(date)'), [$startDate, $endDate])->where([['entity_id', session('entity_id')], ['service_by', $request->id]])
            ->with('type:id,type', 'personal:id,first_name,last_name', 'customer:id,legal_name')
            ->get();
        return response()->json([$Tickets, $startDate, $endDate]);
    }

    public function DateWiseData(Request $request)
    {
        if ($request->date) {
            $startDate = $request->date[0];
            $endDate = $request->date[1];
        } else {
            $startDate = now()->toDateString();
            $endDate = now()->toDateString();
        }
        $Tickets = OmTicketSystem::whereBetween(DB::raw('DATE(date)'), [$startDate, $endDate])->where([['entity_id', session('entity_id')]])
            ->with('type:id,type', 'personal:id,first_name,last_name', 'customer:id,legal_name')
            ->get();
        return response()->json([$Tickets, $startDate, $endDate]);
    }
}
