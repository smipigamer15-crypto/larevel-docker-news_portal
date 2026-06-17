<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Email | NEWS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f5f5f0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .verify-container {
            display: flex;
            max-width: 1200px;
            width: 100%;
            background: white;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.15);
            overflow: hidden;
        }
        .verify-info {
            flex: 1;
            background: #e30613;
            padding: 48px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .logo { font-size: 28px; font-weight: 700; }
        .logo span { font-weight: 400; opacity: 0.9; }
        .info-content { margin: 60px 0; }
        .info-content h2 { font-size: 32px; font-weight: 600; margin-bottom: 20px; }
        .info-content p { font-size: 16px; opacity: 0.9; line-height: 1.6; }
        .verify-footer { font-size: 12px; opacity: 0.7; }
        .verify-form {
            flex: 1;
            padding: 48px;
            background: white;
            text-align: center;
        }
        .verify-icon {
            width: 80px;
            height: 80px;
            background: #e8f5e9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
        }
        .verify-icon i { font-size: 40px; color: #e30613; }
        .verify-form h1 { font-size: 28px; font-weight: 600; color: #1a1a1a; margin-bottom: 12px; }
        .verify-form p { color: #666; font-size: 14px; margin-bottom: 24px; line-height: 1.6; }
        .btn-verify {
            padding: 12px 24px;
            background: #e30613;
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-verify:hover { background: #b8050f; }
        .resend-link {
            margin-top: 20px;
            font-size: 13px;
            color: #666;
        }
        .resend-link a { color: #e30613; text-decoration: none; }
        .resend-link a:hover { text-decoration: underline; }
        .logout-link {
            margin-top: 16px;
            display: inline-block;
            color: #e30613;
            text-decoration: none;
            font-size: 13px;
        }
        @media (max-width: 768px) {
            .verify-container { flex-direction: column; }
            .verify-info, .verify-form { padding: 32px; }
            .info-content { margin: 30px 0; }
            .info-content h2 { font-size: 24px; }
        }
    </style>
</head>
<body>
    <div class="verify-container">
        <div class="verify-info">
            <div class="logo">NEWS<span>portal</span></div>
            <div class="info-content">
                <h2>Verify email</h2>
                <p>Confirm your email address to get full access to all site features.</p>
            </div>
            <div class="verify-footer">© 2026 NEWS. All rights reserved.</div>
        </div>
        
        <div class="verify-form">
            <div class="verify-icon">
                <i class="fa-regular fa-envelope"></i>
            </div>
            
            <h1>Check your email</h1>
            <p>We have sent a confirmation link to your email address.<br>
            Please click the link in the email to verify your account.</p>
            
            @if (session('status') == 'verification-link-sent')
                <div style="background:#e8f5e9; color:#2e7d32; padding:12px; border-radius:12px; margin-bottom:20px;">
                    A new verification link has been sent!
                </div>
            @endif
            
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-verify">
                    <i class="fa-solid fa-paper-plane"></i> Resend email
                </button>
            </form>
            
            <div class="resend-link">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-link" style="background:none; border:none; cursor:pointer;">
                        <i class="fa-solid fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>