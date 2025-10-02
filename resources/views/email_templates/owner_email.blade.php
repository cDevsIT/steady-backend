<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message from Steady Formation</title>
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
        .message-body {
            background-color: #f8f9fa;
            border-left: 4px solid #7856FC;
            border-radius: 6px;
            padding: 20px;
            margin: 20px 0;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #e9ecef;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Message from Steady Formation</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Steady Formation</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Message Body -->
            <div class="message-body">
                {!! $history->body !!}
            </div>

            <p>If you have any questions or need further assistance, please don't hesitate to contact our support team.</p>

            <p>Best regards,<br>
            <strong>The Steady Formation Team</strong></p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>&copy; {{ date('Y') }} Steady Formation. All rights reserved.</p>
            <p style="font-size: 12px; margin-top: 10px;">
                If you need help, visit our website at:<br>
                <span style="color: #7856FC;">https://steadyformation.com</span>
            </p>
        </div>
    </div>
</body>
</html>
