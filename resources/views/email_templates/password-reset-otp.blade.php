<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - Verification Code</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #7856FC 0%, #9F7AEA 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 30px 20px;
        }
        .otp-container {
            background-color: #f8f9fa;
            border: 2px dashed #7856FC;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
        }
        .otp-code {
            font-size: 32px;
            font-weight: bold;
            color: #7856FC;
            letter-spacing: 8px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
        }
        .otp-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
        }
        .expiry-notice {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #856404;
        }
        .security-tips {
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #0c5460;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #e9ecef;
        }
        .button {
            display: inline-block;
            background-color: #7856FC;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 10px 0;
        }
        .warning {
            color: #dc3545;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Password Reset</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Steady Formation</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Hello {{ $userName }},</h2>
            
            <p>We received a request to reset your password for your Steady Formation account. To complete the password reset process, please use the verification code below:</p>

            <!-- OTP Code -->
            <div class="otp-container">
                <div class="otp-label">Your verification code is:</div>
                <div class="otp-code">{{ $otp }}</div>
                <div class="otp-label">Enter this code in the verification page</div>
            </div>

            <!-- Expiry Notice -->
            <div class="expiry-notice">
                <strong>⚠️ Important:</strong> This code will expire in {{ $expiresIn }} minutes. If you don't use it within this time, you'll need to request a new code.
            </div>

            <!-- Security Tips -->
            <div class="security-tips">
                <strong>🔒 Security Tips:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Never share this code with anyone</li>
                    <li>Steady Formation will never ask for your verification code</li>
                    <li>If you didn't request this password reset, please ignore this email</li>
                    <li>Your account remains secure</li>
                </ul>
            </div>

            <p>If you're having trouble with the verification code or didn't request a password reset, please contact our support team.</p>

            <p>Best regards,<br>
            <strong>The Steady Formation Team</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Steady Formation. All rights reserved.</p>
            <p style="font-size: 12px; margin-top: 10px;">
                If you're having trouble clicking the button, copy and paste the URL below into your web browser:<br>
                <span style="color: #7856FC;">https://steadyformation.com</span>
            </p>
        </div>
    </div>
</body>
</html>
