<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @include('layouts.meta')

    @include('layouts.top_style')

    @yield('custom_style')
</head>

<body>
    <div class="container-toast">

        <div class="alert_toast" id="alert_toast">
            <i class="fas fa-exclamation-circle"></i>
            <p class="toast-text"></p>
            <i class="fas fa-close" id="close"></i>
        </div>

    </div>
    @yield('content')

    @include('layouts.top_scripts')

    @yield('custom_scripts')

</body>

</html>