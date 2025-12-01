<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Created Successfully</title>
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
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Ticket Created Successfully</h1>
        </div>
        
        <div class="content">
            <p>You have successfully created a new support ticket.</p>

            <div class="info-box">
                <div class="info-item">
                    <div class="info-label">Ticket ID:</div>
                    <div class="info-value">#{{$ticketId}}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Customer:</div>
                    <div class="info-value">{{$customerName}}</div>
                </div>

                @if($companyName)
                <div class="info-item">
                    <div class="info-label">Company:</div>
                    <div class="info-value">{{$companyName}}</div>
                </div>
                @endif

                <div class="info-item">
                    <div class="info-label">Subject:</div>
                    <div class="info-value">{{$ticketTitle}}</div>
                </div>

                <div class="info-item">
                    <div class="info-label">Status:</div>
                    <div class="info-value">{{$ticketStatus}}</div>
                </div>
            </div>

            <p>The customer has been notified via email about this ticket.</p>

            <div style="text-align: center;">
                <a href="{{$ticketUrl}}" class="button">View Ticket</a>
            </div>
        </div>

        <div class="footer">
            <p>This is an automated confirmation email from Steady Formation ticket system.</p>
        </div>
    </div>
</body>
</html>

