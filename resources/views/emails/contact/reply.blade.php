<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reply to Your Message</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #374151;
            margin: 0;
            padding: 0;
            background-color: #f9fafb;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
            padding: 30px;
        }
        .original-message {
            background: #f3f4f6;
            border-left: 4px #6b7280;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 6px;
        }
        .reply-message {
            background: #eff6ff;
            border-left: 4px solid #3b82f6;
            padding: 20px;
            margin: 25px 0;
            border-radius: 6px;
        }
        .message-header {
            font-size: 14px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        .message-content {
            font-size: 15px;
            color: #1f2937;
            line-height: 1.6;
        }
        .info-box {
            background: #f9fafb;
            padding: 15px;
            border-radius: 6px;
            margin-top: 20px;
            font-size: 14px;
            color: #6b7280;
            border: 1px solid #e5e7eb;
        }
        .footer {
            text-align: center;
            padding: 25px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .divider {
            height: 1px;
            background: #e5e7eb;
            margin: 25px 0;
        }
        .reference {
            font-size: 12px;
            color: #9ca3af;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Reply to Your Message</h1>
            <p>{{ config('app.name') }} Support Team</p>
        </div>
        
        <div class="content">
            <p>Hello <strong>{{ $contactMessage->name }}</strong>,</p>
            
            <p>Thank you for contacting us. Here is our response to your inquiry:</p>
            
            <div class="divider"></div>
            
            <!-- Original Message -->
            <div class="original-message">
                <div class="message-header">
                    <strong>Your Original Message:</strong><br>
                    <small>Sent on {{ $contactMessage->created_at->format('F j, Y \a\t h:i A') }}</small>
                </div>
                <div class="message-content">
                    {{ $contactMessage->message }}
                </div>
            </div>
            
            <!-- Admin Reply -->
            <div class="reply-message">
                <div class="message-header">
                    <strong>Our Response:</strong><br>
                    <small>Replied on {{ now()->format('F j, Y \a\t h:i A') }}</small>
                </div>
                <div class="message-content">
                    {!! nl2br(e($adminReply)) !!}
                </div>
            </div>
            
            <div class="info-box">
                <p><strong>Reference ID:</strong> #{{ str_pad($contactMessage->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Subject:</strong> {{ $contactMessage->subject }}</p>
                <p><strong>Your Email:</strong> {{ $contactMessage->email }}</p>
            </div>
            
            <div class="divider"></div>
            
            <p>If you have any further questions, please don't hesitate to contact us again.</p>
            
            <p>Best regards,<br>
            <strong>{{ config('app.name') }} Support Team</strong></p>
        </div>
        
        <div class="footer">
            <p>This is an official response from {{ config('app.name') }}</p>
            <p>{{ config('mail.from.address') }} | {{ \App\Models\SiteSetting::getValue('contact_phone', '') }}</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>