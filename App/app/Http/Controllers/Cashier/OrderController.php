<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('tab', 'active');
        $search = $request->get('search');

        $query = Order::query()
            ->with(['items.product', 'cashier'])
            ->where('cashier_id', Auth::id());

        if ($status === 'completed') {
            $query->whereIn('status', ['completed', 'cancelled']);
        } else {
            // Active orders: pending, processing, ready, paid (but not completed)
            // Wait, 'paid' might be a completed status if no processing needed, but usually 'completed' is the final state.
            // Based on previous controller logic:
            // Incoming: pending
            // Processing: processing
            // Ready: ready
            // So active includes all these.
            $query->whereIn('status', ['pending', 'processing', 'ready', 'paid']);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('table_number', 'like', "%{$search}%");
            });
        }

        $orders = $query->latest()->get();

        // Calculate stats
        $completedCount = Order::where('cashier_id', Auth::id())
            ->where('status', 'completed')
            ->whereDate('created_at', today())
            ->count();

        $activeCount = Order::where('cashier_id', Auth::id())
            ->whereIn('status', ['pending', 'processing', 'ready', 'paid'])
            ->count();

        $pendingPaymentCount = Order::where('cashier_id', Auth::id())
            ->where('payment_status', 'unpaid')
            ->where('status', '!=', 'cancelled')
            ->count();

        $totalSales = Order::where('cashier_id', Auth::id())
            ->where('payment_status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total_price');

        return view('cashier.orders.index', compact(
            'orders',
            'status',
            'completedCount',
            'activeCount',
            'pendingPaymentCount',
            'totalSales'
        ));
    }

    public function updateItemStatus(Request $request, OrderItem $item)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $item->update(['status' => $validated['status']]);

        // Check if all items are completed, maybe update order status?
        // For now, let's just update item status.
        
        return back()->with('success', 'Item status updated.');
    }

    public function checkUpdates(Request $request)
    {
        // Simple polling mechanism
        // Check for latest update timestamp on orders or order items
        
        $lastOrderUpdate = Order::where('cashier_id', Auth::id())
            ->latest('updated_at')
            ->value('updated_at');
            
        $lastItemUpdate = OrderItem::whereHas('order', function($q) {
                $q->where('cashier_id', Auth::id());
            })
            ->latest('updated_at')
            ->value('updated_at');

        $latest = max(
            $lastOrderUpdate ? $lastOrderUpdate->timestamp : 0,
            $lastItemUpdate ? $lastItemUpdate->timestamp : 0
        );

        $clientTimestamp = $request->get('timestamp', 0);

        if ($latest > $clientTimestamp) {
            return response()->json([
                'should_update' => true,
                'timestamp' => $latest
            ]);
        }

        return response()->json([
            'should_update' => false,
            'timestamp' => $latest
        ]);
    }
    
    public function printReceipt(Order $order)
    {
        // Return a view for printing, or just the data needed.
        // Usually opens a new window with print dialog.
        return view('cashier.orders.receipt', compact('order'));
    }
}
