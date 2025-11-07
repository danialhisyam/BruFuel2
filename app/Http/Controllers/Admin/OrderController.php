<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $q      = $request->query('q');
        $status = $request->query('status'); // filter by status if needed

        $orders = Order::query()
            ->with('user')
            ->when($q, function ($s) use ($q) {
                $s->where(function ($x) use ($q) {
                    $x->where('order_no', 'like', "%{$q}%")
                      ->orWhereHas('user', function ($u) use ($q) {
                          $u->where('name', 'like', "%{$q}%")
                            ->orWhere('email', 'like', "%{$q}%");
                      });
                });
            })
            ->when($status, fn ($s) => $s->where('status', $status))
            ->orderByDesc('id')
            ->paginate(12)
            ->withQueryString();

        return view('admin.manage-order', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('user');
        return response()->json($order);
    }

    /**
     * Return count of orders for stats endpoint
     */
    public function count()
    {
        $total = Order::count();
        return response()->json(['count' => $total]);
    }
}

