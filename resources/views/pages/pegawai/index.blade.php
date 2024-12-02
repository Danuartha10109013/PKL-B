@extends('layout.main')
@section('title')
Dashboard || Pegawai
@endsection
@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row">
  <div class="col-lg-8 d-flex align-items-stretch">
    <div class="card w-100">
        <div class="card-body">
            <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Absensi</h5>
                    <form action="{{ route('pegawai.dashboard') }}" method="GET">
                        <div class="d-flex align-items-center">
                            <select name="bulan" class="form-select me-2">
                                <option value="" selected>Pilih Bulan</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                @endfor
                            </select>
                            <select name="tahun" class="form-select me-2">
                                <option value="" selected>Pilih Tahun</option>
                                @for ($year = now()->year; $year >= now()->year - 5; $year--)
                                    <option value="{{ $year }}" {{ request('tahun') == $year ? 'selected' : '' }}>
                                        {{ $year }}
                                    </option>
                                @endfor
                            </select>
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>
            <canvas id="absensiChart"></canvas>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('absensiChart').getContext('2d');

        const data = {
            labels: ['Absen Masuk', 'Absen Pulang'],
            datasets: [{
                label: 'Absensi',
                data: [{{ $masuk }}, {{ $pulang }}], // Data utama (agregat)
                backgroundColor: ['#4caf50', '#f44336'], // Warna utama
                hoverBackgroundColor: ['#66bb6a', '#e57373'],
            }]
        };

        const subData = {
            masukTepat: {{ $masukTepat }},
            telatMasuk: {{ $telatMasuk }},
            pulangTepat: {{ $pulangTepat }},
            pulangLebihAwal: {{ $pulangLebihAwal }}
        };

        new Chart(ctx, {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                const label = tooltipItem.label;
                                if (label === 'Absen Masuk') {
                                    return [
                                        `Tepat Waktu: ${subData.masukTepat}`,
                                        `Telat: ${subData.telatMasuk}`
                                    ];
                                } else if (label === 'Absen Pulang') {
                                    return [
                                        `Tepat Waktu: ${subData.pulangTepat}`,
                                        `Lebih Awal: ${subData.pulangLebihAwal}`
                                    ];
                                }
                                return tooltipItem.label;
                            }
                        }
                    },
                    legend: {
                        position: 'bottom',
                    },
                }
            }
        });
    });
</script>



    <div class="col-lg-4">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <a href="{{ route('pegawai.absensi.masuk') }}">
                <h5 class="card-title fw-semibold mb-4">Absen Masuk</h5>
                  <img src="{{asset('imageuser.svg')}}" width="10%" class="card-img-top" alt="...">
              </a>
            </div>
          </div>
          <!-- Yearly Breakup -->
        </div>
        <div class="col-lg-12">
          <!-- Monthly Earnings -->
          <div class="card">
            <div class="card-body">
              <a href="{{ route('pegawai.absensi.pulang') }}">
                <h5 class="card-title fw-semibold mb-4">Absen Pulang</h5>
                  <img src="{{asset('location.svg')}}" width="25%" class="card-img-top" alt="...">
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



  @endsection