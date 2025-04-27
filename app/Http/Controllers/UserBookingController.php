<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPenerbangan;
use App\Models\Tiket;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;

class UserBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jadwals = JadwalPenerbangan::with(['maskapai', 'kotaAsal', 'kotaTujuan'])->where('sisa_kursi', '>', 0)->get();
        return view('user.booking_index', compact('jadwals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jadwals = JadwalPenerbangan::with(['maskapai', 'kotaAsal', 'kotaTujuan'])->where('sisa_kursi', '>', 0)->get();
        return view('user.booking_create', compact('jadwals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwal_penerbangans,id',
        ]);
        $jadwal = JadwalPenerbangan::findOrFail($request->jadwal_id);
        $tiket = Tiket::where('jadwal_id', $jadwal->id)->where('status', 'tersedia')->first();
        if (!$tiket) {
            return back()->with('error', 'Tiket sudah habis!');
        }
        // Buat transaksi
        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'tiket_id' => $tiket->id,
            'status_bayar' => 'pending',
        ]);
        // Update tiket & sisa kursi
        $tiket->update(['status' => 'dipesan']);
        $jadwal->decrement('sisa_kursi');
        return redirect()->route('booking.edit', $transaksi->id)->with('success', 'Tiket berhasil dipesan, silakan upload bukti pembayaran!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaksi = Transaksi::with('tiket.jadwal')->where('user_id', Auth::id())->findOrFail($id);
        return view('user.booking_show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transaksi = Transaksi::with('tiket.jadwal')->where('user_id', Auth::id())->findOrFail($id);
        return view('user.booking_upload', compact('transaksi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())->findOrFail($id);
        $request->validate([
            'bukti_bayar' => 'required|image|max:2048',
        ]);
        $path = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
        $transaksi->update([
            'bukti_bayar' => $path,
            'status_bayar' => 'dibayar',
        ]);
        return redirect()->route('booking.show', $transaksi->id)->with('success', 'Bukti pembayaran berhasil diupload, menunggu approval admin.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display listing of user's bookings.
     *
     * @return \Illuminate\View\View
     */
    public function userBookings()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())
            ->with(['tiket.jadwal.maskapai', 'tiket.jadwal.kotaAsal', 'tiket.jadwal.kotaTujuan'])
            ->latest()
            ->get();
            
        return view('user.bookings', compact('transaksis'));
    }

    /**
     * Display user's trip history.
     *
     * @return \Illuminate\View\View
     */
    public function history()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())
            ->with(['tiket.jadwal.maskapai', 'tiket.jadwal.kotaAsal', 'tiket.jadwal.kotaTujuan', 'user'])
            ->latest()
            ->get();
            
        return view('user.history', compact('transaksis'));
    }

    /**
     * Generate printable ticket.
     *
     * @param string $id
     * @return \Illuminate\View\View
     */
    public function cetakTiket(string $id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
            ->where('status_bayar', 'approved')
            ->with(['tiket.jadwal.maskapai', 'tiket.jadwal.kotaAsal', 'tiket.jadwal.kotaTujuan', 'user'])
            ->findOrFail($id);
            
        return view('user.cetak_tiket', compact('transaksi'));
    }
}
