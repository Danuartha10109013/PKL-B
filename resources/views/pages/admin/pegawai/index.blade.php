@extends('layout.main')
@section('title')
Kelola Pegawai || Admin
@endsection
@section('content')

<div class="row">
  <div class="col-lg-12 d-flex align-items-stretch">
    <div class="card w-100">
      <div class="card-body p-4">
        <div class="d-flex justify-content-between">
            <h5 class="card-title fw-semibold mb-4">Kelola Pegawai</h5>
            <!-- Button to trigger Add Modal -->
            <a href="#" class="btn btn-primary rounded-1 fw-bold mb-3" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Tambah Pegawai</a>
        </div>
          
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
                  <h6 class="fw-semibold mb-0">Username</h6>
                </th>
                <th class="border-bottom-0">
                  <h6 class="fw-semibold mb-0">Jabatan</h6>
                </th>
                <th class="border-bottom-0">
                  <h6 class="fw-semibold mb-0">Action</h6>
                </th>
                <th class="border-bottom-0">
                  <h6 class="fw-semibold mb-0">Profile</h6>
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
                  <h6 class="fw-semibold mb-1">{{$d->name}}</h6>
                  <span class="fw-normal">{{$d->no_pegawai}}</span>
                </td>
                <td class="border-bottom-0">
                  <p class="mb-0 fw-normal">{{$d->username}}</p>
                </td>
                <td class="border-bottom-0">
                  <p class="mb-0 fw-normal">{{$d->jabatan}}</p>
                </td>
                <td class="border-bottom-0">
                  <div class="d-flex align-items-center gap-2">
                    @if ($d->active == 1)
                        <a href="{{route('admin.kelolapegawai.nonactive', $d->id)}}" class="btn  btn-primary fw-semibold">Active</a>
                    @else
                        <a href="{{route('admin.kelolapegawai.active', $d->id)}}" class="btn  btn-warning fw-semibold">Nonctive</a>
                    @endif
                    <!-- Button to trigger Edit Modal -->
                    <a href="#" class="btn  btn-warning fw-semibold" data-bs-toggle="modal" data-bs-target="#editEmployeeModal-{{$d->id}}">Edit</a>
                    <a href="{{route('admin.kelolapegawai.delete',$d->id)}}" class="btn  btn-danger fw-semibold">Delete</a>
                  </div>
                </td>
                <td class="border-bottom-0 text-center">
                  <img width="50px" class="rounded-circle d-flex justify-content-center" src="{{asset('storage/'.$d->profile)}}" alt="profile">
                </td>
              </tr>

              <!-- Edit Modal -->
              <div class="modal fade" id="editEmployeeModal-{{$d->id}}" tabindex="-1" aria-labelledby="editEmployeeModalLabel-{{$d->id}}" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="editEmployeeModalLabel-{{$d->id}}">Edit Pegawai</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('admin.kelolapegawai.edit', $d->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $d->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" value="{{ $d->username }}">
                            </div>
                            <div class="mb-3">
                                <label for="jabatan" class="form-label">Jabatan</label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" value="{{ $d->jabatan }}">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ $d->email }}">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                            </div>
                            <div class="mb-3">
                                <label for="avatar" class="form-label">Avatar</label>
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$d->profile) }}" alt="{{ $d->profile }}" class="img-fluid rounded" style="max-width: 200px; display: none;" id="avatar-preview">
                                </div>
                                <input type="file" id="avatar-input" name="avatar" class="form-control avatar-input" onchange="previewImage(event)">
                            </div>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </form>
                        
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

<!-- Add Modal -->
<div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addEmployeeModalLabel">Tambah Pegawai</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('admin.kelolapegawai.add') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Birthday</label>
                    <input type="date" class="form-control" id="username" name="birthday" required>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" id="username" name="jabatan" required>
                </div>
                <div class="mb-3">
                    <label for="avatar" class="form-label">Avatar</label>
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$d->profile) }}" alt="{{ $d->profile }}" class="img-fluid rounded" style="max-width: 150px; display: none;" id="avatar-preview1">
                    </div>
                    <input type="file" id="avatar-input" name="avatar" class="form-control avatar-input" onchange="previewImage1(event)">
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="username" class="form-label">No Pegawai</label>
                    <input type="text" class="form-control" id="username" name="no_pegawai" value="{{$nopegawai}}" readonly>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Email</label>
                    <input type="email" class="form-control" id="username" name="email" >
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label"><small >Password Automaticly : <p style="color: red">ShabatMakmur</p></small></label>
                </div>
            </div>
        </div>
          <button type="submit" class="btn btn-primary">Add Employee</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('avatar-preview');
            output.src = reader.result;
            output.style.display = 'block'; // Show the image preview
        };
        reader.readAsDataURL(event.target.files[0]);
    }
    function previewImage1(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const output = document.getElementById('avatar-preview1');
            output.src = reader.result;
            output.style.display = 'block'; // Show the image preview
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
