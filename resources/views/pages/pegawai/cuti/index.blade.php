@extends('layout.main')
@section('title')
Cuti || Pegawai
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
      <div class="card w-100">
        <div class="card-body">
          <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
            <div class="mb-3 mb-sm-0">
              <h5 class="card-title fw-semibold">Cuti</h5>
            </div>
            
          </div>
          <p>Total Cuti tersedia Tahun ini : {{Auth::user()->saldo_cuti}}</p>
          <div class="row">
            <div class="col-md-6">
                <a href="{{route('pegawai.calendar')}}" class="btn btn-success">Ajukan Cuti tahunan</a>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                      <thead class="text-dark fs-4">
                        <tr>
                          <th class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">No</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Judul</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Status</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Keterangan</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">Start Date</h6>
                          </th>
                          <th class="border-bottom-0">
                            <h6 class="fw-semibold mb-0">End Date</h6>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($data as $d)
                            
                        <tr>
                          <td class="border-bottom-0 text-center">
                            <h6 class="fw-semibold mb-0">{{$loop->iteration}}</h6>
                          </td>
                          <td class="border-bottom-0">
                            <h6 class="fw-semibold mb-1">{{$d->title}}</h6>
                          </td>
                          <td class="border-bottom-0">
                            <p class="mb-0 fw-normal {{ $d->status == 0 ? 'text-warning' : 'text-success' }}">
                                {{ $d->status == 0 ? "Belum Diperiksa" : "Disetujui" }}
                            </p>
                          </td>
                          <td class="border-bottom-0">
                            <p class="mb-0 fw-normal">{{$d->keterangan}}</p>
                          </td>
                          <td class="border-bottom-0">{{$d->start}}</td>
                          <td class="border-bottom-0">{{$d->end}}</td>
                        </tr>

                        @endforeach
                        
                      </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cutiModal">Ajukan Cuti Lain-Lain</a>
                <div class="table-responsive">
                    <table class="table text-nowrap mb-0 align-middle">
                        <thead class="text-dark fs-4">
                            <tr>
                                <th class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">No</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Judul</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Status</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Keterangan</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">Start Date</h6>
                                </th>
                                <th class="border-bottom-0">
                                    <h6 class="fw-semibold mb-0">End Date</h6>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data1 as $d)
                            <tr>
                                <td class="border-bottom-0 text-center">
                                    <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <h6 class="fw-semibold mb-1">{{ $d->title }}</h6>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal {{ $d->status == 0 ? 'text-warning' : ($d->status == 1 ? "text-success" : "text-danger") }}">
                                        {{ $d->status == 0 ? "Belum Diperiksa" : ($d->status == 1 ? "Disetujui" : "Ditolak") }}
                                    </p>
                                </td>
                                <td class="border-bottom-0">
                                    <p class="mb-0 fw-normal">{{ $d->keterangan }}</p>
                                </td>
                                <td class="border-bottom-0">{{ $d->start }}</td>
                                <td class="border-bottom-0">{{ $d->end }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Modal for Submitting Cuti -->
            <div class="modal fade" id="cutiModal" tabindex="-1" aria-labelledby="cutiModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cutiModalLabel">Ajukan Cuti</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="cutiForm" action="{{ route('pegawai.cuti.store') }}" enctype="multipart/form-data" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label">Judul</label>
                                    <input type="text" class="form-control" name="title" id="title" required>
                                </div>
                                <div class="mb-3">
                                    <label for="alasan" class="form-label">Alasan Cuti</label>
                                    <select type="text" class="form-control" name="alasan_cuti" id="alasan" required>
                                        <option value="" selected disabled>--Pilih Alasan--</option>
                                        <option value="Sakit">Sakit</option>
                                        <option value="Izin">Izin</option>
                                    </select>
                                    <input type="text" name="jenis_cuti" value="lain-lain" hidden>
                                </div>
                                <div class="mb-3">
                                    <label for="start" class="form-label">Bukti</label>
                                    <input type="file" class="form-control" name="bukti" id="start" required>
                                </div>
                                <div class="mb-3">
                                    <label for="start" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="start" id="start" required>
                                </div>
                                <div class="mb-3">
                                    <label for="end" class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end" id="end" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Ajukan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Bootstrap JavaScript dependencies -->
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
            
          </div>
        </div>
      </div>
    </div>
</div>
@endsection