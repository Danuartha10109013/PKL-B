@extends('layout.main')
@section('title', 'Dashboard || Admin')

@section('content')
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h5 class="card-title fw-semibold">Kelola Cuti</h5>
                    <a href="/run-schedule">reset cuti</a>
                </div>

                <div class="row">
                    <!-- Pengajuan Cuti Section -->
                    <div class="col-md-12 mb-4">
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
                                                $nama = \App\Models\User::where('id', $d->user_id)->value('name');
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
                            
                                            @if ($file)
                                                <a href="{{ route('admin.kcuti.download', $d->id) }}" class="btn btn-warning mb-2 ml-2">Download Bukti</a>
                                            @endif
                            
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal" 
                                               data-bs-target="#updateModal{{ $d->id }}">Response</a>
                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="updateModal{{ $d->id }}" tabindex="-1" 
                                                 role="dialog" aria-labelledby="updateModalLabel{{ $d->id }}" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="updateModalLabel{{ $d->id }}">Update Leave Request</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="updateCutiForm{{ $d->id }}" action="{{ route('admin.kcuti.update', $d->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="text" name="id" value="{{ $d->id }}">
                            
                                                                <div class="mb-3">
                                                                    <label for="keterangan{{ $d->id }}" class="form-label">Keterangan</label>
                                                                    <textarea class="form-control" name="keterangan" id="keterangan{{ $d->id }}" rows="3" required></textarea>
                                                                </div>
                            
                                                                <div class="mb-3">
                                                                    <label for="status{{ $d->id }}" class="form-label">Status</label>
                                                                    <select class="form-control" name="status" id="status{{ $d->id }}" required>
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
                    <div class="col-md-12 mb-4">
                        <h6 class="text-start mb-2">Riwayat Cuti</h6>
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
                                        <th>Action</th>
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
                                        <td>
                                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal{{ $d->id }}">
                                                <i class="ti ti-edit"></i> Edit
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editModal{{ $d->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $d->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel{{ $d->id }}">Edit Cuti</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin.kcuti.updatin', $d->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="title{{ $d->id }}" class="form-label">Title</label>
                                                            <input type="text" class="form-control" id="title{{ $d->id }}" name="title" value="{{ $d->title }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="jenisCuti{{ $d->id }}" class="form-label">Jenis Cuti</label>
                                                            <input type="text" class="form-control" id="jenisCuti{{ $d->id }}" name="jenis_cuti" value="{{ $d->jenis_cuti }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="alasanCuti{{ $d->id }}" class="form-label">Alasan Cuti</label>
                                                            <textarea class="form-control" id="alasanCuti{{ $d->id }}" name="alasan_cuti" rows="3" required>{{ $d->alasan_cuti }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="start{{ $d->id }}" class="form-label">Start Date</label>
                                                            <input type="date" class="form-control" id="start{{ $d->id }}" name="start" value="{{ $d->start }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="end{{ $d->id }}" class="form-label">End Date</label>
                                                            <input type="date" class="form-control" id="end{{ $d->id }}" name="end" value="{{ $d->end }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="status{{ $d->id }}" class="form-label">Status</label>
                                                            <select class="form-select" id="status{{ $d->id }}" name="status" required>
                                                                <option value="1" {{ $d->status == 1 ? 'selected' : '' }}>Disetujui</option>
                                                                <option value="2" {{ $d->status == 2 ? 'selected' : '' }}>Ditolak</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                                    </div>
                                                </form>
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
