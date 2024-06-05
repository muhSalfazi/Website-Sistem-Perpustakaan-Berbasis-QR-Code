<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;

class MemberController extends Controller
{
    // Metode untuk menampilkan daftar anggota
    public function index()
    {
        $members = Member::paginate(10);
        return view('member', compact('members'));
    }

    public function showDetail($id)
    {
        $member = Member::findOrFail($id);
        // Tambahkan logika lainnya sesuai kebutuhan, misalnya, tampilkan modal detail member
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        // Temukan pengguna yang terkait dengan anggota
        $user = User::where('id', $member->user_id)->first();

        // Hapus pengguna jika ditemukan
        if ($user) {
            $user->delete();
        }

        // Hapus anggota
        $member->delete();

        return redirect()->route('member')->with('msg', 'Anggota dan pengguna terkait berhasil dihapus.');
    }
}