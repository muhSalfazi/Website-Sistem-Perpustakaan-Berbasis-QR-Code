<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Denda;

class DendaController extends Controller
{
   public function index(Request $request)
   {
      $peminjamans = Peminjaman::with('member', 'book', 'denda')->paginate(10);


      return view('Denda.daftardenda', compact('peminjamans'));
   }


   public function bayarDenda(Request $request)
   {
      // Validasi input
      $request->validate([
         'id_pjmn' => 'required|exists:tbl_peminjaman,id',
         'uang_yg_dibyrkn' => 'required|numeric|min:0',
      ]);

      // Periksa apakah peminjaman sudah lunas
      $peminjaman = Peminjaman::find($request->id_pjmn);
      if ($peminjaman->status === 'lunas') {
         return redirect()->back()->with('msg', 'Peminjaman sudah lunas.')->with('error', true);
      }

      // Hitung total denda
      $createdAt = \Carbon\Carbon::parse($peminjaman->created_at);
      $returnDate = \Carbon\Carbon::parse($peminjaman->return_date);
      $telatHari = $returnDate->diffInDays($createdAt) - 7;
      $totalDenda = $telatHari * 5000; // Ubah 5000 sesuai tarif denda per hari

      // Validasi jumlah uang yang dibayarkan harus sama dengan total denda
      if ($request->uang_yg_dibyrkn == $totalDenda) {
         return redirect()->back()->with('msg', 'Uang yang dibayarkan harus tepat sejumlah total denda.')->with('error', true);
      }

      // Simpan data pembayaran ke dalam tabel denda
      $denda = Denda::create([
         'id_pjmn' => $request->id_pjmn,
         'denda_yg_dibyr' => $totalDenda,
         'uang_yg_dibyrkn' => $request->uang_yg_dibyrkn,
         'status' => 'lunas'
      ]);

      // Ubah status peminjaman menjadi "lunas"
      $denda->status = 'lunas';
      $denda->save();

      // Redirect kembali dengan pesan sukses
      return redirect()->back()->with('msg', 'Pembayaran denda berhasil disimpan.Member tersebut sudah dihapus dari daftar Denda.')->with('success', true);
   }


}