<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ \App\Models\Setting::getAppName() }}</title>
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
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
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
            color: #d1fae5;
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
        
        /* Credentials Box */
        .credentials-box {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 2px solid #0ea5e9;
            border-radius: 12px;
            padding: 25px;
            margin: 30px 0;
            text-align: center;
        }
        
        .credentials-box h3 {
            color: #0c4a6e;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 20px;
        }
        
        .credential-item {
            background-color: #ffffff;
            border: 1px solid #bae6fd;
            border-radius: 8px;
            padding: 15px;
            margin: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .credential-label {
            font-weight: 600;
            color: #0c4a6e;
            font-size: 14px;
        }
        
        .credential-value {
            font-family: 'Courier New', monospace;
            font-weight: 700;
            color: #0369a1;
            font-size: 16px;
            background-color: #f8fafc;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #e2e8f0;
        }
        
        /* Login Button */
        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
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
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.4);
        }
        
        /* Security notice */
        .security-notice {
            background-color: #fef3c7;
            border-left: 4px solid #f59e0b;
            padding: 20px;
            margin: 30px 0;
            border-radius: 0 8px 8px 0;
        }
        
        .security-notice h3 {
            color: #92400e;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .security-notice p {
            color: #a16207;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .security-notice ul {
            color: #a16207;
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
            
            .login-button {
                display: block;
                width: 100%;
                text-align: center;
            }
            
            .credential-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .credential-value {
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
            <h1>Welcome to {{ \App\Models\Setting::getAppName() }}!</h1>
            <p>Your account has been created successfully</p>
        </div>
        
        <!-- Content -->
        <div class="email-content">
            <div class="greeting">
                Hello {{ $user->getFullName() }},
            </div>
            
            <div class="message">
                Welcome to {{ \App\Models\Setting::getAppName() }}! Your account has been created and you can now access your dashboard. 
                Below are your login credentials:
            </div>
            
            <!-- Credentials Box -->
            <div class="credentials-box">
                <h3>🔐 Your Login Credentials</h3>
                
                <div class="credential-item">
                    <span class="credential-label">Email Address:</span>
                    <span class="credential-value">{{ $user->email }}</span>
                </div>
                
                <div class="credential-item">
                    <span class="credential-label">Password:</span>
                    <span class="credential-value">{{ $password }}</span>
                </div>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('login') }}" class="login-button">
                    🚀 Login to Your Account
                </a>
            </div>
            
            <div class="security-notice">
                <h3>🔒 Important Security Information</h3>
                <p>For your security, please:</p>
                <ul>
                    <li>Change your password after your first login</li>
                    <li>Keep your login credentials secure and private</li>
                    <li>Never share your password with anyone</li>
                    <li>Use a strong, unique password</li>
                    <li>Log out when using shared computers</li>
                </ul>
            </div>
            
            <div class="message">
                If you have any questions or need assistance, please don't hesitate to contact our support team.
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
