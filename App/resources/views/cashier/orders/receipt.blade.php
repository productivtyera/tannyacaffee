<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $order->order_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .items {
            width: 100%;
            border-collapse: collapse;
        }
        .items th {
            text-align: left;
            border-bottom: 1px dashed #000;
        }
        .items td {
            padding: 5px 0;
            vertical-align: top;
        }
        .text-right {
            text-align: right;
        }
        .total {
            font-weight: bold;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 10px;
        }
        @media print {
            body {
                width: 100%;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="header">
        <h1>TANNYA CAFFE</h1>
        <p>Jl. Contoh No. 123, Kota</p>
        <p>Telp: 0812-3456-7890</p>
    </div>

    <div class="divider"></div>

    <div>
        <p>No. Order: {{ $order->order_number }}</p>
        <p>Tanggal: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p>Kasir: {{ $order->cashier->name ?? '-' }}</p>
        <p>{{ $order->table_number ? 'Meja: ' . $order->table_number : 'Takeaway' }}</p>
    </div>

    <div class="divider"></div>

    <table class="items">
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td class="text-right">{{ $item->qty }}</td>
                    <td class="text-right">{{ number_format($item->qty * $item->unit_price, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <table class="items">
        <tr>
            <td>Total</td>
            <td class="text-right total">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
        </tr>
        @if($order->payment_method == 'cash')
            @php
                $paid = $order->amount_paid ?? $order->total_price;
                $change = $paid - $order->total_price;
            @endphp
            <tr>
                <td>Tunai</td>
                <td class="text-right">Rp{{ number_format($paid, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Kembali</td>
                <td class="text-right">Rp{{ number_format($change, 0, ',', '.') }}</td>
            </tr>
        @endif
        <tr>
            <td>Metode</td>
            <td class="text-right">{{ $order->payment_method ? ucfirst(str_replace('_', ' ', $order->payment_method)) : '-' }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Terima Kasih atas Kunjungan Anda</p>
        <p>Password Wifi: kopi_enak</p>
    </div>
</body>
</html>
