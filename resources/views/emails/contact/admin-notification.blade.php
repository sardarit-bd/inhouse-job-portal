<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #374151;
            margin: 0;
            padding: 20px;
            background-color: #f9fafb;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
        .message-box {
            background: #f3f4f6;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }
        .info-item {
            background: #f9fafb;
            padding: 12px 15px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }
        .label {
            font-size: 12px;
            color: #6b7280;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 5px;
        }
        .value {
            font-size: 14px;
            color: #111827;
            font-weight: 500;
        }
        .message-content {
            background: #f9fafb;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            padding: 20px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 500;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Contact Message</h1>
            <p>You have received a new message from website contact form</p>
        </div>
        
        <div class="content">
            <div class="info-grid">
                <div class="info-item">
                    <div class="label">From</div>
                    <div class="value">{{ $message->name }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Email</div>
                    <div class="value">{{ $message->email }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Subject</div>
                    <div class="value">{{ $message->subject }}</div>
                </div>
                <div class="info-item">
                    <div class="label">Date & Time</div>
                    <div class="value">{{ $message->created_at->format('M d, Y \a\t h:i A') }}</div>
                </div>
            </div>
            
            <div class="message-content">
                <div class="label">Message</div>
                <p>{{ $message->message }}</p>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ url('/admin/contact-messages/' . $message->id) }}" class="btn">
                    View in Dashboard
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p>This message was sent from {{ config('app.name') }} contact form</p>
            <p>IP: {{ $message->ip_address }}</p>
        </div>
    </div>
</body>
</html>