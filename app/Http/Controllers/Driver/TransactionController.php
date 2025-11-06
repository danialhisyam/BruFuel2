<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;


class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest('transaction_date')->get();
        return view('driver.transactions.index', compact('transactions'));
    }
    public function download()
{
    $transactions = \App\Models\Transaction::orderBy('transaction_date', 'desc')->get();

    $filename = 'transactions_report_' . now()->format('Ymd_His') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=$filename",
    ];

    $columns = ['Date', 'Amount', 'Status'];

    $callback = function() use ($transactions, $columns) {
        $file = fopen('php://output', 'w');
        fputcsv($file, $columns);

        foreach ($transactions as $t) {
            fputcsv($file, [
                $t->transaction_date,
                $t->amount,
                ucfirst($t->status),
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}
}
