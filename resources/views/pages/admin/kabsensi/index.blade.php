    @extends('layout.main')
    @section('title')
    Kelola Pegawai || Admin
    @endsection
    @section('content')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between">
                <h5 class="card-title fw-semibold mb-4">Kelola Absensi Pegawai</h5>
                <!-- Button to trigger Add Modal -->
            </div>
            <div class="row">
                <div class="col-md-6">
                    <p>Absensi Tepat </p>

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
                                <h6 class="fw-semibold mb-0">Status</h6>
                            </th>
                            <th class="border-bottom-0">
                                <h6 class="fw-semibold mb-0">Action</h6>
                            </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tepat as $t)
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
                                <p class="mb-0 fw-normal">
                                    {{-- @php
                                        dd($t->verivikasi);
                                    @endphp --}}
                                    {{$t->confirmation == 1 ? 'Terverifikasi' : ($t->confirmation != 1 ? 'Belum Terverifikasi' : 'none')}}
                                </p>
                            </td>
                            <td class="border-bottom-0">
                                <div class="d-flex align-items-center gap-2">
                                <a href="#" class="badge bg-primary rounded-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#detailModal-{{$t->id}}">Detail</a>
                                </div>
                            </td>
                            </tr>
                            <!-- Modal for Detail -->
                            <div class="modal fade" id="detailModal-{{$t->id}}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel">Detail Absensi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h6><strong>Nama:</strong> {{$nama}}</h6>
                                            <h6><strong>No Pegawai:</strong> {{$no_pegawai}}</h6>
                                            <h6><strong>Lokasi:</strong>{{$t->location}}</h6>
                                            <div id="map-{{$t->id}}" style="height: 300px;"></div> <!-- Leaflet map container -->
                                            <h6><strong>Bukti Absen:</strong></h6>
                                            <img src="{{ asset('/'.$t->photo) }}" alt="Bukti Absen" class="img-fluid">
                                        </div>
                                        <div class="modal-footer">
                                            @if ($t->verivikasi == 1)
                                                @elseif(is_null($t->verivikasi) || $t->verivikasi != 1)
                                                <form action="{{route('admin.kabsensi.konfirmasi',$t->user_id)}}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="form-control">
                                                        <div class="mb-3">
                                                            <label for="verivikasi">Status Verifikasi</label>
                                                            <select name="verivikasi" id="verifikasi-select" class="form-control" onchange="toggleOtherInput()">
                                                                <option value="" disabled selected>--Pilih Konfirmasi--</option>
                                                                <option value=1>Sesuai</option>
                                                                <option value="0">Bukan Dikantor</option>
                                                                <option value="other">Other</option> <!-- The "Other" option -->
                                                            </select>
                                                        </div>
                                                        
                                                        <div class="mb-3">
                                                            <label for="keterangan">Keterangan</label>
                                                            <input type="text" name="keterangan" class="form-control">
                                                            <input type="text" name="verivikasi_oleh" value="{{Auth::user()->id}}" hidden>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-success">Konfirmasi</button>
                                                </form>
                                                
                                               
                                                
                                                
                                            @endif

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

                <div class="col-md-6">
                    <p>Absensi Terlambat</p>
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
                                <h6 class="fw-semibold mb-0">Action</h6>
                            </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($telat as $d)
                            <tr>
                            <td class="border-bottom-0 text-center">
                                <h6 class="fw-semibold mb-0">{{$loop->iteration}}</h6>
                            </td>
                            <td class="border-bottom-0">
                                @php
                                $nama = \App\Models\User::where('id', $d->user_id)->value('name');
                                $no_pegawai = \App\Models\User::where('id', $d->user_id)->value('no_pegawai');
                                @endphp
                                <h6 class="fw-semibold mb-1">{{$nama}}</h6>
                                <span class="fw-normal">{{$no_pegawai}}</span>
                            </td>
                            <td class="border-bottom-0">
                                <p class="mb-0 fw-normal">{{$d->created_at}}</p>
                            </td>
                            
                            <td class="border-bottom-0">
                                <div class="d-flex align-items-center gap-2">
                                <a href="#" class="badge bg-primary rounded-3 fw-semibold" data-bs-toggle="modal" data-bs-target="#detailModal-{{$d->id}}">Detail</a>
                                </div>
                            </td>
                            </tr>
                            <!-- Modal for Detail -->
                            <div class="modal fade" id="detailModal-{{$d->id}}" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="detailModalLabel">Detail Absensi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <h6><strong>Nama:</strong> {{$nama}}</h6>
                                            <h6><strong>Jabatan:</strong> {{$no_pegawai}}</h6>
                                            <h6><strong>Lokasi:</strong>{{$d->location}}</h6>
                                            <div id="map-{{$d->id}}" style="height: 300px;"></div> <!-- Leaflet map container -->
                                            <h6><strong>Bukti Absen:</strong></h6>
                                            <img src="{{ asset('/'.$d->photo) }}" alt="Bukti Absen" class="img-fluid">
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
    <script>
        @foreach($tepat as $d)
        document.addEventListener('DOMContentLoaded', function () {
            $('#detailModal-{{$d->id}}').on('shown.bs.modal', function () {
            // Assuming $d->location is in "latitude, longitude" format
            let location = "{{$d->location}}".split(',');
            let latitude = parseFloat(location[0].trim());
            let longitude = parseFloat(location[1].trim());
    
            var map = L.map('map-{{$d->id}}').setView([latitude, longitude], 13);
    
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
    
            L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Location of {{$d->name}}').openPopup();
            });
        });
        @endforeach
    
        @foreach($telat as $d)
        document.addEventListener('DOMContentLoaded', function () {
            $('#detailModal-{{$d->id}}').on('shown.bs.modal', function () {
            // Assuming $d->location is in "latitude, longitude" format
            let location = "{{$d->location}}".split(',');
            let latitude = parseFloat(location[0].trim());
            let longitude = parseFloat(location[1].trim());
    
            var map = L.map('map-{{$d->id}}').setView([latitude, longitude], 13);
    
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);
    
            L.marker([latitude, longitude]).addTo(map)
                .bindPopup('Location of {{$d->name}}').openPopup();
            });
        });
        @endforeach
    </script>
    
    
    @endsection
