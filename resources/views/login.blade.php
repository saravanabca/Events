<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <style>
    .login-container {
        max-width: 500px;
        margin: auto;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    </style>
</head>

<body>
    <div class="container login-container mt-5">
        <h2>Admin Login</h2>
        <form id="login_form">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" class="form-control">
                <div class="error-message" id="email_error"></div>
            </div>
            <div class="form-group mt-5">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control">
                <div class="error-message" id="password_error"></div>
            </div>
            <button type="submit" class="btn btn-primary mt-5">Login</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/login.js') }}"></script>
    <script>
    var baseUrl = "{{ config('app.url') }}";
    </script>
</body>

</html>