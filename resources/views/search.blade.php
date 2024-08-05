<!DOCTYPE html>
<html>
<head>
    <title>Search Events</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <style>
        body {
            background-color: #F7B5CA; 
        }
        .container {
            background-color: #ffffff; /* White background for container */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 7px 12px rgba(0, 0, 0, 0.1);
            height: auto;
            width: 1500px;
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
    <h2>Search Events</h2>

    <form method="GET" action="{{ url('/search') }}">
        <div class="form-group">
            <label for="title">Event Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter event title">
        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" class="form-control" id="start_date" name="start_date">
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" class="form-control" id="end_date" name="end_date">
        </div>
        <div class="form-group">
            <label for="nama_ruang">Nama Ruang</label>
            <input type="text" class="form-control" id="nama_ruang" name="nama_ruang" placeholder="Masukkan Nama Ruang">
        </div>
        <div class="form-group">
            <label for="baju">Baju</label>
            <input type="text" class="form-control" id="baju" name="baju" placeholder="Masukkan Baju">
        </div>
        <button type="submit" class="btn btn-primary">Search</button>
        <a href="{{ url('') }}" class="btn btn-dark">Back</a>
    </form>

    @if(isset($events))
    <h2 class="mt-5">Search Results</h2>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Nama Ruang</th>
                <th>Baju</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $event)
            <tr>
                <td>{{ $event->id }}</td>
                <td>{{ $event->title }}</td>
                <td>{{ \Carbon\Carbon::parse($event->start)->format('Y-m-d') }}</td>
                <td>{{ \Carbon\Carbon::parse($event->end)->format('Y-m-d') }}</td>
                <td>{{ $event->nama_ruang }}</td>
                <td>{{ $event->baju }}</td>
            </tr>
            @endforeach
        </tbody>        
    </table>
    @endif
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<div class="footer">
    &copy; Dani Setiyawan.
</div>
</body>
</html>
