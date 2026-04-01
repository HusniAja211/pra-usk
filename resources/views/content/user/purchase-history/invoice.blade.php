<!DOCTYPE html>
<html>

<head>
    <title>Invoice #INV-{{ str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 2px;
            font-size: 18px;
        }

        .subtitle {
            text-align: center;
            font-size: 11px;
            color: #777;
            margin-bottom: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        td {
            padding: 4px 0;
            vertical-align: top;
        }

        .total {
            font-weight: bold;
            font-size: 14px;
        }

        .right {
            text-align: right;
        }

        hr {
            border: 0;
            border-top: 1px dashed #aaa;
            margin: 10px 0;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>Toko Buku</h2>
    <div class="subtitle">Bukti Pembayaran</div>

    <hr>

    <table>
        <tr>
            <td>No. INV</td>
            <td class="right">#INV-{{ str_pad($payment->id, 4, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td class="right">{{ $payment->created_at->format('d M Y H:i') }}</td>
        </tr>
        <tr>
            <td>Pelanggan</td>
            <td class="right">{{ $payment->order->user->name ?? 'Guest' }}</td>
        </tr>
    </table>

    <hr>

    <table>
        <tr>
            <td>
                {{ $payment->order->book->title }} <br>
                <span style="font-size: 11px;">{{ $payment->order->qty }} x Rp {{ number_format($payment->order->price, 0, ',', '.') }}</span>
            </td>
            <td class="right" style="vertical-align: bottom;">
                Rp {{ number_format($payment->order->price * $payment->order->qty, 0, ',', '.') }}
            </td>
        </tr>
    </table>

    <hr>

    <table>
        <tr class="total">
            <td>Total</td>
            <td class="right">Rp {{ number_format($payment->total_price, 0, ',', '.') }}</td>
        </tr>
    </table>

    <hr>

    <table>
        <tr>
            <td>Metode Bayar</td>
            <td class="right" style="text-transform: capitalize;">{{ $payment->payment_method }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td class="right" style="text-transform: uppercase; font-weight: bold;">
                {{ $payment->status }}
            </td>
        </tr>
    </table>

    <hr>

    <p class="text-center" style="margin-top: 20px; font-size: 11px;">
        Terima Kasih<br>
        Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.
    </p>

</body>
</html>