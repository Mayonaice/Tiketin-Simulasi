<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        // If user is petugas, only show regular users and petugas (no admins)
        if (Auth::user()->isPetugas()) {
            $users = User::where('role', '!=', 'admin')->latest()->paginate(10);
        } else {
            $users = User::latest()->paginate(10);
        }
        
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create', [
            'isAdmin' => Auth::user()->isAdmin()
        ]);
    }

    public function store(Request $request)
    {
        // Define available roles based on current user's role
        $availableRoles = Auth::user()->isAdmin() ? ['admin', 'petugas', 'user'] : ['petugas', 'user'];
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:' . implode(',', $availableRoles)],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(User $user)
    {
        // Prevent petugas from viewing admin users
        if (Auth::user()->isPetugas() && $user->isAdmin()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak memiliki akses untuk melihat data admin.');
        }
        
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        // Prevent petugas from editing admin users
        if (Auth::user()->isPetugas() && $user->isAdmin()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengubah data admin.');
        }
        
        return view('users.edit', [
            'user' => $user,
            'isAdmin' => Auth::user()->isAdmin()
        ]);
    }

    public function update(Request $request, User $user)
    {
        // Prevent petugas from updating admin users
        if (Auth::user()->isPetugas() && $user->isAdmin()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengubah data admin.');
        }
        
        // Define available roles based on current user's role
        $availableRoles = Auth::user()->isAdmin() ? ['admin', 'petugas', 'user'] : ['petugas', 'user'];
        
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:' . implode(',', $availableRoles)],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Prevent petugas from deleting admin users
        if (Auth::user()->isPetugas() && $user->isAdmin()) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus data admin.');
        }
        
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
} 