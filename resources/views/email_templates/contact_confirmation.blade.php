<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Contacting Us</title>
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
        .info-box {
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
        .button {
            display: inline-block;
            background-color: #7856FC;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Thank You for Contacting Us!</h1>
        </div>
        
        <div class="content">
            <h2>Dear {{$firstName}} {{$lastName}},</h2>
            
            <p>Thank you for reaching out to Steady Formation! We have successfully received your contact form submission.</p>

            <div class="info-box">
                <p style="margin: 0;"><strong>Your Inquiry:</strong> {{$subject}}</p>
            </div>

            <p>Our team has been notified and will review your message. We typically respond within 24-48 hours during business days.</p>

            <p>If your inquiry is urgent, please feel free to contact us directly:</p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><strong>Email:</strong> info@steadyformation.com</li>
                <li><strong>Phone:</strong> +1 (307) 400-1051</li>
                <li><strong>Hours:</strong> Mon-Fri, 8am to 5pm</li>
            </ul>

            <p>We appreciate your interest in Steady Formation and look forward to assisting you with your business formation needs.</p>

            <p>Best regards,<br>
            <strong>The Steady Formation Team</strong></p>
        </div>

        <div class="footer">
            <p>This is an automated confirmation email. Please do not reply to this email directly.</p>
            <p>&copy; {{ date('Y') }} Steady Formation. All rights reserved.</p>
            <p style="font-size: 12px; margin-top: 10px;">
                Visit us at: <span style="color: #7856FC;">https://steadyformation.com</span>
            </p>
        </div>
    </div>
</body>
</html>

