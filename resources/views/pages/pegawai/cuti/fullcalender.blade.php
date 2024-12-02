<!DOCTYPE html>
<html>
<head>
    <title>Pengajuan Cuti || Pegawai</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<div class="container">
    <a href="{{ route('pegawai.cuti') }}" class="btn btn-dark mt-5">Back</a>
    <div class="card mt-5">
        <h3 class="card-header p-3">Pengajuan Cuti</h3>
        <div class="card-body">
            <div id='calendar'></div>
        </div>
    </div>
</div>

<!-- Modal for Event Input -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Ajukan Cuti</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <div class="mb-3">
                        <label for="eventTitle" class="form-label">Judul Cuti</label>
                        <input type="text" class="form-control" id="eventTitle" name="eventTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="alasanCuti" class="form-label">Alasan Cuti</label>
                        <select class="form-control" id="alasanCuti" name="alasan_cuti" required>
                            <option value="" selected disabled>--Pilih Alasan--</option>
                            <option value="Pernikahan">Pernikahan</option>
                            <option value="Keperluan Keluarga">Keperluan Keluarga</option>
                            <option value="Urusan Pendidikan">Urusan Pendidikan</option>
                            <option value="Relaksasi">Relaksasi/Penyegaran</option>
                            <option value="Liburan">Liburan</option>
                        </select>
                    </div>
                    <input type="hidden" id="eventStart" name="start">
                    <input type="hidden" id="eventEnd" name="end">
                    <button type="submit" class="btn btn-primary">Save Event</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        var SITEURL = "{{ url('/') }}";

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendar = $('#calendar').fullCalendar({
            editable: true,
            events: SITEURL + "/pegawai/cuti/fullcalender", 
            displayEventTime: false,
            eventRender: function (event, element) {
                var color;
                // Set the color based on the status
                if (event.status == 0) {
                    color = 'orange'; // Pending
                } else if (event.status == 1) {
                    color = 'green'; // Approved
                } else if (event.status == 2) {
                    color = 'red'; // Rejected
                }

                // Apply the color to the event background
                element.css('background-color', color);

                // Add user name to event title if available
                if (event.user_name) {
                    element.find('.fc-title').prepend(event.user_name + " - ");
                }
            },
            selectable: true,
            selectHelper: true,
            select: function (start, end) {
                $('#eventStart').val(moment(start).utc().format("YYYY-MM-DD"));
                $('#eventEnd').val(moment(end).utc().subtract(1, 'days').format("YYYY-MM-DD"));
                $('#eventModal').modal('show');
            },
            eventDrop: function (event) {
                var start = moment(event.start).utc().format("YYYY-MM-DD");
                var end = moment(event.end).utc().add(1, 'days').format("YYYY-MM-DD"); // Add one day to fix the end date issue

                $.ajax({
                    url: SITEURL + '/pegawai/cuti/fullcalenderAjax',
                    data: {
                        title: event.title,
                        start: start,
                        end: end,
                        id: event.id,
                        type: 'update'
                    },
                    type: "POST",
                    success: function () {
                        Swal.fire('Updated!', 'Event successfully updated.', 'success');
                    },
                    error: function (xhr) {
                        Swal.fire('Error!', xhr.responseJSON.error, 'error');
                    }
                });
            },
            eventClick: function (event) {
                if (event.status == 1) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'This event cannot be deleted because it has been approved.',
                        icon: 'error'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to delete this event?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: SITEURL + '/pegawai/cuti/fullcalenderAjax',
                            data: {
                                id: event.id,
                                type: 'delete'
                            },
                            success: function () {
                                $('#calendar').fullCalendar('removeEvents', event.id);
                                Swal.fire('Deleted!', 'Your event has been deleted.', 'success');
                            },
                            error: function (xhr) {
                                Swal.fire('Error!', xhr.responseJSON.error, 'error');
                            }
                        });
                    }
                });
            }
        });

        $('#eventForm').on('submit', function (e) {
            e.preventDefault();
            var title = $('#eventTitle').val();
            var start = $('#eventStart').val();
            var end = $('#eventEnd').val();
            var alasanCuti = $('#alasanCuti').val();

            $.ajax({
                url: SITEURL + "/pegawai/cuti/fullcalenderAjax",
                data: {
                    title: title,
                    start: start,
                    end: end,
                    alasan_cuti: alasanCuti,
                    type: 'add'
                },
                type: "POST",
                success: function (data) {
                    $('#eventModal').modal('hide');
                    $('#eventForm')[0].reset();
                    calendar.fullCalendar('renderEvent', {
                        id: data.id,
                        title: title,
                        start: start,
                        end: moment(end).add(1, 'days').format("YYYY-MM-DD"),
                        allDay: true,
                        status: 0
                    }, true);
                    calendar.fullCalendar('unselect');
                    Swal.fire('Added!', 'Event created successfully', 'success');
                },
                error: function (xhr) {
                    Swal.fire('Error!', xhr.responseJSON.error, 'error');
                }
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
</body>
</html>
