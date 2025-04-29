<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    /**
     * Display a listing of all users.
     */
    public function index()
    {
        // Petugas can only manage regular users, not other petugas or admins
        $users = User::where('role', 'user')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Password::defaults()],
            'role' => ['required', 'string', Rule::in(['user'])], // Petugas can only create regular users
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Ensure petugas can only access user accounts
        if ($user->role !== 'user') {
            return redirect()->route('users.index')->with('error', 'Anda tidak memiliki akses untuk melihat pengguna ini.');
        }
        
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        // Ensure petugas can only edit user accounts
        if ($user->role !== 'user') {
            return redirect()->route('users.index')->with('error', 'Anda tidak memiliki akses untuk mengedit pengguna ini.');
        }
        
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        // Ensure petugas can only update user accounts
        if ($user->role !== 'user') {
            return redirect()->route('users.index')->with('error', 'Anda tidak memiliki akses untuk mengubah pengguna ini.');
        }
        
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', Rule::in(['user'])], // Ensure role can't be changed to anything else
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Only update password if a new one is provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => ['required', Password::defaults()],
            ]);
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Ensure petugas can only delete user accounts
        if ($user->role !== 'user') {
            return redirect()->route('users.index')->with('error', 'Anda tidak memiliki akses untuk menghapus pengguna ini.');
        }
        
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus!');
    }
} 