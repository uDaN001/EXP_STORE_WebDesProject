<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EXP Game Store - Login</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    <!-- HEADER -->
    <header class="header">
        <a href="{{ route('home') }}" class="logo" style="text-decoration: none;">
            <span class="logo-letter">E</span><span class="logo-x">X</span><span class="logo-letter">P</span>
            <span class="store-text"> GAME STORE</span>
        </a>
    </header>

    <div class="auth-container">
        <!-- LEFT: LOGIN -->
        <div class="login-section">
            <h2 class="section-title">LOGIN</h2>

            @if(session('error'))
                <div style="color: #ff6b6b; margin-bottom: 20px; font-size: 18px; font-family: 'Orbitron', sans-serif;">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('customers.authenticate') }}" method="POST" style="width: 100%;">
                @csrf

                <label>Username</label>
                <input type="text" name="username" class="input-box" value="{{ old('username') }}" required>

                <label>Password</label>
                <input type="password" name="password" class="input-box" required>

                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>

        <!-- RIGHT: SIGNUP -->
        <div class="signup-section">
            <h2 class="section-title">JOIN THE <span class="logo-letter">E</span><span class="logo-x">X</span><span class="logo-letter">P</span> FAMILY</h2>
            <p class="subtitle">Leading games retailer in the Philippines!</p>

            @if(isset($errors) && $errors->any())
                <div style="color: #ff6b6b; margin-bottom: 20px; font-size: 16px; font-family: 'Orbitron', sans-serif;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customers.store') }}" method="POST"
                style="width: 100%; display: flex; flex-direction: column; flex: 1;">
                @csrf
                <input type="hidden" name="from_signup" value="1">

                <label>Full Name</label>
                <input type="text" name="full_name" class="input-box" value="{{ old('full_name') }}" required>

                <label>Username</label>
                <input type="text" name="username" class="input-box" value="{{ old('username') }}" required>

                <label>Email</label>
                <input type="email" name="email" class="input-box" value="{{ old('email') }}" required>

                <label>Password</label>
                <input type="password" name="password" class="input-box" required>

                <button type="submit" class="signup-btn">Sign Up</button>
            </form>
        </div>
    </div>
</body>

</html>