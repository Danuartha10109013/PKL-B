@extends('layout.main')
@section('title')
All Karyawan || {{ Auth::user()->role == 0 ? 'Admin' : 'Pegawai' }}
@endsection

@section('content')
    <style>
        .custom-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border-radius: 15px;
            background: #ffffff;
            position: relative;
            z-index: 1;
        }

        .custom-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        .custom-card::before {
            content: "";
            position: absolute;
            top: -10px;
            bottom: -10px;
            left: -10px;
            right: -10px;
            border-radius: 20px;
            background: rgba(0, 0, 0, 0.05);
            z-index: -1;
        }

        .bg-gradient {
            background: linear-gradient(135deg, #ff7e5f 0%, #feb47b 100%);
            padding: 1rem 0;
            border-radius: 15px 15px 0 0;
        }

        .text-primary {
            color: #2b6cb0 !important;
        }

        .text-secondary {
            color: #6c757d;
        }

        .rounded-circle {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }

        .container-center {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }
    </style>
    <center>
        <h1 class="my-4 fw-bolder" style="font-size: 24px;;">All Karyawan</h1>
    </center>
    <div class="container-center">
        @php
            $users = \App\Models\User::all();
        @endphp
        @foreach ($users as $user)
            <div class="col-md-4 col-lg-3 mb-4 ms-4">
                <div class="card shadow-sm border-0 custom-card h-100">
                    <div class="card-header text-center bg-gradient">
                        <img src="{{ $user->profile ? asset('storage/' . $user->profile) : asset('PT. Bersama Sahabat Makmur Logo.png') }}" 
                             alt="{{ $user->profile }}" 
                             class="rounded-circle border border-light shadow" 
                             style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <div class="card-body text-center">
                        <h5 class="card-title fw-bold text-primary">{{ $user->name }}</h5>
                        <p class="card-text text-secondary">
                            <strong>Jabatan:</strong> {{ $user->jabatan ?? 'N/A' }}<br>
                            <strong>Tanggal Lahir:</strong> {{ $user->birth_date ? $user->birth_date->format('d M Y') : 'N/A' }}<br>
                            <strong>Alamat:</strong> {{ $user->alamat ?? 'N/A' }}<br>
                            <strong>Email:</strong> {{ $user->email }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
