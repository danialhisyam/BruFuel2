<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = $this->applyFilters(Payment::query(), $request);

        // Table rows (paginate + keep filters)
        $payments = $query->latest('paid_at')->latest('created_at')
            ->paginate(50)
            ->withQueryString();

        // KPI metrics (based on the filtered set)
        $kpiBase = $this->applyFilters(Payment::query(), $request);
        $totalRevenue      = (clone $kpiBase)->where('status', 'Paid')->sum('amount');
        $totalTransactions = (clone $kpiBase)->count();
        $pending           = (clone $kpiBase)->where('status', 'Pending')->count();
        $failed            = (clone $kpiBase)->where('status', 'Fail')->count();

        // Distinct providers for dropdown
        $providers = Payment::select('provider')->distinct()->orderBy('provider')->pluck('provider');

        // Monthly chart (filtered + Paid only)
        $chart = (clone $kpiBase)
            ->where('status', 'Paid')
            ->whereNotNull('paid_at')
            ->selectRaw("MONTH(paid_at) as m_idx, DATE_FORMAT(paid_at, '%b') as m_name, SUM(amount) as total")
            ->groupBy('m_idx', 'm_name')
            ->orderBy('m_idx')
            ->get();

        $chartLabels = $chart->pluck('m_name');
        $chartData   = $chart->pluck('total');

        return view('admin.payment', compact(
            'payments','totalRevenue','totalTransactions','pending','failed','providers','chartLabels','chartData'
        ));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $rows = $this->applyFilters(Payment::query(), $request)
            ->latest('paid_at')->latest('created_at')
            ->get();

        $filename = 'payments-'.now()->toDateString().'.csv';

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['OrderID','Name','Provider','Status','Amount_BND','Paid At']);
            foreach ($rows as $p) {
                fputcsv($out, [
                    'ORD-'.str_pad($p->id, 4, '0', STR_PAD_LEFT),
                    $p->customer_name,
                    $p->provider,
                    $p->status,
                    number_format($p->amount, 2, '.', ''),
                    optional($p->paid_at ?? $p->created_at)->format('Y-m-d H:i'),
                ]);
            }
            fclose($out);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function exportExcel(Request $request): StreamedResponse
    {
        // Excel-friendly CSV to avoid extra package installs
        $rows = $this->applyFilters(Payment::query(), $request)
            ->latest('paid_at')->latest('created_at')
            ->get();

        $filename = 'payments-'.now()->toDateString().'.xlsx'; // still CSV content

        return response()->streamDownload(function () use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['OrderID','Name','Provider','Status','Amount_BND','Paid At']);
            foreach ($rows as $p) {
                fputcsv($out, [
                    'ORD-'.str_pad($p->id, 4, '0', STR_PAD_LEFT),
                    $p->customer_name,
                    $p->provider,
                    $p->status,
                    number_format($p->amount, 2, '.', ''),
                    optional($p->paid_at ?? $p->created_at)->format('Y-m-d H:i'),
                ]);
            }
            fclose($out);
        }, $filename, [
            'Content-Type' => 'application/vnd.ms-excel',
        ]);
    }

    /** Apply all filters coming from the UI */
    private function applyFilters($query, Request $request)
    {
        // Search (customer_name, provider, or exact ORD-####)
        if ($s = trim($request->get('search', ''))) {
            $query->where(function ($q) use ($s) {
                // Parse ORD-####
                $id = null;
                if (preg_match('/ord-(\d+)/i', $s, $m)) $id = (int)$m[1];
                $q->when($id, fn($qq) => $qq->orWhere('id', $id))
                  ->orWhere('customer_name', 'like', "%{$s}%")
                  ->orWhere('provider', 'like', "%{$s}%");
            });
        }

        if ($status = $request->get('status')) {
            if ($status !== 'All') $query->where('status', $status);
        }

        if ($provider = $request->get('provider')) {
            if ($provider !== 'All') $query->where('provider', $provider);
        }

        // Date range (paid_at preferred; fallback to created_at)
        $from = $request->get('from');
        $to   = $request->get('to');
        if ($from) {
            $query->whereDate('paid_at', '>=', $from)
                  ->orWhere(function($q) use ($from){
                      $q->whereNull('paid_at')->whereDate('created_at', '>=', $from);
                  });
        }
        if ($to) {
            $query->whereDate('paid_at', '<=', $to)
                  ->orWhere(function($q) use ($to){
                      $q->whereNull('paid_at')->whereDate('created_at', '<=', $to);
                  });
        }

        return $query;
    }
}
