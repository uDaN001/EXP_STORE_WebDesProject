<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EXP GAME STORE')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    
    <!-- Styles are included inline below -->
    
    <style>
        :root {
            --primary-red: #8B0000;
            --dark-red: #5C0000;
            --darker-red: #3D0000;
            --light-red: #A52A2A;
        }
        
        body {
            font-family: 'Instrument Sans', sans-serif;
            background: linear-gradient(to bottom, var(--primary-red), var(--darker-red));
            min-height: 100vh;
            color: white;
            margin: 0;
            padding: 0;
        }
        
        .header {
            background-color: #000;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }
        
        .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            letter-spacing: 2px;
        }
        
        .logo .exp {
            font-size: 2.2rem;
        }
        
        .header-right {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        
        .cart-icon {
            color: white;
            font-size: 1.5rem;
            text-decoration: none;
            position: relative;
        }
        
        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--primary-red);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: bold;
        }
        
        .search-bar {
            display: flex;
            align-items: center;
            background: #333;
            border-radius: 25px;
            padding: 0.5rem 1rem;
            width: 300px;
        }
        
        .search-bar input {
            background: transparent;
            border: none;
            color: white;
            outline: none;
            flex: 1;
            padding: 0.25rem;
        }
        
        .search-bar input::placeholder {
            color: #999;
        }
        
        .search-icon {
            color: #999;
            cursor: pointer;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            margin: 2rem 0 1rem 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .games-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }
        
        .game-card {
            background: var(--light-red);
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
        }
        
        .game-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.5);
        }
        
        .game-card img {
            width: 100%;
            height: 250px;
            object-fit: cover;
        }
        
        .game-card-info {
            padding: 1rem;
        }
        
        .game-card-title {
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }
        
        .game-card-price {
            font-size: 1.2rem;
            font-weight: 700;
            color: white;
        }
        
        .category-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            margin: 1rem 0;
        }
        
        .category-btn {
            background: var(--light-red);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }
        
        .category-btn:hover {
            background: var(--primary-red);
        }
        
        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            border: none;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: white;
            color: var(--primary-red);
            border: 2px solid var(--primary-red);
        }
        
        .btn-primary:hover {
            background: var(--primary-red);
            color: white;
        }
        
        .btn-danger {
            background: var(--primary-red);
            color: white;
        }
        
        .btn-danger:hover {
            background: var(--dark-red);
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 0.75rem;
            border-radius: 8px;
            border: 2px solid #333;
            background: #333;
            color: white;
            font-size: 1rem;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--primary-red);
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
            background: rgba(0,0,0,0.3);
            border-radius: 10px;
            overflow: hidden;
        }
        
        .table th,
        .table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .table th {
            background: var(--dark-red);
            font-weight: 600;
        }
        
        .table tr:hover {
            background: rgba(255,255,255,0.05);
        }
        
        .alert {
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
        }
        
        .alert-success {
            background: rgba(0,255,0,0.2);
            border: 1px solid rgba(0,255,0,0.5);
        }
        
        .alert-error {
            background: rgba(255,0,0,0.2);
            border: 1px solid rgba(255,0,0,0.5);
        }
    </style>
</head>
<body>
    <header class="header">
        <a href="{{ route('home') }}" class="logo">
            <span class="exp">EXP</span> GAME STORE
        </a>
        <div class="header-right">
            <a href="{{ route('cart.index') }}" class="cart-icon">
                🛒
                @if(session('cart') && count(session('cart')) > 0)
                    <span class="cart-count">{{ count(session('cart')) }}</span>
                @endif
            </a>
            <form action="{{ route('games.search') }}" method="GET" class="search-bar">
                <input type="text" name="q" placeholder="Search games..." value="{{ request('q') }}">
                <span class="search-icon">🔍</span>
            </form>
            @if(session('customer_id'))
                <a href="{{ route('orders.index') }}" class="btn btn-primary" style="text-decoration: none;">My Orders</a>
                <a href="{{ route('customers.logout') }}" class="btn btn-danger" style="text-decoration: none;">Logout</a>
            @else
                <a href="{{ route('customers.login') }}" class="btn btn-primary" style="text-decoration: none;">Login</a>
            @endif
            @if(!auth()->check())
                <a href="{{ route('admin.login') }}" class="btn" style="background: #666; text-decoration: none;">Admin</a>
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

