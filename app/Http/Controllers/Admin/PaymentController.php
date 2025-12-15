<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['booking.user', 'booking.flight.airline']);

        // Filter by payment code
        if ($request->filled('payment_code')) {
            $query->where('payment_code', 'like', '%' . $request->payment_code . '%');
        }

        // Filter by payment method
        if ($request->filled('payment_method')) {
            $query->where('method', $request->payment_method);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate(10);

        // Statistics
        $stats = [
            'total_payments' => Payment::count(),
            'completed_payments' => Payment::where('status', 'success')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'total_revenue' => Payment::where('status', 'success')->sum('amount'),
        ];

        $title = 'Manajemen Pembayaran - Travelo Admin';

        return view('admin.payments.index', compact('payments', 'stats', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Admin tidak perlu create payment manual
        return redirect()->route('admin.payments.index')
            ->with('info', 'Pembayaran dibuat otomatis dari sistem pemesanan.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Admin tidak perlu create payment manual
        return redirect()->route('admin.payments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $payment->load([
            'booking.user',
            'booking.flight.airline',
            'booking.flight.departureAirport',
            'booking.flight.arrivalAirport',
            'booking.passengers'
        ]);

        $title = 'Detail Pembayaran #' . $payment->id . ' - Travelo Admin';

        return view('admin.payments.show', compact('payment', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        return redirect()->route('admin.payments.show', $payment)
            ->with('info', 'Gunakan aksi di halaman detail untuk mengubah status pembayaran.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,success,failed',
            'paid_at' => 'nullable|date',
            'notes' => 'nullable|string|max:500'
        ]);

        // If status is success and paid_at is provided, set it
        if ($validated['status'] === 'success' && $request->has('paid_at')) {
            $validated['paid_at'] = $request->paid_at;
        }

        // Update payment
        $payment->update($validated);

        // Update booking status based on payment status
        if ($validated['status'] === 'success') {
            $payment->booking->update(['status' => 'confirmed']);
        } elseif ($validated['status'] === 'failed') {
            $payment->booking->update(['status' => 'cancelled']);
        }

        $statusText = [
            'pending' => 'menunggu',
            'success' => 'selesai',
            'failed' => 'gagal'
        ];

        return redirect()->route('admin.payments.index')
            ->with('success', "Status pembayaran berhasil diubah menjadi {$statusText[$validated['status']]}!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        // Check if payment is completed
        if ($payment->status === 'success') {
            return redirect()->route('admin.payments.index')
                ->with('error', 'Pembayaran yang sudah selesai tidak dapat dihapus.');
        }

        $payment->delete();

        return redirect()->route('admin.payments.index')
            ->with('success', 'Data pembayaran berhasil dihapus!');
    }

    /**
     * Export payments to Excel
     */
    public function export(Request $request)
    {
        $query = Payment::with(['booking.user', 'booking.flight.airline']);

        // Apply same filters as index
        if ($request->filled('payment_code')) {
            $query->where('payment_code', 'like', '%' . $request->payment_code . '%');
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $payments = $query->orderBy('created_at', 'desc')->get();

        // Create CSV content with UTF-8 BOM for Excel compatibility
        $csvData = "\xEF\xBB\xBF"; // UTF-8 BOM
        $csvData .= "No,Kode Pembayaran,Pemesanan,Pengguna,Maskapai,Jumlah,Metode,Status,Tanggal\n";

        $index = 1;
        foreach ($payments as $payment) {
            $csvData .= sprintf(
                '"%d","%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                $index,
                $payment->payment_code,
                $payment->booking->booking_code ?? 'N/A',
                $payment->booking->user->name ?? 'N/A',
                $payment->booking->flight->airline->name ?? 'N/A',
                'Rp ' . number_format($payment->amount, 0, ',', '.'),
                ucfirst(str_replace('_', ' ', $payment->method)),
                ucfirst($payment->status),
                $payment->created_at->format('d/m/Y H:i')
            );
            $index++;
        }

        $fileName = 'laporan-pembayaran-' . date('Y-m-d-H-i-s') . '.csv';

        return response($csvData)
            ->header('Content-Type', 'text/csv; charset=utf-8')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    /**
     * Print payments report
     */
    public function print(Request $request)
    {
        $query = Payment::with(['booking.user', 'booking.flight.airline']);

        // Apply same filters as index
        if ($request->filled('payment_code')) {
            $query->where('payment_code', 'like', '%' . $request->payment_code . '%');
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $payments = $query->orderBy('created_at', 'desc')->get();

        // Statistics
        $stats = [
            'total_payments' => $payments->count(),
            'completed_payments' => $payments->where('status', 'success')->count(),
            'pending_payments' => $payments->where('status', 'pending')->count(),
            'total_revenue' => $payments->where('status', 'success')->sum('amount'),
        ];

        $title = 'Laporan Pembayaran - Travelo';

        return view('admin.payments.print', compact('payments', 'stats', 'title'));
    }
}
