<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
    <style>
        /* Reset styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f8fafc;
        }
        
        /* Container */
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        /* Header */
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
        }
        
        .email-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .email-header p {
            color: #e2e8f0;
            font-size: 16px;
            font-weight: 400;
        }
        
        /* Content */
        .email-content {
            padding: 40px 30px;
        }
        
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1a202c;
            margin-bottom: 20px;
        }
        
        .message {
            font-size: 16px;
            color: #4a5568;
            margin-bottom: 30px;
            line-height: 1.7;
        }
        
        /* Button */
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            padding: 16px 32px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        
        .reset-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        /* Security notice */
        .security-notice {
            background-color: #f7fafc;
            border-left: 4px solid #4299e1;
            padding: 20px;
            margin: 30px 0;
            border-radius: 0 8px 8px 0;
        }
        
        .security-notice h3 {
            color: #2d3748;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .security-notice p {
            color: #4a5568;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .security-notice ul {
            color: #4a5568;
            font-size: 14px;
            margin-left: 20px;
        }
        
        .security-notice li {
            margin-bottom: 4px;
        }
        
        /* Footer */
        .email-footer {
            background-color: #f8fafc;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        
        .email-footer p {
            color: #718096;
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .email-footer .app-name {
            color: #2d3748;
            font-weight: 600;
        }
        
        .expiry-notice {
            background-color: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 6px;
            padding: 15px;
            margin: 20px 0;
        }
        
        .expiry-notice p {
            color: #c53030;
            font-size: 14px;
            font-weight: 500;
            margin: 0;
        }
        
        /* Responsive design */
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .email-header {
                padding: 30px 20px;
            }
            
            .email-header h1 {
                font-size: 24px;
            }
            
            .email-content {
                padding: 30px 20px;
            }
            
            .email-footer {
                padding: 20px;
            }
            
            .reset-button {
                display: block;
                width: 100%;
                text-align: center;
            }
        }
        
        /* Dark mode support */
        @media (prefers-color-scheme: dark) {
            body {
                background-color: #1a202c;
            }
            
            .email-container {
                background-color: #2d3748;
            }
            
            .greeting {
                color: #f7fafc;
            }
            
            .message {
                color: #e2e8f0;
            }
            
            .email-footer {
                background-color: #1a202c;
                border-top-color: #4a5568;
            }
            
            .email-footer p {
                color: #a0aec0;
            }
            
            .email-footer .app-name {
                color: #f7fafc;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>Reset Your Password</h1>
            <p>{{ \App\Models\Setting::getAppName() }}</p>
        </div>
        
        <!-- Content -->
        <div class="email-content">
            <div class="greeting">
                Hello {{ $user->getFullName() }},
            </div>
            
            <div class="message">
                We received a request to reset your password for your {{ \App\Models\Setting::getAppName() }} account. 
                If you made this request, click the button below to reset your password.
            </div>
            
            <div style="text-align: center;">
                <a href="{{ $resetUrl }}" class="reset-button">
                    Reset My Password
                </a>
            </div>
            
            <div class="expiry-notice">
                <p>⏰ This link will expire in 24 hours for security reasons.</p>
            </div>
            
            <div class="security-notice">
                <h3>🔒 Security Information</h3>
                <p>If you didn't request this password reset, please ignore this email. Your password will remain unchanged.</p>
                <p>For your security, please note that:</p>
                <ul>
                    <li>This link can only be used once</li>
                    <li>The link expires in 24 hours</li>
                    <li>Never share this link with anyone</li>
                    <li>Our team will never ask for your password</li>
                </ul>
            </div>
            
            <div class="message">
                If the button above doesn't work, you can copy and paste the following link into your browser:
            </div>
            
            <div style="background-color: #f7fafc; padding: 15px; border-radius: 6px; margin: 20px 0; word-break: break-all;">
                <a href="{{ $resetUrl }}" style="color: #4299e1; text-decoration: none;">{{ $resetUrl }}</a>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p>This email was sent from <span class="app-name">{{ \App\Models\Setting::getAppName() }}</span></p>
            <p>If you have any questions, please contact our support team.</p>
            <p style="font-size: 12px; color: #a0aec0; margin-top: 20px;">
                © {{ date('Y') }} {{ \App\Models\Setting::getAppName() }}. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
