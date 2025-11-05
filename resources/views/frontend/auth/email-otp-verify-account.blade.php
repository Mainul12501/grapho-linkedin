<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
{{--    <title>{{ $purpose == 'recovery' ? 'Recovery Account' : 'Verify Your Email' }} - LikewiseBD</title>--}}
    <title></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            background-color: #f4f7fa;
            padding: 20px;
        }

        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 40px;
            text-align: left;
            color: #ffffff;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -5%;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .logo-container {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            letter-spacing: 2px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .logo-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            font-size: 28px;
            backdrop-filter: blur(10px);
            flex-shrink: 0;
        }

        .header-subtitle {
            font-size: 14px;
            opacity: 0.95;
            font-weight: 300;
            letter-spacing: 2px;
            text-transform: uppercase;
            position: relative;
            z-index: 1;
        }

        .header-decoration {
            display: none;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 24px;
            color: #333333;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .message {
            color: #666666;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.8;
        }

        .otp-container {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            border-radius: 10px;
            padding: 30px;
            text-align: center;
            margin: 30px 0;
            border: 2px dashed #667eea;
        }

        .otp-label {
            font-size: 14px;
            color: #666666;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .otp-code {
            font-size: 42px;
            font-weight: bold;
            color: #667eea;
            letter-spacing: 8px;
            margin: 10px 0;
            font-family: 'Courier New', monospace;
        }

        .otp-expiry {
            font-size: 13px;
            color: #999999;
            margin-top: 15px;
        }

        .warning-box {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .warning-box p {
            color: #856404;
            font-size: 14px;
            margin: 0;
        }

        .info-text {
            color: #666666;
            font-size: 14px;
            margin-top: 25px;
            line-height: 1.6;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .footer-text {
            color: #999999;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .social-links {
            margin: 20px 0;
        }

        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
        }

        .footer-link {
            color: #667eea;
            text-decoration: none;
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        .divider {
            height: 1px;
            background-color: #e9ecef;
            margin: 25px 0;
        }

        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }

            .email-container {
                border-radius: 8px;
            }

            .header {
                padding: 40px 20px;
            }

            .logo {
                font-size: 28px;
                letter-spacing: 1.5px;
            }

            .logo-icon {
                width: 45px;
                height: 45px;
                line-height: 45px;
                font-size: 24px;
            }

            .content {
                padding: 30px 20px;
            }

            .greeting {
                font-size: 20px;
            }

            .message {
                font-size: 15px;
            }

            .otp-code {
                font-size: 36px;
                letter-spacing: 6px;
            }

            .footer {
                padding: 25px 20px;
            }
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header -->
    <div class="header">
        <div class="logo-container">
            <div class="logo-icon">✓</div>
            <div class="logo">LikewiseBD</div>
            <div class="header-subtitle">{{ trans('auth.email_verification') }}</div>
            <div class="header-decoration"></div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h1 class="greeting">{{ $purpose == 'recovery' ? trans('auth.recover_your_account') : trans('auth.verify_your_email_address') }}</h1>

        <p class="message">
            {{ isset($user) ? "Dear $user->name, " : '' }}Thank you for {{ $purpose == 'recovery' ? 'staying' : 'signing up' }} with LikewiseBD! To complete your registration and activate your account, please use the One-Time Password (OTP) below:
        </p>

        <!-- OTP Box -->
        <div class="otp-container">
            <div class="otp-label">{{ trans('auth.your_verification_code') }}</div>
            <div class="otp-code">{{ $otp ?? '00000' }}</div>
            <div class="otp-expiry">{{ trans('auth.code_expires_in_10_minutes') }}</div>
        </div>

        <!-- Warning Box -->
        <div class="warning-box">
            <p><strong>{{ trans('auth.security_note') }}</strong> {{ trans('auth.never_share_code') }}</p>
        </div>

        <div class="divider"></div>

        <p class="info-text">
            {{ trans('auth.didnt_request_code') }}
        </p>

        <p class="info-text">
            {{ trans('auth.need_help_contact') }} <a href="mailto:support@likewisebd.com" class="footer-link">support@likewisebd.com</a>
        </p>
    </div>

    <!-- Footer -->
    <div class="footer">
        <div class="social-links">
            <a href="https://likewisebd.com">Website</a> |
            <a href="{{ $siteSetting->fb ?? '' }}">Facebook</a> |
            <a href="{{ $siteSetting->x_link ?? '' }}">X</a> |
            <a href="{{ $siteSetting->youtube ?? '' }}">Youtube</a>
        </div>

        <p class="footer-text">
            © {{ date('Y') }} LikewiseBD. All rights reserved.
        </p>

        <p class="footer-text">
            LikewiseBD, Dhaka, Bangladesh<br>
            <a href="https://likewisebd.com" class="footer-link">www.likewisebd.com</a>
        </p>
    </div>
</div>
</body>
</html>
