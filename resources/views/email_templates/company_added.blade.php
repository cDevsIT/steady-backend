<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Company Added Successfully</title>
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
        .success-box {
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #155724;
            text-align: center;
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
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Company Added Successfully</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Steady Formation</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Dear {{$user->first_name}} {{$user->last_name}},</h2>
            
            <p>Great news! You have successfully added a new company to your Steady Formation account.</p>

            <!-- Success Box -->
            <div class="success-box">
                <strong>✓ Company Successfully Added</strong>
            </div>

            <p>You can now access and manage your new company through your dashboard. Click the button below to log in and get started:</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="https://steadyformation.com/login" class="button">Go to Dashboard</a>
            </div>

            <p>If you have any questions or need assistance with your new company setup, please don't hesitate to contact our support team.</p>

            <p>Best regards,<br>
            <strong>The Steady Formation Team</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Steady Formation. All rights reserved.</p>
            <p style="font-size: 12px; margin-top: 10px;">
                If you're having trouble clicking the button, copy and paste the URL below into your web browser:<br>
                <span style="color: #7856FC;">{https://steadyformation.com/login}</span>
            </p>
        </div>
    </div>
</body>
</html>
