<?php
use App\Models\User;

return function () {
    // Jalankan setiap awal tahun
    $this->call(function () {
        $users = User::all();
        dd($users);
        foreach ($users as $user) {
            $user->saldo_cuti = 12; // Reset saldo cuti
            $user->save();
        }

        info('Saldo cuti berhasil direset untuk semua pengguna.');
    })->yearly(); // Menjadwalkan reset setiap tahun
};
