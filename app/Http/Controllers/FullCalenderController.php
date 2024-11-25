<?php
  
namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class FullCalenderController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request)
    {
  
        if($request->ajax()) {
       
             $data = Cuti::where('jenis_cuti', '!=', 'lain-lain')
                       ->whereDate('start', '>=', $request->start)
                       ->whereDate('end',   '<=', $request->end)
                       ->get(['id', 'title', 'start', 'end']);
  
             return response()->json($data);
        }
  
        return view('pages.pegawai.cuti.fullcalender');
    }
 
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function ajax(Request $request): JsonResponse
{
    switch ($request->type) {
        case 'add':
            // Calculate total days of leave requested
            $start = Carbon::parse($request->start);
            $end = Carbon::parse($request->end);
            $totalDays = $start->diffInDays($end) + 1; // Include the start day
        
            // Get the user's leave balance (saldo_cuti)
            $user = Auth::user();
        
            // Check if the user has enough leave balance
            if ($user->saldo_cuti < $totalDays) {
                return response()->json([
                    'error' => 'Saldo Cuti kurang, Saldo: ' . $user->saldo_cuti,
                ], 400); // 400 Bad Request
            }
        
            // Check for overlapping leave requests
            $overlappingLeave = Cuti::where('status', 1) // Only approved leave requests
                ->where(function ($query) use ($start, $end) {
                    $query->whereBetween('start', [$start, $end])
                        ->orWhereBetween('end', [$start, $end])
                        ->orWhere(function ($query) use ($start, $end) {
                            $query->where('start', '<=', $start)
                                  ->where('end', '>=', $end);
                        });
                })
                ->exists();
        
            $status = $overlappingLeave ? 2 : 0; // Status 2 if overlapping, otherwise 0
        
            // Create the leave request
            $event = Cuti::create([
                'title' => $request->title,
                'start' => $request->start,
                'end' => $request->end,
                'user_id' => $user->id,
                'status' => $status,
                'alasan_cuti' => $request->alasan_cuti,
                'jenis_cuti' => 'tahunan',
            ]);
        
            return response()->json($event);
        

        case 'update':
            $event = Cuti::find($request->id);
            if($event->status == 0){
                if ($event) {
                    $event->update([
                        'title' => $request->title,
                        'start' => $request->start,
                        'end' => $request->end,
                    ]);
                    return response()->json($event);
                }
                return response()->json(['error' => 'Event not found'], 404);
            }else{
                return response()->json(['error' => 'Sudah Distujui, Tidak boleh berganti'], 404);
            }

        case 'delete':
            $event = Cuti::find($request->id);
            
            if ($event->status == 0) {
                if ($event) {
                    $event->delete();
                    return response()->json($event);
                } 
                return response()->json(['error' => 'Event not found'], 404);
            } else {
                return response()->json(['error' => 'Sudah Disetujui, Tidak Boleh Dihapus'], 404);
            }
            
            
            

        default:
            return response()->json(['error' => 'Invalid operation'], 400);
    }
}

}
