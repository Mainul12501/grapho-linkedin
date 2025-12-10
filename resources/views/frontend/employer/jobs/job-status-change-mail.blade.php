<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Application Status Update</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Arial', 'Helvetica', sans-serif;
            background-color: #f4f4f4;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            text-align: center;
            color: #ffffff;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .email-header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            opacity: 0.9;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: bold;
            margin-top: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .status-pending {
            background-color: #fbbf24;
            color: #78350f;
        }
        .status-shortlisted {
            background-color: #60a5fa;
            color: #1e3a8a;
        }
        .status-approved {
            background-color: #34d399;
            color: #064e3b;
        }
        .status-rejected {
            background-color: #f87171;
            color: #7f1d1d;
        }
        .email-body {
            padding: 40px 30px;
            color: #333333;
        }
        .email-body p {
            margin: 0 0 15px 0;
            font-size: 15px;
            line-height: 1.8;
        }
        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 20px;
        }
        .message-content {
            background-color: #f9fafb;
            padding: 20px;
            border-left: 4px solid #667eea;
            border-radius: 4px;
            margin: 20px 0;
        }
        .job-details {
            background-color: #eff6ff;
            padding: 15px;
            border-radius: 6px;
            margin: 25px 0;
        }
        .job-details h3 {
            margin: 0 0 10px 0;
            font-size: 16px;
            color: #1e40af;
        }
        .job-details p {
            margin: 5px 0;
            font-size: 14px;
            color: #1e3a8a;
        }
        .cta-button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }
        .email-footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .email-footer p {
            margin: 5px 0;
            font-size: 13px;
            color: #6b7280;
        }
        .email-footer a {
            color: #667eea;
            text-decoration: none;
        }
        .social-links {
            margin: 15px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 5px;
            color: #6b7280;
            text-decoration: none;
            font-size: 12px;
        }
        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 25px 0;
        }
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            .email-body {
                padding: 30px 20px;
            }
            .email-header {
                padding: 25px 15px;
            }
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header -->
    <div class="email-header">
        <h1>LikewiseBD</h1>
        <p>Career Opportunities</p>
        <span class="status-badge status-{{ $status }}">
                {{ ucfirst($status) }}
            </span>
    </div>

    <!-- Body -->
    <div class="email-body">
        <p class="greeting">Dear {{ $user->name }},</p>

        <div class="message-content">
            <p>{{ $msg }}</p>
        </div>

        @if($status == 'shortlisted')
            <p>We were impressed by your qualifications and would like to move forward with the next stage of our selection process. Our team will contact you shortly with details about the next steps.</p>
            <p>Please keep an eye on your email and phone for further communication from us.</p>
        @elseif($status == 'pending')
            <p>Our hiring team will carefully evaluate your qualifications and experience. We appreciate your interest in joining our team and will keep you updated on the progress of your application.</p>
            <p>If you have any questions, please don't hesitate to contact us.</p>
        @elseif($status == 'approved')
            <p>Your skills, experience, and interview performance stood out, and we believe you'll be a valuable addition to our team. We will send you a formal offer letter with detailed information about your role, compensation, and starting date shortly.</p>
            <p><strong>Welcome to the LikewiseBD family! We look forward to working with you.</strong></p>
            <a href="https://likewisebd.com" class="cta-button">Visit Our Website</a>
        @elseif($status == 'rejected')
            <p>We truly appreciate your interest in our company and encourage you to apply for future opportunities that align with your skills and experience. We will keep your resume on file for consideration.</p>
            <p>We wish you all the best in your job search and future career endeavors.</p>
        @endif

        <div class="divider"></div>

        <p style="font-size: 13px; color: #6b7280;">
            This is an automated message regarding your job application. Please do not reply to this email.
        </p>
    </div>

    <!-- Footer -->
    <div class="email-footer">
        <p><strong>LikewiseBD</strong></p>
        <p>Connecting Talent with Opportunity</p>
        <p><a href="https://likewisebd.com">www.likewisebd.com</a></p>

        <div class="social-links">
            <a href="#">Facebook</a> |
            <a href="#">LinkedIn</a> |
            <a href="#">Twitter</a>
        </div>

        <p style="margin-top: 15px; font-size: 12px;">
            © {{ date('Y') }} LikewiseBD. All rights reserved.
        </p>
    </div>
</div>
</body>
</html>
