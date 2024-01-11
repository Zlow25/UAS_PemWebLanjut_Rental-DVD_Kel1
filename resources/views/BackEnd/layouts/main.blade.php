<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Rental Buku | @yield('title')</title>
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('/assets/css/style.css') }}">
</head>

<body>
    <div class="main d-flex flex-column justify-content-between">
        <div class="body-content h-100">
            <div class="row g-0 h-100">
                <div class="sidebar col-lg-2 collapse d-lg-block" id="navbarTogglerDemo02">
                    @if (Auth::user())
                        @if (Auth::user()->role_id == 1)
                            <a href="/dashboard" @if (Request()->route()->uri() == 'dashboard') class="active" @endif>Dashboard</a>
                            <a href="/dvds" @if (Request()->route()->uri() == 'dvds' ||
                                    Request()->route()->uri() == 'dvd-add' ||
                                    Request()->route()->uri() == 'dvd-edit/{slug}' ||
                                    Request()->route()->uri() == 'dvd-delete') class="active" @endif>DVDs</a>
                            <a href="/categories" @if (Request()->route()->uri() == 'categories' ||
                                    Request()->route()->uri() == 'category-add' ||
                                    Request()->route()->uri() == 'category-edit/{slug}' ||
                                    Request()->route()->uri() == 'category-deleted') class="active" @endif>Categories</a>
                            <a href="/users" @if (Request()->route()->uri() == 'users' ||
                                    Request()->route()->uri() == 'user-detail/{slug}' ||
                                    Request()->route()->uri() == 'users-deleted' ||
                                    Request()->route()->uri() == 'registed-users') class="active" @endif>Users</a>
                            <a href="/rent-log" @if (Request()->route()->uri() == 'rent-log') class="active" @endif>Rent Log</a>
                            <a href="/" @if (Request()->route()->uri() == '/') class="active" @endif>DVD List</a>
                            <a href="/dvd-rent" @if (Request()->route()->uri() == 'dvd-rent') class="active" @endif>DVD Rent</a>
                            <a href="/dvd-return" @if (Request()->route()->uri() == 'dvd-return') class="active" @endif>DVD
                                Return</a>
                            <a href="/logout">Logout</a>
                        @else
                            <a href="/profile" @if (Request()->route()->uri() == 'profile') class="active" @endif>Profile</a>
                            <a href="/" @if (Request()->route()->uri() == '/') class="active" @endif>DVD List</a>
                            <a href="/logout">Logout</a>
                        @endif
                    @else
                        <a href="/login">Login</a>
                    @endif
                </div>
                <div class="content p-5 col-lg-10">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
</body>

</html>
