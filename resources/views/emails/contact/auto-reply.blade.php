<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Contacting Us</title>
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 40px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
        }
        .content {
            padding: 40px 30px;
        }
        .message-box {
            background: #f0f9ff;
            border-left: 4px solid #0ea5e9;
            padding: 25px;
            margin: 25px 0;
            border-radius: 6px;
        }
        .steps {
            display: grid;
            gap: 20px;
            margin: 30px 0;
        }
        .step {
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }
        .step-number {
            background: #3b82f6;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            flex-shrink: 0;
        }
        .step-content h3 {
            margin: 0 0 5px;
            color: #1f2937;
        }
        .step-content p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }
        .contact-info {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
            border: 1px solid #e5e7eb;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .icon {
            width: 20px;
            text-align: center;
        }
        .footer {
            text-align: center;
            padding: 25px;
            background: #f9fafb;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
        }
        .thank-you {
            text-align: center;
            margin-bottom: 30px;
        }
        .thank-you h2 {
            color: #1f2937;
            margin-bottom: 10px;
        }
        .thank-you p {
            color: #6b7280;
            max-width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Thank You for Contacting Us!</h1>
            <p>We have received your message and will get back to you soon.</p>
        </div>
        
        <div class="content">
            <div class="thank-you">
                <h2>Hello {{ $message->name }},</h2>
                <p>Thank you for reaching out to {{ config('app.name') }}. We appreciate you taking the time to contact us and will respond to your inquiry as soon as possible.</p>
            </div>
            
            <div class="message-box">
                <h3 style="margin-top: 0; color: #0c4a6e;">Your Message Summary</h3>
                <p><strong>Reference ID:</strong> #{{ str_pad($message->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p><strong>Subject:</strong> {{ $message->subject }}</p>
                <p><strong>Submitted:</strong> {{ $message->created_at->format('F j, Y \a\t h:i A') }}</p>
            </div>
            
            <div class="steps">
                <div class="step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>We've Received Your Message</h3>
                        <p>Your inquiry has been logged into our system and assigned a reference number.</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Team Review</h3>
                        <p>Our support team will review your message and prepare a response.</p>
                    </div>
                </div>
                
                <div class="step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>You'll Hear From Us Soon</h3>
                        <p>We typically respond within 24-48 hours during business days.</p>
                    </div>
                </div>
            </div>
            
            <div class="contact-info">
                <h3 style="margin-top: 0; color: #1f2937;">Our Contact Information</h3>
                <div class="contact-item">
                    <div class="icon">📧</div>
                    <div>{{ config('mail.from.address') }}</div>
                </div>
                <div class="contact-item">
                    <div class="icon">📞</div>
                    <div>{{ \App\Models\SiteSetting::getValue('contact_phone', '+880 1900-000000') }}</div>
                </div>
                <div class="contact-item">
                    <div class="icon">🏢</div>
                    <div>{{ \App\Models\SiteSetting::getValue('contact_address', '123 Street, City, Country') }}</div>
                </div>
            </div>
        </div>
        
        <div class="footer">
            <p>This is an automated message. Please do not reply to this email.</p>
            <p>© {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>