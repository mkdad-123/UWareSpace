<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>خطأ في تأكيد الحساب</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8d7da;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .error-container {
            text-align: center;
            background-color: #f8d7da;
            color: #721c24;
            padding: 30px;
            border-radius: 10px;
            border: 1px solid #f5c6cb;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: inline-block;
            margin: 20px;
            animation: shake 0.5s;
        }
        .error-container h1 {
            margin-top: 0;
            font-size: 2em;
        }
        .error-container p {
            font-size: 1.2em;
        }
        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            50% { transform: translateX(5px); }
            75% { transform: translateX(-5px); }
            100% { transform: translateX(0); }
        }
    </style>
</head>
<body>
<div class="error-container">
    <h1>خطأ في تأكيد الحساب!</h1>
    <p>معلومات التأكيد التي أدخلتها غير صحيحة. يرجى المحاولة مرة أخرى.</p>
</div>
</body>
</html>
