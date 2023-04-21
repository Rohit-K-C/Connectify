<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <div class="animate">
    </div>
    <div class="animate-inner"></div>
    <div class="container">

        <form action="{{ route('login') }}" method="post">
            @csrf
            <span>Connectify</span>
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <input type="submit" name="submit" value="Submit">
            <a href="../createUser">New User? Signup</a>
        </form>

    </div>

</body>

</html>