<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - HNFRTOOLS</title>

    <!-- Bootstrap & FontAwesome -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #FEFAE0;
            font-family: 'Arial', sans-serif;
        }
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .login-wrapper {
            width: 100%;
            max-width: 1200px;
            background: #fff;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: row;
        }
        .login-form {
            flex: 1;
            padding: 4rem 5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-form h2 {
            font-weight: 800;
            color: #1A3636;
            font-size: 2rem;
        }
        .login-form p {
            color: #6c757d;
            margin-bottom: 1.5rem;
        }
        .form-group label {
            font-weight: 600;
            margin-top: 1rem;
        }
        .form-control {
            padding: 0.75rem 1rem;
            font-size: 1.1rem;
        }
        .login-button {
            margin-top: 2rem;
            background-color: #1A3636;
            color: #fff;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 1.2rem;
            transition: background 0.3s;
        }
        .login-button:hover {
            background-color: #142929;
        }
        .login-image {
            flex: 1;
            background-color: #1A3636;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .toggle-password {
            position: absolute;
            top: 50%;
            right: 1.2rem;
            transform: translateY(-50%);
            color: #888;
            cursor: pointer;
        }
        .brand-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .brand-header img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 50%;
        }
        .brand-header .brand-title {
            font-weight: 700;
            font-size: 1.4rem;
            color: #1A3636;
            margin-top: 0.5rem;
        }
        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }
            .login-image {
                height: 200px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="login-wrapper">
        <div class="login-form">
            <div class="brand-header">
                <img src="{{ asset('images/logo.png') }}" alt="Logo">
                <div class="brand-title">HNFRTOOLS</div>
            </div>

            <h2>Welcome Back</h2>
            <p>Masukkan email dan password untuk login</p>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('admin.login') }}" method="POST">

                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           placeholder="example@email.com" value="{{ old('email') }}" required>
                    @error('email')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group position-relative">
                    <label for="password">Password</label>
                    <div style="position: relative;">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" placeholder="********" required>
                        <i class="fas fa-eye-slash toggle-password" onclick="togglePassword()"></i>
                    </div>
                    @error('password')
                        <span class="text-danger small">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn login-button">Login</button>
            </form>
        </div>

        <div class="login-image d-none d-md-flex">
            <img src="{{ asset('images/loggginn.jpg') }}" alt="Login Image">
        </div>
    </div>
</div>

<script>
    function togglePassword() {
        const passwordInput = document.getElementById("password");
        const icon = document.querySelector(".toggle-password");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        }
    }
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
