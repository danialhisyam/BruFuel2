<?php

// routes/api.php
use App\Models\Payment;

Route::get('/payments', function () {
    return Payment::orderByDesc('paid_at')->orderByDesc('created_at')
      ->get()
      ->map(fn($p)=>[
        'id'       => 'ORD-'.str_pad($p->id,4,'0',STR_PAD_LEFT),
        'name'     => $p->customer_name,
        'provider' => $p->provider,
        'status'   => $p->status,     // Paid | Pending | Fail
        'amount'   => (float)$p->amount,
        'date'     => optional($p->paid_at ?? $p->created_at)->toIso8601String(),
      ]);
});

