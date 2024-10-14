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
                            <a href="{{route('pegawai.absensi.masuk')}}" ><label for="">Absen Masuk</label></a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" data-bs-toggle="modal" data-bs-target="#absenPulangModal"><label for="">Absen Pulang</label></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Absen Masuk -->
<div class="modal fade" id="absenMasukModal" tabindex="-1" aria-labelledby="absenMasukLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="absenMasukLabel">Absen Masuk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('pegawai.absensi.masuk') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="location_masuk" class="form-label">Location</label>
                <input type="text" class="form-control" id="location_masuk" name="location_masuk" readonly>
                <!-- Map container -->
                <div id="map_masuk" style="width: 100%; height: 200px;"></div>
            </div>
            <div class="mb-3">
                <label for="photo_masuk" class="form-label">Photo</label>
                <!-- Video for live stream -->
                <video id="video_masuk" width="100%" height="200" autoplay></video>
                <!-- Canvas for captured photo -->
                <canvas id="canvas_masuk" style="display: none;"></canvas>
                <input type="hidden" id="photo_masuk" name="photo_masuk">
                <button type="button" class="btn btn-primary mt-2" id="capture_masuk">Capture Photo</button>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal for Absen Pulang -->
<div class="modal fade" id="absenPulangModal" tabindex="-1" aria-labelledby="absenPulangLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="absenPulangLabel">Absen Pulang</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('pegawai.absensi.pulang') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="location_pulang" class="form-label">Location</label>
                <input type="text" class="form-control" id="location_pulang" name="location_pulang" readonly>
                <!-- Map container -->
                <div id="map_pulang" style="width: 100%; height: 200px;"></div>
            </div>
            <div class="mb-3">
                <label for="photo_pulang" class="form-label">Photo</label>
                <!-- Video for live stream -->
                <video id="video_pulang" width="100%" height="200" autoplay></video>
                <!-- Canvas for captured photo -->
                <canvas id="canvas_pulang" style="display: none;"></canvas>
                <input type="hidden" id="photo_pulang" name="photo_pulang">
                <button type="button" class="btn btn-primary mt-2" id="capture_pulang">Capture Photo</button>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('scripts')

  
@endsection
