<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROOM 911</title>
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/menu.css') }}">
    <script src="{{URL::asset('js/menu.js')}}"></script>
</head>
<body>

    <div class="container mt-4">
        @if(request("export")!=1)
            <div class="row">
                <div class="col-2"></div>
                <div class="col-2">Initial access date</div>
                <div class="col-2">Final access date</div>
            </div>
            <form action="{{ route('history-filter', ['id_admin_room_911' => $id_admin_room_911, 'id_employee' => $employee->id_employee]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-2">
                        <a class='btn btn-info' href="/menu/{{ $id_admin_room_911 }}">Back</a>
                    </div>
                    <div class="col-2">
                        <input id="date1" name="date1" onchange="requiredTrue('date2')" class="form-control" type="date" placeholder="Initial access date">
                    </div>
                    <div class="col-2">
                        <input id="date2" name="date2" onchange="requiredTrue('date1')" class="form-control" type="date" placeholder="Final access date">
                    </div>
                    <div class="col-2">
                        <button id="button" type="submit" class="btn btn-secondary">Filter</button>
                    </div>
                    <div class="col-2">
                        <a class='btn btn-primary' href='{{url("history/$id_admin_room_911/$employee->id_employee/?export=1")}}'>Export PDF</a>
                    </div>
                </div>
            </form>
        @endif
        <br>
        <h3>History of access attempts ({{ $n_access }}) - {{ $employee->firstname . " " . $employee->lastname }}</h3>
        <div class="row">
            <table class="table table-bordered">
                <thead class="thead secondary">
                    <tr style="background-color: rgb(165, 165, 165)">
                        <th>Employee ID</th>
                        <th>Access state</th>
                        <th>Datetime of attempt</th>
                    </tr>
                </thead>
                @foreach ($accesses as $access)
                    <tr>
                        <td>{{ $access->id_number }}</td>
                        <td>{{ $access->attempt_access }}</td>
                        <td>{{ $access->attempt_datetime }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
</body>
</html>