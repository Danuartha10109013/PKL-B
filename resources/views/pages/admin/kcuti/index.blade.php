@extends('layout.main')
@section('title', 'Dashboard || Admin')

@section('content')
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="card-title fw-semibold">Kelola Cuti</h5>
                </div>

                <div class="row">
                    <!-- Pengajuan Cuti Section -->
                    <div class="col-md-6 mb-4">
                        <h6>Pengajuan Cuti</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Title</th>
                                        <th>Jenis Cuti</th>
                                        <th>Nama Karyawan</th>
                                        <th>Alasan Cuti</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->title }}</td>
                                        <td>{{ $d->jenis_cuti }}</td>
                                        <td>
                                            @php
                                                $nama = \App\Models\User::where('id',$d->user_id)->value('name');
                                            @endphp
                                            {{ $nama }}
                                        </td>
                                        <td>{{ $d->alasan_cuti }}</td>
                                        <td>{{ $d->start }}</td>
                                        <td>{{ $d->end }}</td>
                                        <td>
                                            @php
                                                $file = \App\Models\Cuti::where('id', $d->id)->value('bukti');
                                            @endphp

                                            @if ($file)  {{-- Ensure the file exists --}}
                                                <a href="{{route('admin.kcuti.download',$d->id)}}" class="btn btn-warning mb-2 ml-2">Download Bukti</a>
                                            @endif


                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal" 
                                               data-id="{{ $d->id }}" data-keterangan="{{ $d->keterangan }}">Response</a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-bs-labelledby="updateModalLabel" aria-bs-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateModalLabel">Update Leave Request</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="updateCutiForm" action="{{ route('admin.kcuti.update',$d->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT') <!-- Ensure you set this if you're using PUT method -->
                                                                <input type="hidden" name="id" id="cutiId" value="">
                                                                
                                                                <div class="mb-3">
                                                                    <label for="keterangan" class="form-label">Keterangan</label>
                                                                    <textarea class="form-control" name="keterangan" id="keterangan" rows="3" required></textarea>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select class="form-control" name="status" id="status" required>
                                                                        <option value="" selected disabled>--Pilih Status--</option>
                                                                        <option value="Disetujui">Disetujui</option>
                                                                        <option value="Ditolak">Ditolak</option>
                                                                    </select>
                                                                </div>
                                                                
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Riwayat Cuti Section -->
                    <div class="col-md-6 mb-4">
                        <h6 class="text-end">Riwayat Cuti</h6>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>Title</th>
                                        <th>Jenis Cuti</th>
                                        <th>Nama Karyawan</th>
                                        <th>Alasan Cuti</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data1 as $d)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $d->title }}</td>
                                        <td>{{ $d->jenis_cuti }}</td>
                                        <td>
                                            @php
                                                $nama = \App\Models\User::where('id',$d->user_id)->value('name');
                                            @endphp
                                            {{ $nama }}
                                        </td>
                                        <td>{{ $d->alasan_cuti }}</td>
                                        <td>{{ $d->start }}</td>
                                        <td>{{ $d->end }}</td>
                                        <td>
                                            <p class="text-{{ $d->status == 1 ? 'success' : 'danger' }}">{{$d->status == 1 ? 'Disetujui' : 'Ditolak'}}</p>
                                        </td>
                                    </tr>
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



@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#updateModal').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget); // Button that triggered the modal
        var id = button.data('id'); // Extract info from data-* attributes
        var keterangan = button.data('keterangan');

        var modal = $(this);
        modal.find('#cutiId').val(id); // Set the hidden input field value
        modal.find('#keterangan').val(keterangan); // Populate the keterangan textarea
        modal.attr('action', modal.attr('action').replace(/\/\d+$/, '/' + id)); // Update the form action URL
    });
});
</script>
@endsection
