<!DOCTYPE html>
<html>

<head>

    <title>Invoice</title>

    <style>
        body {
            font-family: Arial;
            width: 300px;
            margin: auto;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 20px;
        }

        td {
            padding: 4px 0;
        }

        .total {
            font-weight: bold;
        }
    </style>

</head>

<body>

    <h2>Toko Buku</h2>

    <hr>

    <p>
        Invoice : #{{ $payment->id }} <br>
        Tanggal : {{ $payment->created_at->format('d M Y H:i') }}
    </p>

    <hr>

    <table>

        <tr>
            <td>Buku</td>
            <td align="right">{{ $payment->order->book->title }}</td>
        </tr>

        <tr>
            <td>Qty</td>
            <td align="right">{{ $payment->order->qty }}</td>
        </tr>

        <tr>
            <td>Harga</td>
            <td align="right">Rp {{ number_format($payment->order->price, 0, ',', '.') }}</td>
        </tr>

        <tr class="total">
            <td>Total</td>
            <td align="right">Rp {{ number_format($payment->total_price, 0, ',', '.') }}</td>
        </tr>

    </table>

    <hr>

    <table>

        <tr>
            <td>Cash</td>
            <td align="right">
                Rp {{ number_format($payment->cash, 0, ',', '.') }}
            </td>
        </tr>

        <tr>
            <td>Kembalian</td>
            <td align="right">
                Rp {{ number_format($payment->change, 0, ',', '.') }}
            </td>
        </tr>

    </table>

    <hr>

    <p style="text-align:center">
        Terima Kasih
    </p>

    <script>
        window.onload = function() {

            window.print()

            setTimeout(function() {
                window.close()
            }, 500)

        }
    </script>

</body>

</html>
