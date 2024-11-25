<?php

namespace App\Exports;

use App\Models\AbsensiM;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;

class CC implements FromView, ShouldAutoSize
{
    use Exportable;

    private $data;

    public function __construct()
    {
        $this->data = AbsensiM::all();
    }

    public function view() : View
    {
        return view('pages.admin.kabsensi.export', [
            'data' => $this->data
        ]);
    }
}
