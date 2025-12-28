<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer')->latest();

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('nik', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'customer') {
            abort(403, 'Tidak dapat melihat detail admin.');
        }

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'customer') {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus admin.'], 403);
        }

        // Check if user has orders
        if ($user->orders()->count() > 0) {
            return response()->json(['success' => false, 'message' => 'Tidak dapat menghapus pelanggan yang memiliki riwayat pesanan.'], 400);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'Pelanggan berhasil dihapus!']);
    }
}
