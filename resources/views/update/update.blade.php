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
    <link rel="stylesheet" href="{{ asset('css/employee.css') }}">
</head>
<body>
    <div class="container w-25 border p-4 mt-6">
        @if(session("message"))
            <div class="alert alert-success" role="alert">
                {{session('message')}}
            </div>
        @endif
        <br>
        <p>Update employee</p>
        <br>
        <form action="{{ route('update-update', ['id_admin_room_911' => $id_admin_room_911, 'id_employee' => $employee->id_employee]) }}" method="POST">
            @method('PATCH')
            @csrf
            <div class="mb-3">
                <label for="employeeid" class="form-label">ID employee</label>
                <input type="number" class="form-control" id="employeeid" name="employeeid" value="{{ $employee->id_number }}">
            </div>
            <div class="mb-3">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="{{ $employee->firstname }}">
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="{{ $employee->lastname }}">
            </div>
            <div class="mb-3">
                <label for="department" class="form-label">Department</label>
                <select id="department" name="department" class="form-select" aria-label="Default select example">
                    @foreach ($departments as $department)
                        <option value="{{ $department->id_department }}"
                        @if ($department->id_department == old('department', $id_department->id_department))
                            selected
                        @endif
                        >{{ $department->department_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="access" class="form-label">Access</label>
                <select id="access" name="access" class="form-select" aria-label="Default select example">
                        
                        @if ($employee->access == old('access', 0))
                            <option value="0" selected>Denied</option>
                            <option value="1">Accepted</option>
                        @else
                            <option value="0">Denied</option>
                            <option value="1" selected>Accepted</option>
                        @endif
                        
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <br>
        <a class='btn btn-info' href="/menu/{{ $id_admin_room_911 }}">Back</a>
    </div>
</body>
</html>