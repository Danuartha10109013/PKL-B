@extends('layout.main')
@section('title')
Absensi Pulang || Pegawai
@endsection
@section('content')
<div class="container-fluid">
    <form action="{{ route('pegawai.absensi.pulang.store') }}" method="POST">
        @csrf
        <div class="modal-body">
            <div class="mb-3">
                <label for="location_masuk" class="form-label">Location</label>
                <input type="text" class="form-control mb-3" id="location_masuk" name="location_pulang" readonly>
                <!-- Map container -->
                <div id="map_masuk" style="width: 100%; height: 200px;"></div>
            </div>
            {{-- <div class="mb-3">
                <label for="photo_masuk" class="form-label">Photo</label>
                <!-- Video for live stream -->
                <video id="video_masuk" width="100%" height="200" autoplay></video>
                <!-- Canvas for captured photo -->
                <canvas id="canvas_masuk" style="display: none;"></canvas>
                <input type="hidden" id="photo_masuk" name="photo_masuk">
                <button type="button" class="btn btn-primary mt-2" id="capture_masuk">Capture Photo</button>
            </div> --}}
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@endsection

<!-- Include Leaflet JS and CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>
    // Initialize the map and video capture after the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        initializeMap('map_masuk', 'location_masuk');
        setupVideoCapture('video_masuk', 'canvas_masuk', 'photo_masuk', 'capture_masuk');
    });

    // Function to initialize map and set marker
    function initializeMap(elementId, locationInputId) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                let lat = position.coords.latitude;
                let long = position.coords.longitude;
                document.getElementById(locationInputId).value = lat + ", " + long;

                let map = L.map(elementId).setView([lat, long], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                L.marker([lat, long]).addTo(map).bindPopup("You are here").openPopup();
            }, function(error) {
                alert("Unable to retrieve your location: " + error.message);
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    }

</script>
