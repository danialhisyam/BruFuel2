<?php

use App\Models\Payment;
use Illuminate\Support\Facades\Route;

Route::get('/payments', function () {
    return Payment::all()->map(fn($p) => [
        'id'       => $p->id,
        'name'     => $p->customer_name,
        'provider' => $p->provider,
        'status'   => $p->status,
        'amount'   => $p->amount,
        'date'     => $p->paid_at->toISOString(),
    ]);
});
