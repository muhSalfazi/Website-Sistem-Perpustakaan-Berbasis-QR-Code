<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use Illuminate\Support\Facades\File;
class MemberController extends Controller
{
    // Metode untuk menampilkan daftar anggota
    public function index()
    {
        $members = Member::all()->map(function ($member) {
            $member->status = $member->created_at->isToday() ? 'new' : 'old';
            return $member;
        });

        return view('member.daftarmember', compact('members'));
    }
    public function destroy($id)
    {
        $member = Member::findOrFail($id);

        // Hapus file qr_code jika ada
        if ($member->qr_code) {
            $qrCodePath = public_path('qr_codes/' . $member->qr_code);
            if (File::exists($qrCodePath)) {
                File::delete($qrCodePath);
            }
        }

        // Hapus file imageProfile jika ada
        if ($member->imageProfile) {
            $imageProfilePath = public_path('profiles/' . $member->imageProfile);
            if (File::exists($imageProfilePath)) {
                File::delete($imageProfilePath);
            }
        }

        // Temukan pengguna yang terkait dengan anggota
        $user = User::find($member->user_id);

        // Hapus pengguna jika ditemukan
        if ($user) {
            $user->delete();
        }

        // Hapus anggota
        $member->delete();

        return redirect()->route('member')->with('msg', 'Anggota dan pengguna terkait berhasil dihapus.');
    }
}