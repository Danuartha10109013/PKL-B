<?php
  
namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use App\Models\Event;
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
       
             $data = Cuti::where('jenis_cuti', '!=', 'tahunan')
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
            $event = Cuti::create([
                'title' => $request->title,
                'start' => $request->start,
                'end' => $request->end,
                'user_id' => Auth::user()->id,
                'status' => 0,
                'alasan_cuti' => $request->alasan_cuti,
                'jenis_cuti' => "tahunan",
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
            if ($event) {
                $event->delete();
                return response()->json(['success' => 'Event deleted']);
            }
            return response()->json(['error' => 'Event not found'], 404);

        default:
            return response()->json(['error' => 'Invalid operation'], 400);
    }
}

}
