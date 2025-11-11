<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();
        $deliveredOrders = Order::where('status', 'delivered')->count();
        $totalCustomers = User::where('role', 'customer')->count();
        $totalRevenue = Order::where('status', 'confirmed')->sum('total_price');
        $recentOrders = Order::with('user')->latest()->take(10)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'deliveredOrders',
            'totalCustomers',
            'totalRevenue',
            'recentOrders'
        ));
    }

    public function orders(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($q) use ($request) {
                        $q->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $orders = $query->paginate(15);
        return view('admin.orders', compact('orders'));
    }

    public function updateOrderStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,delivered,cancelled',
        ]);

        $order->update($validated);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }

    public function history(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(20);
        $totalRevenue = $query->where('status', 'confirmed')->sum('total_price');
        $totalQuantity = $query->where('status', 'confirmed')->sum('quantity');

        return view('admin.history', compact('orders', 'totalRevenue', 'totalQuantity'));
    }

    public function printReport(Request $request)
    {
        $query = Order::with('user')->latest();

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->get();
        $setting = Setting::get();
        $totalRevenue = $orders->where('status', 'confirmed')->sum('total_price');
        $totalQuantity = $orders->where('status', 'confirmed')->sum('quantity');

        return view('admin.report-print', compact('orders', 'setting', 'totalRevenue', 'totalQuantity'));
    }

    public function exportExcel(Request $request)
    {
        $dateFrom = $request->filled('date_from') ? $request->date_from : null;
        $dateTo = $request->filled('date_to') ? $request->date_to : null;
        $status = $request->filled('status') ? $request->status : null;

        $fileName = 'Laporan_Pemesanan_' . date('YmdHis') . '.xlsx';

        return Excel::download(
            new \App\Exports\OrdersExport($dateFrom, $dateTo, $status),
            $fileName
        );
    }

    public function settings()
    {
        $setting = Setting::get();
        $user = Auth::user();
        return view('admin.settings', compact('setting', 'user'));
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'pangkalan_name' => 'required|string|max:255',
            'pangkalan_address' => 'required|string',
            'pangkalan_phone' => 'required|string|max:15',
            'price_per_unit' => 'required|numeric|min:0',
            'logo' => 'nullable|image|max:2048',
        ]);

        $setting = Setting::get();

        if ($request->hasFile('logo')) {
            if ($setting->logo) {
                Storage::delete('public/' . $setting->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $setting->update($validated);

        return back()->with('success', 'Pengaturan berhasil diperbarui!');
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:6|confirmed',
        ]);

        $user = Auth::user();

        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password saat ini salah.']);
            }
            $validated['password'] = Hash::make($request->new_password);
        }

        $user->update($validated);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
