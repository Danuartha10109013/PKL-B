<?php

namespace App\Http\Controllers;

use App\Models\AbsensiM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function index(){
        $absen = AbsensiM::where('user_id',Auth::user()->id)->get();
        return view('pages.pegawai.absensi.index',compact('absen'));
    }

    public function masuk(){
        return view('pages.pegawai.absensi.absen-masuk');
    }


    // Method untuk handle absensi masuk
    public function absensiMasuk(Request $request)
    {
        // Validasi data yang dikirim
        $request->validate([
            'location_masuk' => 'required|string',
            'photo_masuk' => 'required|string',
        ]);

        // Ambil data lokasi (latitude, longitude)
        $location = $request->input('location_masuk');

        // Ambil data base64 dari foto
        $base64Photo = $request->input('photo_masuk');

        // Proses untuk menyimpan foto
        $photoPath = $this->savePhoto($base64Photo);

        // Simpan data absensi masuk ke database (contoh)
        // Misal kita punya model Absensi
        $absensi = new AbsensiM;
        $absensi->user_id = Auth::user()->id;
        $absensi->location = $location;
        $absensi->photo = $photoPath;
        $absensi->type = 'masuk'; // Menandakan ini absensi masuk
        $absensi->save();

        return redirect()->route('pegawai.absensi')->with('success', 'Absensi masuk berhasil disimpan.');
    }

    // Fungsi untuk menyimpan foto dalam format base64
    private function savePhoto($base64Photo)
    {
        // Decode base64 string menjadi file binary
        $fileData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Photo));

        // Buat nama file unik
        $fileName = 'photo_' . time() . '.png';

        // Tentukan direktori penyimpanan, misal di storage/app/public/absensi
        $filePath = 'public/absensi/' . $fileName;

        // Simpan file ke storage Laravel
        Storage::put($filePath, $fileData);

        // Return path relatif yang dapat digunakan untuk ditampilkan atau disimpan di database
        return 'storage/absensi/' . $fileName;
    }

    public function pulang(){
        return view('pages.pegawai.absensi.absen-pulang');
    }

    public function absensiPulang(Request $request){
        $request->validate([
            'location_pulang' => 'required|string',
        ]);

        $absensi = new AbsensiM;

        $absensi->location = $request->location_pulang;
        $absensi->user_id = Auth::user()->id;
        $absensi->type = "pulang";

        $absensi->save();

        return redirect()->route('pegawai.absensi')->with('success','Absen Pulang Sukses');

    }
}

