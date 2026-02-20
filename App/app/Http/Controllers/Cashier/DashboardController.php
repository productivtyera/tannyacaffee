<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch orders based on status
        // Status flow: pending -> processing -> ready -> completed
        
        // Incoming Orders: Pending status (can be paid or unpaid)
        $incomingOrders = Order::where('status', 'pending')
            ->where('cashier_id', Auth::id())
            ->with(['items.product', 'cashier'])
            ->latest()
            ->get();

        // Processing Orders: Being prepared in kitchen
        $processingOrders = Order::where('status', 'processing')
            ->where('cashier_id', Auth::id())
            ->with(['items.product', 'cashier'])
            ->latest()
            ->get();

        // Ready Orders: Ready for pickup/delivery
        $readyOrders = Order::where('status', 'ready')
            ->where('cashier_id', Auth::id())
            ->with(['items.product', 'cashier'])
            ->latest()
            ->get();

        // Stats for footer
        $ordersToday = Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->where('cashier_id', Auth::id())
            ->count();
            
        $queueCount = Order::whereIn('status', ['pending', 'processing'])
            ->where('cashier_id', Auth::id())
            ->count();
            
        $totalSales = Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->where('cashier_id', Auth::id())
            ->sum('total_price');

        // Generate initial state hash for polling
        $lastUpdate = Order::whereIn('status', ['pending', 'processing', 'ready'])
            ->where('cashier_id', Auth::id())
            ->latest('updated_at')
            ->value('updated_at');
        
        $counts = Order::selectRaw('status, count(*) as count')
            ->whereIn('status', ['pending', 'processing', 'ready'])
            ->where('cashier_id', Auth::id())
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $stateHash = md5(($lastUpdate ? $lastUpdate->timestamp : 0) . json_encode($counts));

        return view('cashier.dashboard', compact(
            'incomingOrders',
            'processingOrders',
            'readyOrders',
            'ordersToday',
            'queueCount',
            'totalSales',
            'stateHash'
        ));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,ready,completed',
        ]);

        $newStatus = $request->status;
        $currentStatus = $order->status;

        // Check payment status
        if ($order->payment_status !== 'paid') {
            return response()->json(['message' => 'Pesanan belum dibayar tidak dapat dipindahkan.'], 403);
        }

        // Define hierarchy
        $statusHierarchy = [
            'pending' => 1,
            'processing' => 2,
            'ready' => 3,
            'completed' => 4,
        ];

        if (!isset($statusHierarchy[$currentStatus]) || !isset($statusHierarchy[$newStatus])) {
             return response()->json(['message' => 'Status tidak valid.'], 400);
        }

        // Check if moving forward
        if ($statusHierarchy[$newStatus] <= $statusHierarchy[$currentStatus]) {
            return response()->json(['message' => 'Tidak dapat memindahkan ke status sebelumnya.'], 400);
        }
        
        // Prevent skipping steps? (Optional, but good for consistency)
        // If pending -> ready, is that allowed? Usually yes in Kanban, but let's stick to simple forward.
        // The user didn't explicitly forbid skipping, but "hierarchy" implies order.
        // Let's allow skipping for flexibility unless it breaks logic.
        
        $order->update([
            'status' => $newStatus,
            'cashier_id' => Auth::id(),
        ]);

        return response()->json(['message' => 'Status pesanan berhasil diperbarui.']);
    }

    public function checkNewOrders(Request $request)
    {
        $lastUpdate = Order::whereIn('status', ['pending', 'processing', 'ready'])
            ->where('cashier_id', Auth::id())
            ->latest('updated_at')
            ->value('updated_at');
        
        $counts = Order::selectRaw('status, count(*) as count')
            ->whereIn('status', ['pending', 'processing', 'ready'])
            ->where('cashier_id', Auth::id())
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $currentHash = md5(($lastUpdate ? $lastUpdate->timestamp : 0) . json_encode($counts));

        return response()->json([
            'should_reload' => $request->current_hash !== $currentHash,
            'new_hash' => $currentHash
        ]);
    }

    public function confirmPayment(Request $request, Order $order)
    {
        $amountPaid = $request->input('amount_paid');
        
        // Remove non-numeric characters if present (e.g. "Rp 10.000")
        if ($amountPaid) {
            $amountPaid = preg_replace('/\D/', '', $amountPaid);
        } else {
            // If not provided (e.g. QR), assume exact amount
            $amountPaid = $order->total_price;
        }

        $order->update([
            'payment_status' => 'paid',
            'amount_paid' => $amountPaid,
            'cashier_id' => Auth::id(),
        ]);

        return back()->with([
            'success' => 'Pembayaran berhasil dikonfirmasi.',
            'print_receipt_url' => route('cashier.orders.receipt', $order)
        ]);
    }

    public function processOrder(Order $order)
    {
        $order->update([
            'status' => 'processing',
            'cashier_id' => Auth::id(), // Ensure cashier is tracked
        ]);

        return back()->with('success', 'Pesanan sedang diproses.');
    }

    public function markReady(Order $order)
    {
        $order->update([
            'status' => 'ready',
        ]);

        return back()->with('success', 'Pesanan siap diambil/diantar.');
    }

    public function completeOrder(Order $order)
    {
        $order->update([
            'status' => 'completed',
        ]);

        return back()->with('success', 'Pesanan selesai.');
    }
}
