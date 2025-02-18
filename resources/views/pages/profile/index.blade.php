@extends('layout.main')
@section('title')
Dashboard || Admin
@endsection
@section('content')
<style>
    .form-container {
        background-color: #e7f3ff; /* Blue background */
        padding: 20px;
        border-radius: 10px;
    }

    .avatar-input {
        background-color: #ffffff; /* White background for file input */
        padding: 10px;
    }

    .form-control {
        background-color: #f8f9fa; /* Background for all input fields */
        border: 1px solid #ced4da;
    }
</style>

<div class="row">
    <h5>Edit Profile</h5>
    <div class="col-md-12">
        <div class="unlimited-access hide-menu form-container d-flex justify-content-between mb-7 mt-1 rounded">
            <div class="d-flex">
                <div class="unlimited-access-title me-3">
                    <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ $data->name }}">
                                </div>
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" id="username" name="username" class="form-control" value="{{ $data->username }}">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="text" id="email" name="email" class="form-control" value="{{ $data->email }}">
                                </div>
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role</label>
                                    <input type="text" id="role" name="role" class="form-control" value="{{ $data->role == 0 ? 'Admin' : ($data->role == 1 ? 'Pegawai' : 'cc') }}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="no_wa" class="form-label">No WhatsApp</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="no_wa" 
                                        name="no_wa" 
                                        value="{{ $data->no_wa ?? '' }}"
                                    >
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea 
                                        type="text" 
                                        class="form-control" 
                                        id="alamat" 
                                        name="alamat" 
                                    >{{ $data->alamat ?? '' }}</textarea>
                                </div>
                                
                                
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="avatar" class="form-label">Avatar</label>
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$data->profile) }}" alt="{{ $data->profile }}" class="img-fluid rounded" style="max-width: 150px; display: none;" id="avatar-preview">
                                    </div>
                                    <input type="file" id="avatar-input" name="avatar" class="form-control avatar-input" onchange="previewImage(event)">
                                </div>
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="tempat_lahir" 
                                        name="tempat_lahir" 
                                        value="{{ $data->tempat_lahir ?? '' }}"
                                    >
                                </div>
                                <div class="mb-3">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input 
                                        type="date" 
                                        class="form-control" 
                                        id="birthday" 
                                        name="birthday" 
                                        value="{{ $data->birthday ?? '' }}"
                                    >
                                </div>
                                
                                <div class="mb-3">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-control" id="gender" name="gender">
                                        <option value="" disabled {{ !$data->gender ? 'selected' : '' }}>--Pilih Gender--</option>
                                        <option value="Laki-Laki" {{ $data->gender == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                        <option value="Perempuan" {{ $data->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" id="password" name="password" class="form-control" placeholder="New Password Here">
                                </div>
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Password Confirmation</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Password Confirmation Here">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
            <div class="d-flex justify-content-end">
                <img src="{{ asset('vendor/assets/images/backgrounds/rocket.png') }}" alt="Rocket">
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
</script>

@endsection
