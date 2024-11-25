<?php

namespace App\Http\Controllers;

use App\Models\AbsensiM;
use App\Models\Cuti;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function pegawai()
    {
        return view('pages.pegawai.index');
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
  
          // Get counts for "masuk" and "pulang"
          $absenMasuk = $query->where('type', 'masuk')->count();
          $absenPulang = $query->where('type', 'pulang')->count();
  
          // Get the total count for the year to show in the chart
          $totalAbsensi = AbsensiM::whereYear('created_at', $year)->count();

        return view('pages.admin.index',compact('absen','cuti','todaylate','monthlyleaves','data','absenMasuk','absenPulang','totalAbsensi', 'year', 'month'));
    }
}
