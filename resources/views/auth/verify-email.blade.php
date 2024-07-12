<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #D1E8E2; /* Light green background */
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #B3D4E0; /* Light blue container */
            width: 100%;
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px; /* Rounded corners for the container */
        }
        .content {
            padding: 20px;
            animation: contentFadeIn 1s ease-in-out; /* Subtle animation for content */
        }
        @keyframes contentFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .code {
            font-size: 24px; /* Larger font size for the code */
            font-weight: bold; /* Bold font for the code */
            color: #005A31; /* Dark green color for the code */
        }
        .footer {
            background-color: #B3D4E0; /* Light blue footer */
            padding: 10px 20px;
            text-align: center;
            font-size: 0.8em;
            border-top: 1px solid #D1E8E2; /* Light green border top */
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            background-color: #005A31; /* Dark green button */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <h1>Hello {{ $name }},</h1>
        <p>Thank you for registering with Manga. Please use the following code to verify your account:</p>
        <div style="text-align: center;">
            <div class="code">{{ $code }}</div>
        </div>
        <p>If you did not request this code, please ignore this message.</p>
    </div>
    <div class="footer">
        © {{ date('Y') }} Manga. All rights reserved.
    </div>
</div>
</body>
</html>
