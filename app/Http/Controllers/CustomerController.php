<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Auth::user()->orders()->count();
        $pendingOrders = Auth::user()->orders()->where('status', 'pending')->count();
        $completedOrders = Auth::user()->orders()->where('status', 'confirmed')->count();
        $recentOrders = Auth::user()->orders()->latest()->take(5)->get();

        return view('customer.dashboard', compact('totalOrders', 'pendingOrders', 'completedOrders', 'recentOrders'));
    }

    public function createOrder()
    {
        $setting = Setting::get();
        return view('customer.order-create', compact('setting'));
    }

    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:10',
            'delivery_address' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $setting = Setting::get();
        $validated['order_number'] = Order::generateOrderNumber();
        $validated['user_id'] = Auth::id();
        $validated['total_price'] = $validated['quantity'] * $setting->price_per_unit;
        $validated['status'] = 'pending';

        Order::create($validated);

        return redirect()->route('customer.orders')->with('success', 'Pesanan berhasil dibuat!');
    }

    public function orders()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('customer.orders', compact('orders'));
    }

    public function confirmOrder(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        if ($order->status !== 'delivered') {
            return back()->with('error', 'Pesanan belum dapat dikonfirmasi.');
        }

        $order->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);

        return back()->with('success', 'Pesanan berhasil dikonfirmasi!');
    }
}
