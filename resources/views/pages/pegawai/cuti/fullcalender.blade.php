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
            <a href="{{route('pegawai.cuti')}}" class="btn btn-dark mt-5" >Back</a>
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
                        <!-- HTML for Form inside Modal -->
                        <form id="eventForm">
                            <div class="mb-3">
                                <label for="eventTitle" class="form-label">Judul Cuti </label>
                                <input type="text" class="form-control" id="eventTitle" name="eventTitle" required>
                            </div>
                            <div class="mb-3">
                                <label for="eventTitle" class="form-label">Alasan Cuti </label>
                                <input type="text" class="form-control" id="alasanCuti" name="alasan_cuti" value="cc">
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
                        event.allDay = (event.allDay === 'true');

                        // Disable editing of the event if status is 1
                        if (event.status == 1) {
                            element.css('background-color', '#f00'); // Optional: Change color to indicate it can't be edited
                            element.css('cursor', 'not-allowed');
                            element.prop('disabled', true); // Prevent clicks on the element
                        }
                    },
                    selectable: true,
                    selectHelper: true,
                    select: function (start, end) {
                        $('#eventStart').val(moment(start).format("Y-MM-DD"));
                        $('#eventEnd').val(moment(end).format("Y-MM-DD"));
                        $('#eventModal').modal('show');
                    },
                    eventDrop: function (event) {
                        // Prevent moving if status is 1
                        if (event.status == 1) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Event cannot be moved because it has already been approved.',
                                icon: 'error'
                            });
                            // Prevent the drop action by reverting the event's position
                            calendar.fullCalendar('refetchEvents');
                            return false; // Prevent moving
                        }

                        var start = moment(event.start).format("Y-MM-DD");
                        var end = moment(event.end).format("Y-MM-DD");

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
                                Swal.fire('Updated!', 'Event updated successfully', 'success');
                            },
                            error: function (xhr) {
                                Swal.fire('Error!', xhr.responseJSON.error, 'error');
                            }
                        });
                    },
                    eventClick: function (event) {
                        // Disable editing on click if status is 1
                        if (event.status == 1) {
                            Swal.fire({
                                title: 'Error!',
                                text: 'This event cannot be edited because it has already been approved.',
                                icon: 'error'
                            });
                            return; // Prevent further action
                        }

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "Do you really want to delete this event?",
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
                                        calendar.fullCalendar('removeEvents', event.id);
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
                                end: end,
                                allDay: true,
                                status: 0 // Make sure to set initial status for new events
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
