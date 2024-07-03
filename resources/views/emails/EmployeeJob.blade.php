<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .email-container {
            max-width: 700px; /* تم تكبير الإطار ليشمل كل المحتويات */
            margin: auto;
            border: 3px solid #3498db;
            padding: 20px;
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9; /* لون خلفية خفيف */
        }
        .welcome-message {
            color: #3498db;
            font-weight: bold;
        }
        .employee-details {
            background-color: #ecf0f1;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
        }
        .admin-info {
            text-align: right;
            margin-top: 30px;
            font-size: 0.9em;
            color: #3498db; /* لون المعلومات الأزرق */
            opacity: 0.7; /* جعل المعلومات شفافة قليلاً */
            border-top: 1px solid #3498db; /* خط فاصل */
            padding-top: 10px; /* تباعد بعد الخط الفاصل */
        }
        .admin-info div {
            margin-bottom: 5px;
        }
        .reset-password {
            text-align: center;
            margin-top: 20px;
        }
        .reset-password a {
            display: inline-block;
            text-decoration: none;
            color: white;
            background-color: #3498db;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .reset-password a:hover {
            background-color: #2980b9;
        }
    </style>
    <title></title>
</head>
<body>
<div class="email-container">
    <p class="welcome-message">Hello {{$name}}</p>
    <p>نحن سعداء جدًا بانضمامك إلى فريقنا. نثق بأنك ستكون إضافة قيمة وستساهم في نجاحنا المستمر.</p>
        <div class="employee-details">
            <p><strong>user name :</strong> {{ $name }}</p>
            <p><strong> password :</strong> {{ $password }}</p>
            <p><strong>position:</strong> {{ $role }}</p>
        </div>
        <p> الموجود في واجهة تسجيل الدخول بالتطبيق.<strong>"إعادة تعيين كلمة السر"</strong>إذا كنت ترغب في تغيير كلمة السر الخاصة بك، يمكنك القيام بذلك بسهولة عبر زر </p>
    </div>
    <p>مع أطيب التحيات،</p>
    <p>فريق العمل</p>
    <div class="admin-info">
        <div><strong>Administration:</strong> {{ $adminName }}</div>
        <div><strong> E-mail :</strong> {{ $adminEmail }}</div>
        <div><strong>phone number :</strong> {{ $adminPhone }}</div>
    </div>
</body>
</html>
