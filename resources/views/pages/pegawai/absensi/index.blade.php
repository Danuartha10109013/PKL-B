@extends('layout.main')
@section('title')
Dashboard || Pegawai
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="card">
            <h5 class="card-title fw-semibold mb-2">Presensi</h5>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="card-title fw-semibold mb-4">Card</h5>
                            <div class="card">
                                <img src="{{asset('attendance-check-in.png')}}" width="25%" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                        the card's content.</p>
                                    <a href="{{ route('pegawai.absensi.masuk') }}" class="btn btn-primary">Absen Masuk</a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="card-title fw-semibold mb-4">Card</h5>
                            <div class="card">
                                <img src="{{asset('attendance-check-out.png')}}" width="25%" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title">Card title</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of
                                        the card's content.</p>
                                    <a href="{{ route('pegawai.absensi.pulang') }}" class="btn btn-primary">Absen Pulang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
  
@endsection
