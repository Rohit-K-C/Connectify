<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>

    <div class="main-container">
        <div class="container">
            <form action="/createUser" method="POST">
                @csrf
                <span id="connectify">Connectify</span>
                <input type="text" name="user_name" id="user_name" placeholder="Username"
                    value="{{ old('user_name') }}">
                @error('user_name')
                <span class="invalid-feedback" role="alert">
                    <strong class="error-message">{{ $message }}</strong>
                </span>
                @enderror
                <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong class="error-message">{{ $message }}</strong>
                </span>
                @enderror
                <input type="password" name="password" id="password" placeholder="Password">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong class="error-message">{{ $message }}</strong>
                </span>
                @enderror
                <input type="number" name="contact" id="contact" placeholder="Contact Number"
                    value="{{ old('contact') }}">
                @error('contact')
                <span class="invalid-feedback" role="alert">
                    <strong class="error-message">{{ $message }}</strong>
                </span>
                @enderror
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
        <div class="login-banner">
            <img src="{{ asset('images/login-page-image.png') }}" alt="">
        </div>
    </div>
</body>

</html>