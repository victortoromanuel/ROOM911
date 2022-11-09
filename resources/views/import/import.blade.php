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
    <div class="container w-25 border p-4 mt-5">
        @if(session("message"))
            <div class="alert alert-success" role="alert">
                {{session('message')}}
            </div>
        @endif
        <br>
        <p>Register employees by CSV file</p>
        <br>
        <form action="{{ route('employee-upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-2">    
                <!--<label for="file" class="form-label">Load employees by csv file</label>-->
                <input type="file" class="form-control" id="file" name="file" required>
                <br>
                <button type="submit" id="load" class="btn btn-primary">Load csv file</button>
            </div>
        </form>
    </div>
</body>
</html>