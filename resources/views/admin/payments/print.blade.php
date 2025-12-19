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

        /* Badge styling */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 5px;
            color: #fff;
            font-size: 12px;
        }

        .bg-primary { background-color: #0d6efd; }
        .bg-info { background-color: #0dcaf0; color: #fff; }
        .bg-warning { background-color: #ffc107; color: #fff; }
        .bg-success { background-color: #28a745; }
        .bg-secondary { background-color: #6c757d; }

        @media print {
            body { margin: 0; }
            .header { page-break-after: avoid; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
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
                    <td>
                        @if($payment->method === 'credit_card')
                            <span class="badge bg-primary">Kartu Kredit</span>
                        @elseif($payment->method === 'bank_transfer')
                            <span class="badge bg-info">Transfer Bank</span>
                        @elseif($payment->method === 'e_wallet')
                            <span class="badge bg-warning">E-Wallet</span>
                        @elseif($payment->method === 'cash')
                            <span class="badge bg-success">Cash</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($payment->method) }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="status-{{ $payment->status }}">
                            @if($payment->status === 'pending')
                                 <span class="badge bg-warning">Menunggu</span>
                            @elseif($payment->status === 'success')
                                 <span class="badge bg-success">Selesai</span>
                            @elseif($payment->status === 'failed')
                                 <span class="badge bg-danger">Gagal</span>
                            @else
                                 <span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
                            @endif
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