<?php

namespace App\Listeners;

use App\Events\UserCreated;
use App\Models\Member;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateUserMember
{
    public function __construct()
    {
        //
    }

    public function handle(UserCreated $event)
    {
        // Ambil data pengguna yang baru dibuat dari event
        $user = $event->user;

        // Buat entri di tabel member berdasarkan data pengguna
        Member::create([
            'user_id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'qr_code' => $user->qr_code,
        ]);
    }
}