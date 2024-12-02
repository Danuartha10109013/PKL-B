<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class UpdateSaldoCuti extends Command
{
    // Nama dan deskripsi command
    protected $signature = 'update:saldo-cuti';
    protected $description = 'Reset saldo cuti setiap awal tahun';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->saldo_cuti = 12; // Reset saldo cuti
            $user->save();
        }

        $this->info('Saldo cuti berhasil direset untuk semua pengguna.');
    }
}
