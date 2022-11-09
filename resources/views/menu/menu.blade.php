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
<body onload="showTime()">
    <!-- Title, time and username -->
    <div class="container-fluid">
        <div class="row">
            <div id="title" class="col">Administrative Menu</div>
        </div>
        <div class="row">
            <div id="time" class="col-2"></div>
            <div class="col-8"></div>
            <div id="username" class="col-2">Welcome:[-{{ $admin_username }}]</div>
        </div>
    </div>
    <br>
    <br>
    <!-- Filters -->
    <div class="container">
        <form action="{{ route('menu-edit', ['id_admin_room_911' => $id_admin_room_911]) }}" method="POST">
            @csrf
            <div class="row">
                <div class="col-5"></div>
                <div class="col-2">Initial access date:</div>
                <div class="col-2">Final access date:</div>
            </div>
            <div class="row">
                <div class="col-2">
                    <input id="employeeid" name="employeeid" class="form-control rounded-pill" type="search" placeholder="Search by employee">
                </div>
                <div class="col-3">
                    <select id="department" name="department" class="form-select" aria-label="Default select example">
                        <option value="null">Filter by department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id_department }}">{{ $department->department_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-2">
                    <input id="date1" name="date1" onchange="requiredTrue('date2')" class="form-control" type="date" placeholder="Initial access date">
                </div>
                <div class="col-2">
                    <input id="date2" name="date2" onchange="requiredTrue('date1')" class="form-control" type="date" placeholder="Final access date">
                </div>
                <div class="col-1">
                    <button id="button" type="submit" class="btn btn-secondary">Filter</button>
                </div>
                <div class="col-2">
                    <a id="button" type="button" href="{{ route('menu', ['id_admin_room_911' => $id_admin_room_911]) }}" class="btn btn-secondary">Clear filter</a>
                </div>
            </div>
        </form>
        <hr>
        <div class="row">
            <div class="col-7"></div>
            <div class="col-3">
                <a type="button" href="{{ route('admin') }}" class="btn btn-primary">New admin room 911</a>
            </div>
            <div class="col-2">
                <a type="button" href="{{ route('employee') }}" class="btn btn-primary">New employee</a>
            </div>
        </div>
        <br>
        <!-- CRUD -->
        <div class="row">
            <table class="table table-bordered">
                <thead class="thead secondary">
                    <tr style="background-color: rgb(165, 165, 165)">
                        <th>Employee ID</th>
                        <th style="width:13%">Firstname</th>
                        <th style="width:13%">Lastname</th>
                        <th>Department</th>
                        <th style="width:10%">Total access</th>
                        <th style="width:40%">Actions</th>
                    </tr>
                    @foreach ($employees_array as $employee)
                        @if ($employee[6] % 2 == 0)
                            <tr>
                                <td class="table-active">{{ $employee[1] }}</td>
                                <td class="table-active">{{ $employee[2] }}</td>
                                <td class="table-active">{{ $employee[3] }}</td>
                                <td class="table-active">{{ $employee[4] }}</td>
                                <td class="table-active">{{ $employee[5] }}</td>
                                <td style='white-space: nowrap' class="table-active">
                                <div class="d-flex">
                                    <a type="button" href="/update/{{ $employee[0] }}" class="btn btn-secondary btn-md mx-3">Update</a>
                                    <button type="button" class="btn btn-secondary btn-md mx-3">Disable</button>
                                    <button type="button" class="btn btn-warning btn-md mx-3">History</button>
                                    <button type="button" class="btn btn-danger btn-md mx-3">Delete</button>
                                </div>
                            </tr> 
                        @else
                            <tr>
                                <td>{{ $employee[1] }}</td>
                                <td>{{ $employee[2] }}</td>
                                <td>{{ $employee[3] }}</td>
                                <td>{{ $employee[4] }}</td>
                                <td>{{ $employee[5] }}</td>
                                <td style='white-space: nowrap'>
                                <div class="d-flex">
                                    <a type="button" href="/update/{{ $employee[0] }}" class="btn btn-secondary btn-md mx-3">Update</a>
                                    <button type="button" class="btn btn-secondary btn-md mx-3">Disable</button>
                                    <button type="button" class="btn btn-warning btn-md mx-3">History</button>
                                    <button type="button" class="btn btn-danger btn-md mx-3">Delete</button>
                                </div>
                            </tr>     
                        @endif     
                    @endforeach
                </thead>
            </table>
        </div>
    </div>
        @yield('content')
</body>
</html>