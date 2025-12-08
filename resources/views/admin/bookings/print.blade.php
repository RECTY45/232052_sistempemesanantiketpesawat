<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #111827; margin: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #2563eb; padding-bottom: 10px; margin-bottom: 16px; }
        .title { font-size: 18px; margin: 0; font-weight: bold; color: #2563eb; }
        .meta { color: #6b7280; margin: 2px 0 0 0; }
        .stats { display: grid; grid-template-columns: repeat(4, 1fr); gap: 10px; margin-bottom: 14px; }
        .card { border: 1px solid #e5e7eb; border-radius: 6px; padding: 10px; background: #f9fafb; }
        .card-title { margin: 0; font-size: 11px; color: #6b7280; }
        .card-value { margin: 4px 0 0 0; font-size: 16px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #e5e7eb; padding: 8px; text-align: left; }
        th { background: #f3f4f6; }
        .text-muted { color: #6b7280; }
        @media print {
            body { margin: 10px; }
            .header { page-break-after: avoid; }
            table { page-break-inside: auto; }
            tr { page-break-inside: avoid; page-break-after: auto; }
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <p class="title">{{ $title }}</p>
            <p class="meta">Dicetak pada {{ now()->format('d M Y H:i') }}</p>
        </div>
        <div class="meta">Total data: {{ $bookings->count() }}</div>
    </div>

    <div class="stats">
        <div class="card">
            <p class="card-title">Total Pemesanan</p>
            <p class="card-value">{{ $stats['total_bookings'] }}</p>
        </div>
        <div class="card">
            <p class="card-title">Dikonfirmasi</p>
            <p class="card-value">{{ $stats['confirmed_bookings'] }}</p>
        </div>
        <div class="card">
            <p class="card-title">Menunggu</p>
            <p class="card-value">{{ $stats['pending_bookings'] }}</p>
        </div>
        <div class="card">
            <p class="card-title">Dibatalkan</p>
            <p class="card-value">{{ $stats['cancelled_bookings'] }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Pemesan</th>
                <th>Rute</th>
                <th>Jadwal</th>
                <th>Penumpang</th>
                <th>Total</th>
                <th>Status</th>
                <th>Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $booking->booking_code }}</td>
                    <td>
                        <div>{{ $booking->user->name ?? '-' }}</div>
                        <div class="text-muted">{{ $booking->user->email ?? '-' }}</div>
                    </td>
                    <td>
                        {{ $booking->flight->departureAirport->code ?? '-' }} →
                        {{ $booking->flight->arrivalAirport->code ?? '-' }}
                        <div class="text-muted">{{ $booking->flight->flight_number ?? '' }}</div>
                    </td>
                    <td>
                        {{ optional($booking->flight->departure_time)->format('d M Y') ?? '-' }}
                        <div class="text-muted">
                            {{ optional($booking->flight->departure_time)->format('H:i') ?? '' }} -
                            {{ optional($booking->flight->arrival_time)->format('H:i') ?? '' }}
                        </div>
                    </td>
                    <td>{{ $booking->passengers_count }} orang</td>
                    <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($booking->status) }}</td>
                    <td>{{ $booking->created_at->format('d M Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <script>
        // Tampilkan dialog print otomatis seperti laporan pembayaran
        window.onload = function () {
            window.print();
        };
    </script>
</body>
</html>
