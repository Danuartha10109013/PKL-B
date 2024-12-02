@extends('layout.main')
@section('title')
Dashboard || Pegawai
@endsection
@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <h5 class="card-title fw-semibold mb-2">Presensi</h5>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between">
                                        <h5 class="card-title fw-semibold mb-4">All Absensi</h5>
                                        <!-- Button to trigger Add Modal -->
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <p>History Absensi</p>
                    
                                            <div class="table-responsive">
                                                <table class="table text-nowrap mb-0 align-middle">
                                                    <thead class="text-dark fs-4">
                                                        <tr>
                                                            <th class="border-bottom-0 text-center">
                                                                <h6 class="fw-semibold mb-0">Id</h6>
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
                                                            <th class="border-bottom-0">
                                                                <h6 class="fw-semibold mb-0">Action</h6>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $users = \App\Models\User::pluck('name', 'id');
                                                            $noPegawai = \App\Models\User::pluck('no_pegawai', 'id');
                                                        @endphp
                                                        @foreach ($absen as $t)
                                                        <tr>
                                                            <td class="border-bottom-0 text-center">
                                                                <h6 class="fw-semibold mb-0">{{$loop->iteration}}</h6>
                                                            </td>
                                                            <td class="border-bottom-0">
                                                                <h6 class="fw-semibold mb-1">{{ $users[$t->user_id] ?? 'Unknown' }}</h6>
                                                                <span class="fw-normal">{{ $noPegawai[$t->user_id] ?? 'Unknown' }}</span>
                                                            </td>
                                                            <td class="border-bottom-0">
                                                                <p class="mb-0 fw-normal">{{$t->created_at}}</p>
                                                            </td>
                                                            <td class="border-bottom-0">
                                                                @php
                                                                    $createdTime = \Carbon\Carbon::parse($t->created_at)->format('H:i:s');
                                                                    $keterangan = $t->type === 'masuk'
                                                                        ? ($createdTime <= '09:00:00' ? 'Tepat Waktu' : 'Terlambat')
                                                                        : ($createdTime >= '16:00:00' ? 'Tepat Waktu' : 'Pulang Lebih Awal');
                                                                @endphp
                                                                <p class="mb-0 fw-normal">{{$keterangan}}</p>
                                                            </td>
                                                            <td class="border-bottom-0">
                                                                <p class="mb-0 fw-normal">{{$t->type}}</p>
                                                            </td>
                                                            <td class="border-bottom-0">
                                                                <p class="mb-0 fw-normal">
                                                                    {{$t->confirmation == 1 ? 'Terverifikasi' : 'Belum Terverifikasi'}}
                                                                </p>
                                                            </td>
                                                            <td class="border-bottom-0">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <a href="#" class="badge bg-primary rounded-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#detailModalall-{{$t->id}}">
                                                                        Detail
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <!-- Modal for Detail -->
                                                        <div class="modal fade" id="detailModalall-{{$t->id}}" tabindex="-1" aria-labelledby="detailModalallLabel-{{$t->id}}" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="detailModalallLabel-{{$t->id}}">Detail Absensi</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <h6><strong>Nama:</strong> {{ $users[$t->user_id] ?? 'Unknown' }}</h6>
                                                                        <h6><strong>No Pegawai:</strong> {{ $noPegawai[$t->user_id] ?? 'Unknown' }}</h6>
                                                                        @if ($t->type == 'masuk')
                                                                        <h6><strong>Bukti Absen:</strong></h6>
                                                                        <img src="{{ asset('/'.$t->photo) }}" alt="Bukti Absen" class="img-fluid">
                                                                        @endif
                                                                        <h6><strong>Lokasi:</strong> {{$t->location}}</h6>
                                                                        <div id="maps-{{$t->id}}" style="height: 300px; width: 100%;"></div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($absen as $d)
        $('#detailModalall-{{$d->id}}').on('shown.bs.modal', function () {
            let location = "{{$d->location}}".split(',');
            let latitude = parseFloat(location[0].trim());
            let longitude = parseFloat(location[1].trim());

            var map = L.map('maps-{{$d->id}}').setView([latitude, longitude], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Location of {{ $users[$d->user_id] ?? "Unknown" }}').openPopup();
        });
        @endforeach
    });
</script>

@endsection