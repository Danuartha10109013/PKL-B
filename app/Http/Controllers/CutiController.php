<?php

namespace App\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class CutiController extends Controller
{
    public function index(){
        $data = Cuti::where('jenis_cuti','tahunan')->get();
        $data1 = Cuti::where('jenis_cuti', '!=', 'tahunan')->get();
        return view('pages.pegawai.cuti.index',compact('data','data1'));
    }
    public function store(Request $request)
{
    // Validate the incoming request
    $request->validate([
        'title' => 'required|string|max:255',
        'alasan_cuti' => 'required|string|in:Sakit,Izin',
        'bukti' => 'required|file|mimes:jpg,png,pdf|max:2048', // max 2MB file size
        'start' => 'required|date',
        'end' => 'required|date|after_or_equal:start',
    ]);

    // Handle the file upload with Storage
    if ($request->hasFile('bukti')) {
        // Store the file in the 'public/bukti' directory and get the path
        $filePath = $request->file('bukti')->store('bukti', 'public');
    }
    // dd($filePath);

    // Create a new leave request (cuti)
    Cuti::create([
        'title' => $request->input('title'),
        'alasan_cuti' => $request->input('alasan_cuti'),
        'jenis_cuti' => $request->input('jenis_cuti'),
        'bukti' => $filePath ,
        'start' => $request->input('start'),
        'end' => $request->input('end'),
        'status' => 0,
        'user_id' => Auth::user()->id,
    ]);

    // Redirect or return a response
    return redirect()->route('pegawai.cuti')->with('success', 'Cuti request submitted successfully!');
}




}
