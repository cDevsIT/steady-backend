<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form Email</title>
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
            border: 2px solid #7856FC;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-item {
            margin: 15px 0;
            padding: 12px;
            background-color: #ffffff;
            border-radius: 6px;
        }
        .info-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 16px;
            font-weight: bold;
            color: #7856FC;
        }
        .message-box {
            background-color: #f8f9fa;
            border: 2px solid #7856FC;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .message-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 10px;
        }
        .message-content {
            font-size: 16px;
            line-height: 1.8;
            color: #333;
            white-space: pre-wrap;
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
            <h1>Contact Form Email</h1>
        </div>
        
        <div class="content">
            <p>You have received a new contact form submission from your website.</p>

            <div class="info-box">
                <div class="info-item">
                    <div class="info-label">Full Name:</div>
                    <div class="info-value">{{$firstName}} {{$lastName}}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Email Address:</div>
                    <div class="info-value">{{$email}}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Phone Number:</div>
                    <div class="info-value">{{$countryCode}} {{$phone}}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Subject:</div>
                    <div class="info-value">{{$subject}}</div>
                </div>
            </div>

            <div class="message-box">
                <div class="message-label">Message:</div>
                <div class="message-content">{{$contactMessage}}</div>
            </div>

            <div style="text-align: center;">
                <a href="mailto:{{$email}}" class="button">Reply to {{$firstName}}</a>
            </div>
        </div>

        <div class="footer">
            <p>This is an automated email from Steady Formation contact form.</p>
            <p>Please do not reply to this email directly.</p>
        </div>
    </div>
</body>
</html>
