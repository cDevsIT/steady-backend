<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Deducted | Steady Formation</title>
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
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
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
        .transaction-box {
            background-color: #f8f9fa;
            border: 2px solid #dc3545;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .transaction-item {
            margin: 15px 0;
            padding: 12px;
            background-color: #ffffff;
            border-radius: 6px;
        }
        .transaction-icon {
            font-size: 24px;
            margin-right: 15px;
        }
        .transaction-label {
            font-size: 14px;
            color: #6c757d;
            flex: 1;
        }
        .transaction-value {
            font-size: 18px;
            font-weight: bold;
            color: #dc3545;
            word-break: break-all;
        }
        .balance-highlight {
            background: linear-gradient(135deg, #7856FC 0%, #9F7AEA 100%);
            color: white;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            margin: 20px 0;
        }
        .balance-highlight h3 {
            margin: 0 0 5px 0;
            font-size: 32px;
        }
        .balance-highlight p {
            margin: 0;
            opacity: 0.9;
        }
        .note-box {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
            color: #721c24;
        }
        .button-container {
            text-align: center;
            margin: 30px 0;
        }
        .button {
            display: inline-block;
            background-color: #7856FC;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            margin: 5px;
        }
        .button-secondary {
            background-color: #6c757d;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #e9ecef;
        }
        .social-links {
            margin: 15px 0;
        }
        .social-links a {
            color: #7856FC;
            text-decoration: none;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <h1>Account Debited</h1>
            <p style="margin: 10px 0 0 0; opacity: 0.9;">Transaction Notification</p>
        </div>

        <!-- Content -->
        <div class="content">
            <h2>Hi {{ $user->first_name }},</h2>
            
            <p>We're notifying you that your account has been debited with the following transaction:</p>

            <!-- Transaction Details -->
            <div class="transaction-box">
                <div class="transaction-item">
                    <span class="transaction-icon">💳</span>
                    <span class="transaction-label">Amount Deducted:</span>
                    <span class="transaction-value">${{ number_format($amount, 2) }} USD</span>
                </div>
                <div class="transaction-item">
                    <span class="transaction-icon">🧾</span>
                    <span class="transaction-label">Transaction ID:</span>
                    <span class="transaction-value">#{{ $transactionId }}</span>
                </div>
            </div>

            <!-- Current Balance Highlight -->
            <div class="balance-highlight">
                <h3>${{ number_format($currentBalance, 2) }}</h3>
                <p>Current Balance (USD)</p>
            </div>

            <!-- Admin Note (if available) -->
            @if(isset($note) && $note)
            <div class="note-box">
                <strong>📝 Admin Note:</strong><br>
                {{ $note }}
            </div>
            @endif

            <p>You can log in to your dashboard anytime to review this transaction. If you have any questions or concerns about this deduction, please contact our support team.</p>

            <!-- Quick Links -->
            <div class="button-container">
                <p style="margin-bottom: 15px; font-weight: 600; color: #333;">Quick Links:</p>
                <a style="color: white;" href="https://steadyformation.com/client" class="button">Dashboard Login</a>
                <a style="color: white;" href="https://steadyformation.com/client/support-help" class="button button-secondary">Open a Support Ticket</a>
            </div>

            <p>Thank you for being a valued customer of Steady Formation.</p>
            <p>We look forward to serving you again soon.</p>

            <p style="margin-top: 30px;">
                Warm regards,<br>
                <strong>The Steady Formation Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Steady Formation</strong></p>
            <p>Your trusted partner in business formation and growth.</p>
            <div class="social-links">
                <a target="_blank" href="https://www.facebook.com/steadyformation/">Facebook</a> | 
                <a href="#">Twitter</a> | 
                <a href="#">LinkedIn</a>
            </div>
            <p style="margin-top: 15px; font-size: 12px;">
                This is an automated email. Please do not reply directly to this message.
            </p>
        </div>
    </div>
</body>
</html>
