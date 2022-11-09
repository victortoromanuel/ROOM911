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
    <link rel="stylesheet" href="{{ asset('css/access.css') }}">
</head>
<body>
    <br><br><br><br>
    <div class="container w-25 border p-5 mt-4">
        @if(session("message") && session("attempt_access"))
            <div class="alert alert-{{session('attempt_access')}}" role="alert">
                {{session('message')}}
            </div>
        @endif
        <p>Access simulator</p>
        <br><br>
        <form action="{{ route('access') }}" method="POST">
            @csrf
            <div class="form-group">
                <input type="number" class="form-control" id="employeeid" name="employeeid" placeholder="ID employee">
            </div>
            <br><br>
            <button id="access" type="submit" class="btn btn-primary">Access</button>
        </form>
    </div>
</body>
</html>