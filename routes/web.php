<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Livewire\CheckoutComponent;

// ✅ Temporary helper to simulate a cart
Route::get('/set-total/{amount}', function ($amount) {
    session(['cart_total' => $amount]);
    return "Cart total set to B$$amount";
});

Route::get('/checkout', CheckoutComponent::class)->name('checkout');

Route::get('/payment-success', function (Illuminate\Http\Request $request) {
    $amount = $request->query('amount', 'B$0');
    return view('payment-success', ['amount' => $amount]);
})->name('payment.success');

Route::redirect('/dashboard', '/checkout')->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
});

