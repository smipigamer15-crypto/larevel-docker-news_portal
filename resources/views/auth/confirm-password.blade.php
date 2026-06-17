<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password | NEWS</title>
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

        .confirm-container {
            display: flex;
            max-width: 1200px;
            width: 100%;
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .confirm-info {
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
        }

        .info-content p {
            font-size: 16px;
            opacity: 0.9;
            line-height: 1.6;
        }

        .confirm-footer {
            font-size: 12px;
            opacity: 0.7;
        }

        .confirm-form {
            flex: 1;
            padding: 48px;
            background: white;
        }

        .confirm-form h1 {
            font-size: 28px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .confirm-form .subtitle {
            color: #666;
            font-size: 14px;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 24px;
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
        }

        .form-control:focus {
            outline: none;
            border-color: #e30613;
            box-shadow: 0 0 0 3px rgba(227, 6, 19, 0.1);
        }

        .btn-confirm {
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
        }

        .btn-confirm:hover {
            background: #b8050f;
            transform: translateY(-1px);
        }

        .error-message {
            color: #e30613;
            font-size: 12px;
            margin-top: 6px;
        }

        @media (max-width: 768px) {
            .confirm-container {
                flex-direction: column;
            }
            .confirm-info, .confirm-form {
                padding: 32px;
            }
            .info-content {
                margin: 30px 0;
            }
            .info-content h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="confirm-container">
        <div class="confirm-info">
            <div class="logo">NEWS<span>portal</span></div>
            <div class="info-content">
                <h2>Confirmation</h2>
                <p>For your security, please confirm your password before proceeding.</p>
            </div>
            <div class="confirm-footer">© 2026 NEWS. All rights reserved.</div>
        </div>
        
        <div class="confirm-form">
            <h1>Confirm password</h1>
            <p class="subtitle">Enter your password to continue</p>
            
            @if ($errors->any())
                <div class="alert alert-error" style="background:#ffebee; color:#e30613; padding:12px; border-radius:12px; margin-bottom:20px;">
                    {{ $errors->first() }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                
                <div class="form-group">
                    <label for="password"><i class="fa-solid fa-lock"></i> Password</label>
                    <input type="password" id="password" name="password" class="form-control" required autofocus placeholder="••••••••">
                </div>
                
                <button type="submit" class="btn-confirm">
                    <i class="fa-solid fa-check"></i> Confirm
                </button>
            </form>
        </div>
    </div>
</body>
</html>