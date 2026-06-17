<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | NEWS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: #f5f5f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .register-container {
            display: flex;
            max-width: 1200px;
            width: 100%;
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .register-info {
            flex: 1;
            background: #e30613;
            padding: 48px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .logo {
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .logo span {
            font-weight: 400;
            opacity: 0.9;
        }

        .info-content {
            margin: 60px 0;
        }

        .info-content h2 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 20px;
            line-height: 1.2;
        }

        .info-content p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .info-features {
            list-style: none;
        }

        .info-features li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            font-size: 14px;
        }

        .info-features li i {
            width: 20px;
            font-size: 16px;
        }

        .register-footer {
            font-size: 12px;
            opacity: 0.7;
        }

        .register-form {
            flex: 1;
            padding: 48px;
            background: white;
        }

        .register-form h1 {
            font-size: 28px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .register-form .subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .form-group label i {
            margin-right: 8px;
            color: #e30613;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            font-size: 14px;
            border: 1.5px solid #e5e5e5;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .form-control:focus {
            outline: none;
            border-color: #e30613;
            box-shadow: 0 0 0 3px rgba(227, 6, 19, 0.1);
        }

        .btn-register {
            width: 100%;
            padding: 14px;
            background: #e30613;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 8px;
        }

        .btn-register:hover {
            background: #b8050f;
            transform: translateY(-1px);
        }

        .login-link {
            text-align: center;
            margin-top: 24px;
            font-size: 14px;
            color: #666;
        }

        .login-link a {
            color: #e30613;
            text-decoration: none;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .error-message {
            color: #e30613;
            font-size: 12px;
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }

        .alert-error {
            background: #ffebee;
            color: #e30613;
            border-left: 4px solid #e30613;
        }

        .row-2cols {
            display: flex;
            gap: 16px;
        }

        .row-2cols .form-group {
            flex: 1;
        }

        @media (max-width: 768px) {
            .register-container {
                flex-direction: column;
            }
            
            .register-info {
                padding: 32px;
            }
            
            .register-form {
                padding: 32px;
            }
            
            .info-content {
                margin: 30px 0;
            }
            
            .info-content h2 {
                font-size: 24px;
            }
            
            .row-2cols {
                flex-direction: column;
                gap: 0;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-info">
            <div class="logo">
                NEWS<span>portal</span>
            </div>
            
            <div class="info-content">
                <h2>Join us!</h2>
                <p>Create an account to read the latest news, comment on articles and receive personalized recommendations.</p>
                
                <ul class="info-features">
                    <li><i class="fa-regular fa-newspaper"></i> Exclusive news first</li>
                    <li><i class="fa-regular fa-comment"></i> Comment and discuss</li>
                    <li><i class="fa-regular fa-bookmark"></i> Save favorite articles</li>
                    <li><i class="fa-regular fa-bell"></i> Receive notifications</li>
                </ul>
            </div>
            
            <div class="register-footer">
                © 2026 NEWS. All rights reserved.
            </div>
        </div>
        
        <div class="register-form">
            <h1>Register</h1>
            <p class="subtitle">Create a new account</p>
            
            @if ($errors->any())
                <div class="alert alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    Please fix the errors below
                </div>
            @endif
            
            <form method="POST" action="{{ route('register') }}">
                @csrf
                
                <div class="row-2cols">
                    <div class="form-group">
                        <label for="name"><i class="fa-regular fa-user"></i> Name</label>
                        <input type="text" id="name" name="name" class="form-control" 
                               value="{{ old('name') }}" required autofocus placeholder="Your name">
                        @error('name')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="email"><i class="fa-regular fa-envelope"></i> Email</label>
                        <input type="email" id="email" name="email" class="form-control" 
                               value="{{ old('email') }}" required placeholder="your@email.com">
                        @error('email')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="row-2cols">
                    <div class="form-group">
                        <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
                        <input type="password" id="password" name="password" class="form-control" 
                               required placeholder="••••••••">
                        @error('password')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="password_confirmation"><i class="fa-solid fa-lock"></i> Confirm password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" 
                               required placeholder="••••••••">
                    </div>
                </div>
                
                <button type="submit" class="btn-register">
                    <i class="fa-solid fa-user-plus"></i> Register
                </button>
                
                <div class="login-link">
                    Already have an account? <a href="{{ route('login') }}">Login</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>