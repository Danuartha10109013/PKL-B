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
                        <div class="col-md-6">
                            <a href="{{ route('pegawai.absensi.masuk') }}">
                                <h5 class="card-title fw-semibold mb-4">Absen Masuk</h5>
                                <div class="card">
                                    <img src="{{asset('imageuser.svg')}}" width="10%" class="card-img-top" alt="...">
                                    <div class="card-body">
                                        <h5 class="card-title">Absensi MAsuk</h5>
                                        <p class="card-text">Absensi harus dilakukan sebelum jam masuk, jika dilakukan setelah jam masuk akan terdeteksi sebeagai terlambat,
                                            lakukan absen saat sudah berada di area kantor.
                                        </p>
                                    </div>
                                </div>
                            </a>
                            </div>

                        <div class="col-md-6">
                            <a href="{{ route('pegawai.absensi.pulang') }}">
                                <h5 class="card-title fw-semibold mb-4">Absen Pulang</h5>
                                    <div class="card">
                                        <img src="{{asset('location.svg')}}" width="25%" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title">Absensi Pulang</h5>
                                            <p class="card-text">Absen bisa dilakukan setelah jam pulang, jika dilakukan sebelum pulang maka akan terdeteksi pulang kurang dari jam kerja,
                                                lakukan absen saat masih berada area dikantor.
                                            </p>
                                        </div>
                                    </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




@endsection


