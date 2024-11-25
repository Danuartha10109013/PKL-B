<?php

namespace App\Http\Controllers;

use App\Exports\CC;
use App\Models\AbsensiM;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;


class KelolaAbsensiController extends Controller
{
    public function index(){
        $tepatmasuk = AbsensiM::whereTime('created_at', '<=', '09:00:00')->where('confirmation', null)->orderBy('created_at','desc')->where('type','masuk')->get();
        $same = AbsensiM::whereTime('created_at', '<=', '09:00:00')->where('confirmation', null)->value('id');
        $verivikasi = AbsensiM::where('id',$same)->orderBy('created_at','desc')->where('type','masuk')->where('confirmation', null)->value('verivikasi');
        $telatmasuk = AbsensiM::whereTime('created_at', '>', '09:00:00')->where('confirmation', null)->orderBy('created_at','desc')->where('type','masuk')->get();

        $tepatpulang = AbsensiM::whereTime('created_at', '>=', '17:00:00')->where('confirmation', null)->orderBy('created_at','desc')->where('type','pulang')->get();
        $samepulang = AbsensiM::whereTime('created_at', '<=', '09:00:00')->where('confirmation', null)->orderBy('created_at','desc')->where('type','pulang')->value('id');
        $verivikasipulang = AbsensiM::where('id',$samepulang)->orderBy('created_at','desc')->where('type','pulang')->where('confirmation', null)->value('verivikasi');
        $telatpulang = AbsensiM::whereTime('created_at', '<', '17:00:00')->where('confirmation', null)->orderBy('created_at','desc')->where('type','pulang')->get();

        $terkonfirmasi = AbsensiM::orderBy('created_at','desc')->get();

        return view('pages.admin.kabsensi.index',compact('tepatmasuk','telatmasuk','verivikasi','tepatpulang','telatpulang','verivikasipulang','terkonfirmasi'));
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
        $data->save();
        // dd($request->all());

        $name = User::where('id', $data->id)->value('name');
        return redirect()->route('admin.kabsensi')->with('success','Absensi '.$name.' Telah terkonfirmasi');
    }

    public function export(){
        $date = now()->format('d-m-Y'); 
        return Excel::download(new CC, $date . 'Absensi.xlsx');
    }
}
