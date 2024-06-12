<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Auth;
use App\Models\Member;
use Illuminate\Support\Facades\Route;

class ShowPeminjamanController extends Controller
{
    public function index($id)
    {
        // Ambil member ID berdasarkan user ID
        $member = Member::where('user_id', $id)->first();

        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        // Ambil data peminjaman berdasarkan member ID yang terkait
        $peminjamans = Peminjaman::with(['member', 'book', 'denda'])
            ->where('member_id', $member->id)
            ->get();

        return response()->json($peminjamans);
    }
}