@extends('layout.main')
@section('title')
Dashboard || Admin
@endsection
@section('content')
<div class="row">
  <div class="col-lg-8 d-flex align-items-strech">
    <div class="card w-100">
        <div class="card-body">
            <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                <div class="mb-3 mb-sm-0">
                    <h5 class="card-title fw-semibold">Tren Absensi</h5>
                </div>
                <div>
                    <form method="GET" action="{{ route('admin.dashboard') }}">
                        <div class="d-flex">
                            <input type="month" name="month" class="form-control me-2" value="{{ request('month') }}">
                            <input type="number" name="year" class="form-control me-2" value="{{ request('year', date('Y')) }}" placeholder="Year">
                            <input type="date" name="start_date" class="form-control me-2" value="{{ request('start_date') }}">
                            <input type="date" name="end_date" class="form-control me-2" value="{{ request('end_date') }}">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Display Chart -->
            <canvas id="attendanceChart"></canvas>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById('attendanceChart').getContext('2d');
                var attendanceChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Absen Masuk', 'Absen Pulang'],
                        datasets: [{
                            label: 'Jumlah Absensi Tahun {{ $year }}',
                            data: [{{ $absenMasuk }}, {{ $absenPulang }}],
                            backgroundColor: ['#4caf50', '#ff5733'],
                            borderColor: ['#4caf50', '#ff5733'],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>
  </div>


    <div class="col-lg-4">
      <div class="row">
        <div class="col-lg-12">
          <!-- Yearly Breakup -->
          <div class="card overflow-hidden">
            <div class="card-body p-4">
              <h5 class="card-title mb-9 fw-semibold">Today's Late</h5>
              <div class="row align-items-center">
                <div class="col-8">
                  <h4 class="fw-semibold mb-3">{{$todaylate}}</h4>
                  <div class="d-flex align-items-center mb-3">
                    <span
                      class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                      <i class="ti ti-arrow-up-left text-success"></i>
                    </span>
                    <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                    <p class="fs-3 mb-0">last year</p>
                  </div>
                  <div class="d-flex align-items-center">
                    <div class="me-4">
                      <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                      <span class="fs-2">2023</span>
                    </div>
                    <div>
                      <span class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                      <span class="fs-2">2023</span>
                    </div>
                  </div>
                </div>
                <div class="col-4">
                  <div class="d-flex justify-content-center">
                    <div id="breakup"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-12">
          <!-- Monthly Earnings -->
          <div class="card">
            <div class="card-body">
              <div class="row alig n-items-start">
                <div class="col-8">
                  <h5 class="card-title mb-9 fw-semibold"> Monthly Leaves </h5>
                  <h4 class="fw-semibold mb-3">{{$monthlyleaves}}</h4>
                  <div class="d-flex align-items-center pb-1">
                    <span
                      class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                      <i class="ti ti-arrow-down-right text-danger"></i>
                    </span>
                    <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                    <p class="fs-3 mb-0">last year</p>
                  </div>
                </div>
                <div class="col-4">
                  <div class="d-flex justify-content-end">
                    <div
                      class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                      <i class="ti ti-currency-dollar fs-6"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="earning"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-lg-6 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <h5 class="card-title fw-semibold mb-4">Recent Attendance</h5>
          <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
              <thead class="text-dark fs-4">
                <tr>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">No</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Name</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Status</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Time</h6>
                  </th>
                  
                </tr>
              </thead>
              <tbody>
                @foreach ($absen as $a)
                  <tr>
                    <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{$loop->iteration}}</h6></td>
                    <td class="border-bottom-0">
                      @php
                        $nama = \App\Models\User::where('id', $a->user_id)->value('name');
                        $jabatan = \App\Models\User::where('id', $a->user_id)->value('jabatan');
                      @endphp
                        <h6 class="fw-semibold mb-1">{{$nama}}</h6>
                        <span class="fw-normal">{{$jabatan}}</span>                          
                    </td>
                    <td class="border-bottom-0">
                      @php
                          $createdTime = \Carbon\Carbon::parse($a->created_at)->format('H:i:s');
                          $keterangan = $a->type === 'masuk'
                              ? ($createdTime <= '09:00:00' ? 'Tepat Waktu' : 'Terlambat')
                              : ($createdTime >= '16:00:00' ? 'Tepat Waktu' : 'Pulang Lebih Awal');
                      @endphp
                      <p class="mb-0 fw-normal">{{$keterangan}}</p>
                      <td class="border-bottom-0">
                        <h6 class="fw-semibold mb-0">{{$a->created_at}}</h6>
                      </td>

                  </tr> 
                @endforeach

                                     
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-6 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <h5 class="card-title fw-semibold mb-4">Recent Leaves</h5>
          <div class="table-responsive">
            <table class="table text-nowrap mb-0 align-middle">
              <thead class="text-dark fs-4">
                <tr>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Id</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Name</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Jenis Cuti</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">Start</h6>
                  </th>
                  <th class="border-bottom-0">
                    <h6 class="fw-semibold mb-0">End</h6>
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($cuti as $c)
                  <tr>
                    <td class="border-bottom-0"><h6 class="fw-semibold mb-0">{{$loop->iteration}}</h6></td>
                    <td class="border-bottom-0">
                      @php
                      $nama = \App\Models\User::where('id', $c->user_id)->value('name');
                      $jabatan = \App\Models\User::where('id', $c->user_id)->value('jabatan');
                    @endphp
                      <h6 class="fw-semibold mb-1">{{$nama}}</h6>
                      <span class="fw-normal">{{$jabatan}}</span>                         
                    </td>
                    <td class="border-bottom-0">
                      <p class="mb-0 fw-normal">{{$c->jenis_cuti}}</p>
                    </td>
                    <td class="border-bottom-0">
                      <div class="d-flex align-items-center gap-2">
                        <h6 class="fw-semibold">{{$c->start}}</h6>
                      </div>
                    </td>
                    <td class="border-bottom-0">
                      <div class="d-flex align-items-center gap-2">
                        <h6 class="fw-semibold">{{$c->end}}</h6>
                      </div>
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

  @endsection