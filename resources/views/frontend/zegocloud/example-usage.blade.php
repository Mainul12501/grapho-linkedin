{{--
    ZEGOCLOUD CALL SYSTEM - EXAMPLE USAGE

    This file demonstrates how to integrate call buttons into your user profile pages.
    Copy the relevant code sections to your actual profile views.
--}}

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Call System Example</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f3f4f6;
        }

        .example-section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .example-section h2 {
            color: #1f2937;
            margin-top: 0;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 10px;
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
        }

        .user-info h3 {
            margin: 0 0 5px 0;
            color: #111827;
        }

        .user-info p {
            margin: 0;
            color: #6b7280;
            font-size: 14px;
        }

        .call-buttons-container {
            display: flex;
            gap: 12px;
            margin-top: 15px;
        }

        code {
            background: #1f2937;
            color: #10b981;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 14px;
        }

        .alert {
            padding: 16px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-info {
            background: #dbeafe;
            border-left: 4px solid #3b82f6;
            color: #1e40af;
        }

        .alert-warning {
            background: #fef3c7;
            border-left: 4px solid #f59e0b;
            color: #92400e;
        }

        .steps {
            counter-reset: step;
            list-style: none;
            padding: 0;
        }

        .steps li {
            counter-increment: step;
            padding: 15px;
            margin-bottom: 10px;
            background: #f9fafb;
            border-radius: 6px;
            position: relative;
            padding-left: 50px;
        }

        .steps li::before {
            content: counter(step);
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h1 style="text-align: center; color: #1f2937;">ZegoCloud Call System - Usage Examples</h1>

    {{-- Example 1: Simple Integration --}}
    <div class="example-section">
        <h2>📝 Example 1: Basic Integration</h2>

        <div class="alert alert-info">
            <strong>Note:</strong> This is a demonstration. Replace <code>$exampleUser</code> with your actual user variable.
        </div>

        @php
            // Simulating a user for demo purposes
            $exampleUser = new stdClass();
            $exampleUser->id = 2;
            $exampleUser->name = "John Doe";
            $exampleUser->profile_photo_url = "https://ui-avatars.com/api/?name=John+Doe&size=200";
            $exampleUser->email = "john@example.com";
        @endphp

        <div class="user-card">
            <img src="{{ $exampleUser->profile_photo_url }}" alt="{{ $exampleUser->name }}" class="user-avatar">
            <div class="user-info">
                <h3>{{ $exampleUser->name }}</h3>
                <p>{{ $exampleUser->email }}</p>
                <div id="call-buttons-1" class="call-buttons-container">
                    <!-- Buttons will be added here by JavaScript -->
                </div>
            </div>
        </div>

        <h4>Code for this example:</h4>
        <pre style="background: #1f2937; color: #10b981; padding: 20px; border-radius: 8px; overflow-x: auto;">
&lt;!-- Include the helper script --&gt;
&lt;script src="{{ asset('js/zegocloud-caller.js') }}"&gt;&lt;/script&gt;

&lt;div id="call-buttons-container"&gt;&lt;/div&gt;

&lt;script&gt;
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = '{{ csrf_token() }}';
    const userId = {{ $exampleUser->id }};
    const container = document.getElementById('call-buttons-container');

    // Add video call button
    const videoBtn = ZegoCloudCaller.createVideoCallButton(userId, csrfToken);
    container.appendChild(videoBtn);

    // Add audio call button
    const audioBtn = ZegoCloudCaller.createAudioCallButton(userId, csrfToken);
    container.appendChild(audioBtn);
});
&lt;/script&gt;</pre>
    </div>

    {{-- Example 2: Custom Buttons --}}
    <div class="example-section">
        <h2>🎨 Example 2: Custom Styled Buttons</h2>

        <div class="user-card">
            <img src="https://ui-avatars.com/api/?name=Jane+Smith&size=200" alt="Jane Smith" class="user-avatar">
            <div class="user-info">
                <h3>Jane Smith</h3>
                <p>jane.smith@example.com</p>
                <div class="call-buttons-container">
                    <button onclick="callUser(3, 'video')" style="
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        border: none;
                        padding: 12px 24px;
                        border-radius: 8px;
                        cursor: pointer;
                        font-weight: 500;
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                    ">
                        📹 Video Call
                    </button>
                    <button onclick="callUser(3, 'audio')" style="
                        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
                        color: white;
                        border: none;
                        padding: 12px 24px;
                        border-radius: 8px;
                        cursor: pointer;
                        font-weight: 500;
                        display: inline-flex;
                        align-items: center;
                        gap: 8px;
                    ">
                        📞 Audio Call
                    </button>
                </div>
            </div>
        </div>

        <h4>Code for custom buttons:</h4>
        <pre style="background: #1f2937; color: #10b981; padding: 20px; border-radius: 8px; overflow-x: auto;">
