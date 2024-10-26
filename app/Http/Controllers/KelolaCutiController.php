<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class KelolaCutiController extends Controller
{
    public function index(){
        $data = Cuti::where('status',0)->get();
        $data1 = Cuti::where('status', '!=', '0')->get();
        return view('pages.admin.kcuti.index',compact('data','data1'));
    }
    public function update(Request $request, $id)
{
    $request->validate([
        'keterangan' => 'required|string|max:255',
        'status' => 'required|string|max:255',
    ]);

    $cuti = Cuti::findOrFail($id);
    $cuti->keterangan = $request->input('keterangan');
    if($request->status == "Disetujui"){
        $cuti->status = 1;
    }else{
        $cuti->status = 2;
    }
    $cuti->save();

    return redirect()->route('admin.kcuti')->with('success', 'Leave request updated successfully!');
}

public function download($id)
{
    // Fetch the record from the Cuti model
    $cuti = Cuti::find($id);

    // Check if the record exists
    if (!$cuti) {
        return response()->json(['message' => 'Record tidak ditemukan.'], Response::HTTP_NOT_FOUND);
    }

    // Construct the full path to the file without 'assets'
    $path = public_path('storage/bukti/' . $cuti->bukti);

    // Debugging: Check the path (you can remove this in production)
    // dd($path);

    // Check if the file exists
    if (!file_exists($path)) {
        return response()->json(['message' => 'File tidak ditemukan.'], Response::HTTP_NOT_FOUND);
    }

    // Return the file as a download response
    return response()->download($path);
}


}