<html>
<head>
    <title>Chi tiết đơn hàng</title>
</head>


<body>
<h1 style="text-align: center">Chi tiết đơn hàng</h1>
<p>Mã vận đơn: {{ $order->id }}</p>
<h2>Sản phẩm</h2>
@php
    $totalAmount = 0;
@endphp
<table style="width: 100%;border-collapse: collapse;" id="customers">
    <thead>
    <tr>
        <th style="border: 1px solid #ddd;padding: 8px;">Tên sản phẩm</th>
        <th style="border: 1px solid #ddd;padding: 8px;">Số lượng</th>
        <th style="border: 1px solid #ddd;padding: 8px;">Tổng tiền</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orderItems as $item)

    <tr>
        <td style="border: 1px solid #ddd;padding: 8px;text-align: center">{{ $item->product->NameProducts }}</td>
        <td style="border: 1px solid #ddd;padding: 8px;text-align: center">{{ $item->Quantity }}</td>
        <td style="border: 1px solid #ddd;padding: 8px;text-align: center">{{ number_format(floatval($item->product->Price) * $item->Quantity, 0, ',', '.') }} vnđ</td>


    </tr>
    @php
        $subtotal = floatval($item->product->Price) * $item->Quantity;
        $totalAmount += $subtotal;
    @endphp
    @endforeach

    </tbody>
</table>


</div>

<div class="d-flex justify-content-end p-9" style="margin-top: 2em; float: right">
    <div >
        <h3>Tổng thanh toán: {{ number_format($totalAmount, 0, ',', '.') }} vnđ </h3>
    </div>
</div>

</body>
</html>
