<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="table-responsive">
        <table class="table text-nowrap mb-0 align-middle">
        <thead class="text-dark fs-4">
            <tr>
            <th class="border-bottom-0 text-center">
                <h6 class="fw-semibold mb-0">No</h6>
            </th>
            <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Name</h6>
            </th>
            <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Time</h6>
            </th>
            <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Keterangan</h6>
            </th>
            <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Type</h6>
            </th>
            <th class="border-bottom-0">
                <h6 class="fw-semibold mb-0">Status</h6>
            </th>
            </tr>
        </thead>
        <tbody>
            
            @foreach ($data as $t)
            
            <tr>
            <td class="border-bottom-0 text-center">
                <h6 class="fw-semibold mb-0">{{$loop->iteration}}</h6>
            </td>
            <td class="border-bottom-0">
                <h6 class="fw-semibold mb-1">
                    @php
                $nama = \App\Models\User::where('id', $t->user_id)->value('name');
                $no_pegawai = \App\Models\User::where('id', $t->user_id)->value('no_pegawai');
                @endphp
                <h6 class="fw-semibold mb-1">{{$nama}}</h6>
                <span class="fw-normal">{{$no_pegawai}}</span>
                
            </td>
            <td class="border-bottom-0">
                <p class="mb-0 fw-normal">{{$t->created_at}}</p>
            </td>
            <td class="border-bottom-0">
                @php
                    $createdTime = \Carbon\Carbon::parse($t->created_at)->format('H:i:s');
                    $keterangan = $t->type === 'masuk'
                        ? ($createdTime <= '09:00:00' ? 'Tepat Waktu' : 'Terlambat')
                        : ($createdTime >= '17:00:00' ? 'Tepat Waktu' : 'Pulang Lebih Awal');
                @endphp
                <p class="mb-0 fw-normal">{{$keterangan}}</p>
            </td>
            <td class="border-bottom-0">
                <p class="mb-0 fw-normal">{{$t->type}}</p>
            </td>
            <td class="border-bottom-0">
                <p class="mb-0 fw-normal">
                    {{$t->confirmation == 1 ? 'Terverifikasi' : ($t->confirmation != 1 ? 'Belum Terverifikasi' : 'none')}}
                </p>
            </td>
            
            </tr>
            
            
            @endforeach
        </tbody>
        </table>
    </div>
</body>
</html>