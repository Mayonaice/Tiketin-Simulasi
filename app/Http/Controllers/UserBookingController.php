<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JadwalPenerbangan;
use App\Models\Tiket;
use App\Models\Transaksi;
use App\Models\Kota;
use App\Models\Maskapai;
use Illuminate\Support\Facades\Auth;

class UserBookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JadwalPenerbangan::with(['maskapai', 'kotaAsal', 'kotaTujuan'])->where('sisa_kursi', '>', 0);
        
        // Filter by kota asal (berangkat)
        if ($request->has('kota_asal') && $request->kota_asal != '') {
            $query->where('kota_asal_id', $request->kota_asal);
        }
        
        // Filter by kota tujuan
        if ($request->has('kota_tujuan') && $request->kota_tujuan != '') {
            $query->where('kota_tujuan_id', $request->kota_tujuan);
        }
        
        // Filter by maskapai
        if ($request->has('maskapai') && $request->maskapai != '') {
            $query->where('maskapai_id', $request->maskapai);
        }
        
        // Filter by tanggal/jadwal
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('tanggal_berangkat', $request->tanggal);
        }
        
        // Filter by harga (range)
        if ($request->has('harga_min') && $request->harga_min != '') {
            $query->where('harga_tiket', '>=', $request->harga_min);
        }
        
        if ($request->has('harga_max') && $request->harga_max != '') {
            $query->where('harga_tiket', '<=', $request->harga_max);
        }
        
        $jadwals = $query->get();
        
        // Get data for filter dropdowns
        $kotas = Kota::all();
        $maskapais = Maskapai::all();
        
        return view('user.booking_index', compact('jadwals', 'kotas', 'maskapais', 'request'));
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
            'quantity' => 'required|integer|min:1',
        ]);
        
        $jadwal = JadwalPenerbangan::findOrFail($request->jadwal_id);
        
        // Validasi jumlah tiket tidak melebihi sisa kursi
        if ($request->quantity > $jadwal->sisa_kursi) {
            return back()->with('error', 'Jumlah tiket yang diminta melebihi sisa kursi yang tersedia!');
        }
        
        // Cari tiket yang tersedia
        $tikets = Tiket::where('jadwal_id', $jadwal->id)
                        ->where('status', 'tersedia')
                        ->take($request->quantity)
                        ->get();
                        
        if ($tikets->count() < $request->quantity) {
            return back()->with('error', 'Tiket tidak cukup tersedia!');
        }
        
        // Hitung total harga
        $total_price = $jadwal->harga_tiket * $request->quantity;
        
        // Ambil tiket pertama untuk referensi transaksi
        $first_tiket = $tikets->first();
        
        // Buat transaksi
        $transaksi = Transaksi::create([
            'user_id' => Auth::id(),
            'tiket_id' => $first_tiket->id,
            'quantity' => $request->quantity,
            'total_price' => $total_price,
            'status_bayar' => 'pending',
        ]);
        
        // Update status tiket
        foreach ($tikets as $tiket) {
            $tiket->update(['status' => 'dipesan']);
        }
        
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
