<?php

namespace App\Http\Controllers;

use App\Models\AbsensiM;
use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function pegawai(Request $request)
    {
        $query = AbsensiM::where('user_id', Auth::user()->id);
    
        // Filter berdasarkan bulan dan tahun
        if ($request->filled('bulan') && !$request->filled('tahun')) {
            $query->whereMonth('created_at', $request->bulan)
                  ->whereYear('created_at', now()->year);
        } elseif ($request->filled('tahun') && !$request->filled('bulan')) {
            $query->whereYear('created_at', $request->tahun);
        } elseif ($request->filled('bulan') && $request->filled('tahun')) {
            $query->whereMonth('created_at', $request->bulan)
                  ->whereYear('created_at', $request->tahun);
        }
    
        // Hitung jumlah absen masuk dan subkategori
        $masukTepat = (clone $query)->where('type', 'masuk')->whereTime('created_at', '<=', '09:00:00')->count();
        $telatMasuk = (clone $query)->where('type', 'masuk')->whereTime('created_at', '>', '09:00:00')->count();
    
        // Hitung jumlah absen pulang dan subkategori
        $pulangTepat = (clone $query)->where('type', 'pulang')->whereTime('created_at', '>=', '17:00:00')->count();
        $pulangLebihAwal = (clone $query)->where('type', 'pulang')->whereTime('created_at', '<', '17:00:00')->count();
    
        $masuk = $masukTepat + $telatMasuk;
        $pulang = $pulangTepat + $pulangLebihAwal;
    
        return view('pages.pegawai.index', compact('masuk', 'pulang', 'masukTepat', 'telatMasuk', 'pulangTepat', 'pulangLebihAwal'));
    }
    
    
    public function admin(Request $request)
    {
        $data = AbsensiM::all();
        $cuti = Cuti::orderBy('created_at','desc')->paginate(5);
        $absen = AbsensiM::orderBy('created_at','desc')->paginate(5);
        $todaylate = AbsensiM::whereDate('created_at', now())
                                ->where('type','masuk')
                                ->whereTime('created_at', '>', '09:00:00')
                                ->count();
        $monthlyleaves = Cuti::whereMonth('created_at', now()->month)
                                ->where('status',1)
                                ->whereYear('created_at', now()->year)
                                ->count();

          // Get the current year if no year is specified
          $year = $request->input('year', date('Y')); // Default to current year if not provided
          $month = $request->input('month', null);
          $startDate = $request->input('start_date', null);
          $endDate = $request->input('end_date', null);
  
           // Retrieve filters from the request
            $month = $request->input('month');
            $year = $request->input('year', date('Y'));
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');

            // Filter query based on input
            $query = AbsensiM::query();

            // Filter by date range if specified
            if ($startDate && $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }

            // Filter by month if specified
            if ($month) {
                $query->whereMonth('created_at', $month);
            }

            // Filter by year if specified (defaults to current year)
            $query->whereYear('created_at', $year);

            // Get monthly counts for "masuk" and "pulang"
            $monthlyData = $query->selectRaw('MONTH(created_at) as month, 
                                                SUM(CASE WHEN type = "masuk" THEN 1 ELSE 0 END) as absen_masuk, 
                                                SUM(CASE WHEN type = "pulang" THEN 1 ELSE 0 END) as absen_pulang')
                                    ->groupBy('month')
                                    ->orderBy('month')
                                    ->get();

            $months = $monthlyData->pluck('month')->map(function ($month) {
                return date('F', mktime(0, 0, 0, $month, 1)); // Convert month number to month name
            });
            $absenMasukCounts = $monthlyData->pluck('absen_masuk');
            $absenPulangCounts = $monthlyData->pluck('absen_pulang');

        return view('pages.admin.index',
        compact('absen',
        'cuti',
        'todaylate',
        'monthlyleaves',
        'data',
        'absenMasukCounts',
        'absenPulangCounts',
        'year', 
        'month',
        'months',
    ));
    }
}
