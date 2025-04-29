@extends('layouts.dashboard')

@section('content')
<div class="container mx-auto px-4">
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Detail Pengguna</h1>
        <div class="flex items-center text-sm text-gray-500 mt-2">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600">Dashboard</a>
            <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="{{ route('users.index') }}" class="hover:text-blue-600">Manajemen Pengguna</a>
            <svg class="h-4 w-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-blue-600">Detail Pengguna</span>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-semibold text-gray-800">Informasi Pengguna</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('users.edit', $user) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2">
                        Edit
                    </a>
                    <a href="{{ route('users.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Kembali
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Nama Lengkap</h3>
                        <p class="mt-1 text-lg text-gray-900">{{ $user->name }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Email</h3>
                        <p class="mt-1 text-lg text-gray-900">{{ $user->email }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Role</h3>
                        <p class="mt-1">
                            <span class="px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                                @if($user->role == 'admin') bg-purple-100 text-purple-800 
                                @elseif($user->role == 'petugas') bg-blue-100 text-blue-800 
                                @else bg-green-100 text-green-800 @endif">
                                {{ ucfirst($user->role) }}
                            </span>
                        </p>
                    </div>
                </div>
                <div>
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Tanggal Registrasi</h3>
                        <p class="mt-1 text-lg text-gray-900">{{ $user->created_at->format('d F Y, H:i') }}</p>
                    </div>
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-500">Terakhir Diperbarui</h3>
                        <p class="mt-1 text-lg text-gray-900">{{ $user->updated_at->format('d F Y, H:i') }}</p>
                    </div>
                </div>
            </div>

            @if($user->role == 'user')
            <div class="mt-8 border-t pt-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Riwayat Transaksi</h2>
                @if($user->transaksi && $user->transaksi->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Transaksi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($user->transaksi as $transaksi)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $transaksi->kode_transaksi }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-500">{{ $transaksi->tanggal->format('d M Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">Rp {{ number_format($transaksi->total, 0, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            @if($transaksi->status_pembayaran == 'lunas') bg-green-100 text-green-800 
                                            @elseif($transaksi->status_pembayaran == 'pending') bg-yellow-100 text-yellow-800 
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($transaksi->status_pembayaran) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('transaksi.show', $transaksi) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">Pengguna belum memiliki transaksi.</p>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection 