<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Ticket Closed</title>
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
            color: white !important;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin-top: 20px;
        }
        .ticket-info {
            background-color: #f8f9fa;
            border: 2px solid #7856FC;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .ticket-info-item {
            margin: 10px 0;
        }
        .ticket-info-label {
            font-size: 14px;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .ticket-info-value {
            font-size: 16px;
            font-weight: bold;
            color: #7856FC;
        }
        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Support Ticket Closed</h1>
        </div>
        
        <div class="content">
            <h2>Dear {{$customerName}},</h2>
            
            <p>Your support ticket has been closed by our support team.</p>

            <div class="ticket-info">
                <div class="ticket-info-item">
                    <div class="ticket-info-label">Ticket ID:</div>
                    <div class="ticket-info-value">#{{$ticketId}}</div>
                </div>
                <div class="ticket-info-item">
                    <div class="ticket-info-label">Subject:</div>
                    <div class="ticket-info-value">{{$ticketTitle}}</div>
                </div>
                <div class="ticket-info-item">
                    <div class="ticket-info-label">Status:</div>
                    <div class="status-badge">Closed</div>
                </div>
            </div>

            @if($closingMessage)
            <div class="info-box">
                <p style="margin: 0;"><strong>Closing Message:</strong></p>
                <div style="margin-top: 10px;">{!! nl2br(strip_tags($closingMessage)) !!}</div>
            </div>
            @endif

            <p>If you need to reopen this ticket or have any additional questions, please feel free to contact us:</p>
            <ul style="margin: 10px 0; padding-left: 20px;">
                <li><strong>Email:</strong> info@steadyformation.com</li>
                <li><strong>Phone:</strong> +1 (307) 400-1051</li>
                <li><strong>Hours:</strong> Mon-Fri, 8am to 5pm</li>
            </ul>

            <p>You can view the ticket history by clicking the button below:</p>

            <div style="text-align: center;">
                <a href="{{$ticketUrl}}" class="button">View Ticket</a>
            </div>

            <p>Thank you for contacting Steady Formation support. We hope we were able to assist you effectively.</p>

            <p>Best regards,<br>
            <strong>The Steady Formation Support Team</strong></p>
        </div>

        <div class="footer">
            <p>This is an automated notification email. Please do not reply to this email directly.</p>
            <p>&copy; {{ date('Y') }} Steady Formation. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

