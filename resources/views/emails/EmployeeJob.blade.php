<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .email-container {
            max-width: 600px;
            margin: auto;
            border: 3px solid #3498db;
            padding: 20px;
            font-family: 'Arial', sans-serif;
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
    </style>
    <title></title>
</head>
<body>
<div class="email-container">
    <p class="welcome-message"> Hello {{$name}}} ,</p>
    <p>نحن سعداء جدًا بانضمامك إلى فريقنا. نثق بأنك ستكون إضافة قيمة وستساهم في نجاحنا المستمر.</p>
    <div class="employee-details">
        <p><strong> user name : </strong>{{$name}}}</p>
        <p><strong> password : </strong> {{$password}}}</p>
        <p><strong>position :</strong> {{$role}}} </p>
    </div>
    <p>نتمنى لك التوفيق في مهامك الجديدة ونتطلع إلى العمل معًا لتحقيق أهدافنا.</p>
    <p>مع أطيب التحيات،</p>
    <p>فريق العمل</p>
</div>
</body>
</html>
