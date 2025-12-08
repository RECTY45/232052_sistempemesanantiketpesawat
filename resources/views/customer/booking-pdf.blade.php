<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tiket {{ $booking->booking_code }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #1f2937;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            border-bottom: 2px solid #2563eb;
            padding-bottom: 12px;
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }
        .badge {
            padding: 6px 10px;
            border-radius: 4px;
            color: #fff;
            font-weight: bold;
            text-transform: uppercase;
        }
        .badge.confirmed { background: #16a34a; }
        .badge.pending { background: #f59e0b; }
        .badge.cancelled { background: #6b7280; }
        .section {
            margin-bottom: 14px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 12px;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin: 0 0 8px 0;
            color: #111827;
        }
        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px 16px;
        }
        .label { color: #6b7280; margin: 0; }
        .value { margin: 2px 0 10px 0; font-weight: 600; }
        .route {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 8px;
            padding: 10px;
            background: #f3f4f6;
            border-radius: 6px;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #e5e7eb;
            padding: 8px;
            text-align: left;
        }
        th {
            background: #f3f4f6;
        }
        .footer {
            margin-top: 18px;
            padding-top: 10px;
            border-top: 1px dashed #d1d5db;
            font-size: 11px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <p class="title">Tiket Penerbangan</p>
            <p style="margin: 2px 0 0 0; color: #6b7280;">Kode Booking: <strong>{{ $booking->booking_code }}</strong></p>
        </div>
        <div class="badge {{ $booking->status }}">{{ ucfirst($booking->status) }}</div>
    </div>

    <div class="section">
        <p class="section-title">Info Penerbangan</p>
        <div class="grid">
            <div>
                <p class="label">Maskapai</p>
                <p class="value">{{ $booking->flight->airline->name }}</p>
                <p class="label">Nomor Penerbangan</p>
                <p class="value">{{ $booking->flight->flight_number }}</p>
                <p class="label">Kelas</p>
                <p class="value">{{ $booking->flight_class_name }} Class</p>
            </div>
            <div>
                <p class="label">Tanggal Keberangkatan</p>
                <p class="value">{{ $booking->flight->departure_time->format('d M Y') }}</p>
                <p class="label">Waktu</p>
                <p class="value">{{ $booking->flight->departure_time->format('H:i') }} - {{ $booking->flight->arrival_time->format('H:i') }}</p>
                <p class="label">Total Penumpang</p>
                <p class="value">{{ $booking->passengers_count }} orang</p>
            </div>
        </div>
        <div class="route">
            <span>{{ $booking->flight->departureAirport->code }} - {{ $booking->flight->departureAirport->city }}</span>
            <span style="color:#2563eb;">&#9992;</span>
            <span>{{ $booking->flight->arrivalAirport->code }} - {{ $booking->flight->arrivalAirport->city }}</span>
        </div>
    </div>

    <div class="section">
        <p class="section-title">Penumpang</p>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Telepon</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach($booking->passengers as $index => $passenger)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $passenger->name }}</td>
                        <td>{{ $passenger->phone }}</td>
                        <td>{{ $passenger->email ?? '-' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="section">
        <p class="section-title">Pembayaran</p>
        <div class="grid">
            <div>
                <p class="label">Kode Pembayaran</p>
                <p class="value">{{ $booking->payment->payment_code ?? '-' }}</p>
                <p class="label">Metode</p>
                <p class="value">
                    {{ $booking->payment ? ucfirst(str_replace('_', ' ', $booking->payment->method)) : '-' }}
                </p>
            </div>
            <div>
                <p class="label">Jumlah</p>
                <p class="value">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</p>
                <p class="label">Status Pembayaran</p>
                <p class="value">{{ $booking->payment ? ucfirst($booking->payment->status) : 'Pending' }}</p>
            </div>
        </div>
    </div>

    <div class="footer">
        <p style="margin: 0;">Dicetak pada {{ now()->format('d M Y H:i') }} | Simpan tiket ini dan tunjukkan saat check-in.</p>
        <p style="margin: 4px 0 0 0;">Kontak layanan pelanggan: support@airline.com | +62-800-1234-5678</p>
    </div>
</body>
</html>
