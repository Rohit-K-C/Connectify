<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    
    <div class="main-container">
        <div class="container">

            <form action="{{ route('login') }}" method="post">
                @csrf
                <span id="connectify">Connectify</span>
                <input type="email" name="email" placeholder="Email">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong class="error-message">{{ $message }}</strong>
                </span>
                @enderror
                <input type="password" name="password" placeholder="Password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong class="error-message">{{ $message }}</strong>
                </span>
                @enderror
                <input type="submit" name="SUBMIT" value="Submit">
                <p>Create your account -> <a id="signup" href="../createUser">Signup</a></p>
            </form>

        </div>
        <div class="login-banner">
            <img src="{{ asset('images/login-page-image.png') }}" alt="">
        </div>
    </div>

</body>

</html>