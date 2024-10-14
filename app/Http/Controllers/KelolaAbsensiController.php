<?php

namespace App\Http\Controllers;

use App\Models\AbsensiM;
use App\Models\User;
use Illuminate\Http\Request;

class KelolaAbsensiController extends Controller
{
    public function index(){
        $tepat = AbsensiM::whereTime('created_at', '<=', '09:00:00')->get();
        $same = AbsensiM::whereTime('created_at', '<=', '09:00:00')->value('id');
        $verivikasi = AbsensiM::where('id',$same)->value('verivikasi');
        // dd($verivikasi);
        $telat = AbsensiM::whereTime('created_at', '>', '09:00:00')->get();

        return view('pages.admin.kabsensi.index',compact('tepat','telat','verivikasi'));
    }

    public function confirm(Request $request,$id){
        $request->validate([
            'keterangan' => 'nullable|string|max:255',
            'verivikasi_oleh' => 'required',
            'verivikasi' => 'required',
        ]);
        $data = AbsensiM::find($id);
        
        $data-> verivikasi_oleh = $request->verivikasi_oleh;
        $data-> confirmation = $request->verivikasi;
        $data-> keterangan = $request->keterangan;
        $data->update();

        $name = User::where('id', $data->id)->value('name');
        return redirect()->route('admin.kabsensi')->with('success','Absensi '.$name.' Telah terkonfirmasi');
    }
}
