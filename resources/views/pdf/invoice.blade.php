<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
            direction: ltr;
            text-align: left;
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
            position: relative;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header img {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 50px;
            opacity: 0.5;
            filter: grayscale(100%);
        }
        .company-info {
            text-align: right;
            font-size: 12px;
            color: #666;
            margin-top: 5px;
            line-height: 1.2;
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
            padding: 6px;
            text-align: center;
            font-size: 12px;
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
        <h1>{{ $title }}</h1>
        @if (!is_null($logo))
            <img src="{{ asset($logo) }}" alt="Logo">
        @endif
        @if (!is_null($company))
            <div class="company-info">
                <p>{{ $company['name'] }}</p>
                <p>{{ $company['email'] }}</p>
                <p>number phone :</p>
                @foreach ($company['phones'] as $phone)
                    <p>{{$phone['number']}}</p>
                @endforeach
            </div>
        @endif
    </div>
    <div class="content">
        <h2>Invoice Details</h2>
        <p>Invoice Number: {{ $order['order']['invoice_number'] }}</p>
        <p>Dear Mr./Ms. {{ $order['client']['name'] }}</p>
    </div>
    <table class="table">
        <thead>
        <tr>
            <th>Item Name</th>
            <th>SKU</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($order['order']['order_items'] as $item)
            <tr>
                <td>{{ $item['item']['name'] }}</td>
                <td>{{ $item['item']['SKU'] }}</td>
                <td>{{ $item['item']['sell_price'] }}</td>
                <td>{{ $item['quantity'] }}</td>
            </tr>
        @endforeach


        </tbody>
    </table>
    <div class="content">
        <p>Warehouse Name: {{ $order['order']['warehouse']['name'] }}</p>
        <p>Shipment Number: {{ $order['shipment']['tracking_number'] }}</p>
        <p>Total Price: {{ $order['order']['price'] }}</p>
    </div>
    <div class="footer">
        <p>All rights reserved © 2024</p>
    </div>
</div>
</body>
</html>
