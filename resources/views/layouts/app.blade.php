<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EXP GAME STORE')</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Base Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Page-specific styles -->
    @stack('styles')

    <style>
        :root {
            --primary-red: #8B0000;
            --dark-red: #5C0000;
            --darker-red: #3D0000;
            --light-red: #A52A2A;
        }

        /* Additional styles for pages that don't use storefront.css */
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }

        .alert-success {
            background: rgba(0, 255, 0, 0.2);
            border: 1px solid rgba(0, 255, 0, 0.5);
        }

        .alert-error {
            background: rgba(255, 0, 0, 0.2);
            border: 1px solid rgba(255, 0, 0, 0.5);
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            font-family: 'Orbitron', sans-serif;
            font-size: 16px;
        }

        .btn-primary {
            background: #DB0000;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: #8E0007;
            color: white;
        }

        .btn-danger {
            background: #DB0000;
            color: white;
        }

        .btn-danger:hover {
            background: #8E0007;
        }

        .btn-grey {
            background: #666;
            color: white;
        }

        .btn-grey:hover {
            background: #777;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 80px;
        }

        .section-title {
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            font-size: 48px;
            color: white;
            margin-bottom: 30px;
        }

        /* header icons */
        .header-icons {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .cart-icon {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            color: white;
        }

        .cart-icon svg {
            width: 24px;
            height: 24px;
            fill: white;
        }

        .cart-count {
            position: absolute;
            top: -6px;
            right: -6px;
            background: #ff6b6b;
            color: white;
            border-radius: 50%;
            padding: 3px 6px;
            font-size: 12px;
            font-weight: 700;
        }

        .search-bar {
            display: flex;
            align-items: center;
        }

        .search-bar input {
            padding: 6px 10px;
            border-radius: 6px 0 0 6px;
            border: 1px solid #333;
        }

        .search-btn {
            width: 34px;
            height: 34px;
            border-radius: 0 6px 6px 0;
            border: 1px solid #333;
            background: #222;
        }
    </style>
</head>

<body>
    <header class="header">
        <a href="{{ route('home') }}" class="logo" style="text-decoration: none;">
            <span class="logo-letter">E</span><span class="logo-x">X</span><span class="logo-letter">P</span>
            <span class="store-text"> GAME STORE</span>
        </a>
        <div class="header-icons">
            <a href="{{ route('cart.index') }}" class="cart-icon" style="text-decoration: none;">
                <!-- simple cart icon (SVG) -->
                <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <path
                        d="M7 4h-2l-1 2h2l3.6 7.59-1.35 2.45c-.16.29-.25.62-.25.96 0 1.11.89 2 2 2h9v-2h-9l1.1-2h6.45c.75 0 1.41-.41 1.75-1.03l3.58-6.49-1.74-1-3.58 6.49h-7.11l-.94-2h8.05v-2h-9.72l-.66-1.33L7 4z">
                    </path>
                </svg>
                @if(session('cart') && count(session('cart')) > 0)
                    <span class="cart-count">{{ count(session('cart')) }}</span>
                @endif
            </a>
            <form action="{{ route('games.search') }}" method="GET" class="search-bar">
                <input type="text" name="q" placeholder="Search..." value="{{ request('q') }}">
                <button type="submit" class="search-btn"></button>
            </form>
            @if(session('customer_id'))
                <a href="{{ route('orders.index') }}" class="btn btn-primary" style="text-decoration: none;">My Orders</a>
                <a href="{{ route('customers.logout') }}" class="btn btn-danger" style="text-decoration: none;">Logout</a>
            @else
                <a href="{{ route('customers.login') }}" class="btn btn-primary" style="text-decoration: none;">Login</a>
            @endif
        </div>
    </header>

    <main>
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-error">
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if(isset($errors) && $errors->any())
            <div class="container">
                <div class="alert alert-error">
                    <ul style="margin: 0; padding-left: 1.5rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>
</body>

</html>