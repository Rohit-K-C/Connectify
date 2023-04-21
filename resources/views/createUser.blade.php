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
<div class="animate">
</div>
<div class="animate-inner"></div>
<div class="container">
    <form action="/createUser" method="POST">
        @csrf
        <input type="text" name="user_name" id="user_name" placeholder="Username" value="{{ old('user_name') }}">
        @error('user_name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="email" name="email" id="email" placeholder="Email" value="{{ old('email') }}">
        @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="password" name="password" id="password" placeholder="Password">
        @error('password')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="number" name="contact" id="contact" placeholder="Contact Number" value="{{ old('contact') }}">
        @error('contact')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <input type="submit" name="submit" value="Submit">
    </form>
</div>

</body>
</html>