&lt;button onclick="callUser(userId, 'video')"&gt;
    📹 Video Call
&lt;/button&gt;
&lt;button onclick="callUser(userId, 'audio')"&gt;
    📞 Audio Call
&lt;/button&gt;

&lt;script src="{{ asset('js/zegocloud-caller.js') }}"&gt;&lt;/script&gt;
&lt;script&gt;
function callUser(userId, callType) {
    const csrfToken = '{{ csrf_token() }}';
    ZegoCloudCaller.initiateCall(userId, callType, csrfToken);
}
&lt;/script&gt;</pre>
    </div>

    {{-- Example 3: Integration Steps --}}
    <div class="example-section">
        <h2>🚀 Integration Steps</h2>

        <ol class="steps">
            <li>
                <strong>Include the incoming call popup in your main layout</strong><br>
                Add to <code>resources/views/layouts/app.blade.php</code>:
                <pre style="margin-top: 10px;">@include('frontend.zegocloud.incoming-call-popup')</pre>
            </li>

            <li>
                <strong>Include the JavaScript helper in your page</strong><br>
                <pre>&lt;script src="{{ asset('js/zegocloud-caller.js') }}"&gt;&lt;/script&gt;</pre>
            </li>

            <li>
                <strong>Add call buttons where you want them</strong><br>
                Use either the pre-built buttons or create custom ones
            </li>

            <li>
                <strong>Make sure queue worker is running</strong><br>
                <code>php artisan queue:work</code>
            </li>

            <li>
                <strong>Test the integration</strong><br>
                Open the site in two different browsers and try calling
            </li>
        </ol>
    </div>

    {{-- Example 4: Where to Add Call Buttons --}}
    <div class="example-section">
        <h2>📍 Where to Add Call Buttons</h2>

        <div class="alert alert-warning">
            <strong>Suggestions for integration:</strong>
        </div>

        <ul style="line-height: 2;">
            <li><strong>Employee Profile Page:</strong> Add call buttons to employer's view of employee profiles</li>
            <li><strong>Employer Profile Page:</strong> Add call buttons to employee's view of company profiles</li>
            <li><strong>Chat/Messaging Interface:</strong> Add quick call buttons in chat conversations</li>
            <li><strong>Job Applicant List:</strong> Add call buttons next to each applicant</li>
            <li><strong>Dashboard/Home:</strong> Add quick call buttons for recent contacts</li>
        </ul>

        <h4>Example for Employee Profile:</h4>
        <pre style="background: #1f2937; color: #10b981; padding: 20px; border-radius: 8px; overflow-x: auto;">
{{-- In your employee profile view --}}
@if(auth()->user()->user_type === 'employer')
    &lt;div class="contact-actions"&gt;
        &lt;h4&gt;Contact {{ $employee->name }}&lt;/h4&gt;
        &lt;div id="employee-call-buttons"&gt;&lt;/div&gt;
    &lt;/div&gt;

    &lt;script src="{{ asset('js/zegocloud-caller.js') }}"&gt;&lt;/script&gt;
    &lt;script&gt;
        const container = document.getElementById('employee-call-buttons');
        const csrfToken = '{{ csrf_token() }}';

        container.appendChild(
            ZegoCloudCaller.createVideoCallButton({{ $employee->id }}, csrfToken)
        );
        container.appendChild(
            ZegoCloudCaller.createAudioCallButton({{ $employee->id }}, csrfToken)
        );
    &lt;/script&gt;
@endif</pre>
    </div>

    {{-- JavaScript for this demo page --}}
    <script src="{{ asset('js/zegocloud-caller.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = '{{ csrf_token() }}';

            // Example 1: Add call buttons
            const container1 = document.getElementById('call-buttons-1');
            if (container1) {
                container1.appendChild(ZegoCloudCaller.createVideoCallButton({{ $exampleUser->id }}, csrfToken));
                container1.appendChild(ZegoCloudCaller.createAudioCallButton({{ $exampleUser->id }}, csrfToken));
            }
        });

        // Example 2: Custom button handler
        function callUser(userId, callType) {
            const csrfToken = '{{ csrf_token() }}';
            ZegoCloudCaller.initiateCall(userId, callType, csrfToken);
        }
    </script>

    {{-- Include the incoming call popup for demo --}}
    @include('frontend.zegocloud.incoming-call-popup')
</body>
</html>
