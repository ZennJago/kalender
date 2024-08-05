<!DOCTYPE html>
<html>
<head>
    <title>Booking</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <style>
        body {
            background-color: #F7B5CA;
        }
        .container {
            background-color: #ffffff; /* White background for container */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            height: auto;
            width: 1500px;
        }
        .modal-content {
            border-radius: 8px;
        }
        .fc-event {
            background-color: #00ff04; /* White background for event blocks */
            color: #000000; /* Black text color for events */
            text-align: center;
            border-color: #00ff04;
        }
        .contact-info, .qr-code {
            background-color: #ADD8E6;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }
        .contact-info {
            height: 250px;
        }
        .qr-code {
            height: 300px;
            text-align: center;
        }
        .contact-info h2, .qr-code h2 {
            margin-bottom: 15px;
            text-align: center; /* Center-align headings */
        }
        .contact-info p, .qr-code img {
            margin: 5px 0;
        }
        .qr-code img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px; /* Optional: rounds the corners of the QR code image */
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 4px solid #000000;
            background: #ffffff;
            color: #000000;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-7">
                <h2 class="mb-4">Booking</h2>
                <div id='calendar'></div>
                <!-- Add Search Button Here -->
                <div class="mt-4">
                    <a href="{{ url('/search') }}" class="btn btn-primary">Search Events</a>
                </div>
            </div>
            <div class="col-md-5">
                <div class="contact-info">
                    <h2>Kontak</h2>
                    <p><i class="icon fa fa-clock-o"></i> Jam Operasional: 07.30 - 16.00 WIB</p>
                    <p><i class="icon fa fa-phone"></i> Telp: 021-8009165</p>
                    <p><i class="icon fa fa-envelope"></i> Email: <a href="mailto:keckramatjati04@gmail.com">keckramatjati04@gmail.com</a>, <a href="mailto:kecamatan_kramatjati@jakarta.go.id">kecamatan_kramatjati@jakarta.go.id</a></p>
                    <p><i class="icon fa fa-instagram"></i> Instagram: <a href="https://www.instagram.com/kecamatan.kramatjati" target="_blank">@kecamatan.kramatjati</a></p>
                </div>
                <div class="qr-code">
                    <h2>Scan Di sini</h2>
                    <img src="./qr2.jpeg" alt="QR Code" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <!-- Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Event Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="eventForm">
                        <div class="form-group">
                            <label for="eventTitle">Event Title</label>
                            <input type="text" class="form-control" id="eventTitle" placeholder="Enter event title" required>
                        </div>
                        <div class="form-group">
                            <label for="eventStart">Start Date</label>
                            <input type="date" class="form-control" id="eventStart" required>
                        </div>
                        <div class="form-group">
                            <label for="eventEnd">End Date</label>
                            <input type="date" class="form-control" id="eventEnd" required>
                        </div>
                        <div class="form-group">
                            <label for="eventNamaRuang">Nama Ruang</label>
                            <input type="text" class="form-control" id="eventNamaRuang" placeholder="Enter room name" required>
                        </div>
                        <div class="form-group">
                            <label for="eventBaju">Baju</label>
                            <input type="text" class="form-control" id="eventBaju" placeholder="Enter clothes details" required>
                        </div>
                        <input type="hidden" id="eventId">
                        <input type="hidden" id="eventType">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveEvent">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Show Event Modal -->
    <div class="modal fade" id="showEventModal" tabindex="-1" role="dialog" aria-labelledby="showEventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showEventModalLabel">Event Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Event Title:</strong> <span id="showEventTitle"></span></p>
                    <p><strong>Start Date:</strong> <span id="showEventStart"></span></p>
                    <p><strong>End Date:</strong> <span id="showEventEnd"></span></p>
                    <p><strong>Nama Ruang:</strong> <span id="showEventNamaRuang"></span></p>
                    <p><strong>Baju:</strong> <span id="showEventBaju"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="editEvent">Edit</button>
                    <button type="button" class="btn btn-danger" id="deleteEventShow">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var SITEURL = "{{ url('/') }}";
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            var calendar = $('#calendar').fullCalendar({
                editable: true,
                events: SITEURL + "/",
                displayEventTime: false,
                eventRender: function(event, element) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                },
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {
                    $('#eventModal').modal('show');
                    $('#eventModalLabel').text('Add New Event');
                    $('#eventForm')[0].reset();
                    $('#eventId').val('');
                    $('#eventType').val('add');
                    $('#eventStart').val($.fullCalendar.formatDate(start, "YYYY-MM-DD"));
                    // Subtract one day from the end date
                    $('#eventEnd').val($.fullCalendar.formatDate(moment(end).subtract(1, 'days'), "YYYY-MM-DD"));
                },
                eventClick: function(event) {
                    $('#showEventModal').modal('show');
                    $('#showEventModalLabel').text('Event Details');
                    $('#showEventTitle').text(event.title);
                    $('#showEventStart').text($.fullCalendar.formatDate(event.start, "YYYY-MM-DD"));
                    // Subtract one day from the end date
                    $('#showEventEnd').text($.fullCalendar.formatDate(moment(event.end).subtract(1, 'days'), "YYYY-MM-DD"));
                    $('#showEventNamaRuang').text(event.nama_ruang);
                    $('#showEventBaju').text(event.baju);
                    $('#eventId').val(event.id);
                }
            });
    
            $('#saveEvent').on('click', function() {
                var title = $('#eventTitle').val();
                var start = $('#eventStart').val();
                var end = $('#eventEnd').val();
                var nama_ruang = $('#eventNamaRuang').val();
                var baju = $('#eventBaju').val();
                var id = $('#eventId').val();
                var type = $('#eventType').val();
    
                // Adjust the end date by adding one day
                end = moment(end).add(1, 'days').format("YYYY-MM-DD");
    
                $.ajax({
                    url: SITEURL + "/manage-event",
                    data: {
                        title: title,
                        start: start,
                        end: end,
                        nama_ruang: nama_ruang,
                        baju: baju,
                        id: id,
                        type: type
                    },
                    type: "POST",
                    success: function(data) {
                        $('#eventModal').modal('hide');
                        calendar.fullCalendar('refetchEvents');
                        toastr.success('Event Saved');
                    }
                });
            });
    
            $('#deleteEvent').on('click', function() {
                var id = $('#eventId').val();
                $.ajax({
                    url: SITEURL + "/manage-event",
                    data: {
                        id: id,
                        type: 'delete'
                    },
                    type: "POST",
                    success: function(data) {
                        $('#eventModal').modal('hide');
                        calendar.fullCalendar('refetchEvents');
                        toastr.success('Event Deleted');
                    }
                });
            });
    
            $('#editEvent').on('click', function() {
                var id = $('#eventId').val();
                var event = calendar.fullCalendar('clientEvents', id)[0];
                $('#showEventModal').modal('hide');
                $('#eventModal').modal('show');
                $('#eventModalLabel').text('Edit Event');
                $('#eventTitle').val(event.title);
                $('#eventStart').val($.fullCalendar.formatDate(event.start, "YYYY-MM-DD"));
                // Subtract one day from the end date
                $('#eventEnd').val($.fullCalendar.formatDate(moment(event.end).subtract(1, 'days'), "YYYY-MM-DD"));
                $('#eventNamaRuang').val(event.nama_ruang);
                $('#eventBaju').val(event.baju);
                $('#eventId').val(event.id);
                $('#eventType').val('update');
            });
    
            $('#deleteEventShow').on('click', function() {
                var id = $('#eventId').val();
                $.ajax({
                    url: SITEURL + "/manage-event",
                    data: {
                        id: id,
                        type: 'delete'
                    },
                    type: "POST",
                    success: function(data) {
                        $('#showEventModal').modal('hide');
                        calendar.fullCalendar('refetchEvents');
                        toastr.success('Event Deleted');
                    }
                });
            });
        });
    </script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    
    <div class="footer">
        &copy; Dani Setiyawan.
    </div>
</body>
</html>
