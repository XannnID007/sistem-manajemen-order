<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'nik' => 'required|digits:16|unique:users',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'password' => 'required|min:6|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'customer';

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        if ($user->role !== 'customer') {
            abort(403, 'Tidak dapat mengedit admin.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'customer') {
            abort(403, 'Tidak dapat mengedit admin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'nik' => 'required|digits:16|unique:users,nik,' . $user->id,
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'password' => 'nullable|min:6|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Data pelanggan berhasil diperbarui!');
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
