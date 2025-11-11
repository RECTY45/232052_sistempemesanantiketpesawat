<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }

        .header h1 {
            margin: 0;
            color: #007bff;
            font-size: 24px;
        }

        .header p {
            margin: 5px 0;
            color: #666;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #dee2e6;
        }

        .stat-card h3 {
            margin: 0;
            color: #007bff;
            font-size: 20px;
        }

        .stat-card p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #333;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }

        .status-completed {
            color: #28a745;
            font-weight: bold;
        }

        .status-failed {
            color: #dc3545;
            font-weight: bold;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }

        @media print {
            body {
                margin: 0;
            }

            .header {
                page-break-after: avoid;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>TRAVELO</h1>
        <p>Laporan Manajemen Pembayaran</p>
        <p>Tanggal Cetak: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <div class="stats">
        <div class="stat-card">
            <h3>{{ $stats['total_payments'] }}</h3>
            <p>Total Transaksi</p>
        </div>
        <div class="stat-card">
            <h3 style="color: #28a745;">{{ $stats['completed_payments'] }}</h3>
            <p>Pembayaran Selesai</p>
        </div>
        <div class="stat-card">
            <h3 style="color: #ffc107;">{{ $stats['pending_payments'] }}</h3>
            <p>Menunggu Pembayaran</p>
        </div>
        <div class="stat-card">
            <h3 style="color: #28a745;">Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
            <p>Total Pendapatan</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Pembayaran</th>
                <th>Pemesanan</th>
                <th>Pengguna</th>
                <th>Maskapai</th>
                <th>Jumlah</th>
                <th>Metode</th>
                <th>Status</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($payments as $index => $payment)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $payment->payment_code }}</td>
                    <td>{{ $payment->booking->booking_code ?? 'N/A' }}</td>
                    <td>{{ $payment->booking->user->name ?? 'N/A' }}</td>
                    <td>{{ $payment->booking->flight->airline->name ?? 'N/A' }}</td>
                    <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                    <td>
                        <span class="status-{{ $payment->status }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                    <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: #666;">Tidak ada data pembayaran</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Travelo - Sistem Pemesanan Tiket Pesawat</p>
        <p>Laporan ini digenerate secara otomatis oleh sistem</p>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function () {
            window.print();
        }
    </script>
</body>

</html>