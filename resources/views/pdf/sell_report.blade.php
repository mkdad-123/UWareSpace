<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>تقرير المبيعات</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: rtl;
            text-align: right;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .content {
            margin-bottom: 20px;
        }
        .content h2 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }
        .content p {
            font-size: 16px;
            color: #666;
            line-height: 1.6;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        .table th {
            background-color: #f2f2f2;
            color: #333;
        }
        .footer {
            text-align: center;
            border-top: 2px solid #333;
            padding-top: 10px;
            margin-top: 20px;
        }
        .footer p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>تقرير المبيعات</h1>
    </div>
    <div class="content">
        <h2>ملخص التقرير</h2>
        <p>هذا هو ملخص تقرير المبيعات . يحتوي التقرير على تفاصيل المبيعات .</p>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>رقم الفاتورة</th>
            <th>اسم العميل</th>
            <th>تاريخ البيع</th>
            <th>المبلغ الإجمالي</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>001</td>
            <td>أحمد علي</td>
            <td>2024-08-01</td>
            <td>$500</td>
        </tr>
        <tr>
            <td>002</td>
            <td>محمد حسن</td>
            <td>2024-08-02</td>
            <td>$300</td>
        </tr>
        </tbody>
    </table>
    <div class="footer">
        <p>جميع الحقوق محفوظة &copy; 2024</p>
    </div>
</div>
</body>
</html>
