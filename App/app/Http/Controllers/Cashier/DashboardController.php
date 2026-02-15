<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch orders based on status
        // Status flow: pending -> processing -> ready -> completed
        
        // Incoming Orders: Pending status (can be paid or unpaid)
        $incomingOrders = Order::where('status', 'pending')
            ->with(['items.product', 'cashier'])
            ->latest()
            ->get();

        // Processing Orders: Being prepared in kitchen
        $processingOrders = Order::where('status', 'processing')
            ->with(['items.product', 'cashier'])
            ->latest()
            ->get();

        // Ready Orders: Ready for pickup/delivery
        $readyOrders = Order::where('status', 'ready')
            ->with(['items.product', 'cashier'])
            ->latest()
            ->get();

        // Stats for footer
        $ordersToday = Order::whereDate('created_at', today())->where('status', 'completed')->count();
        $queueCount = Order::whereIn('status', ['pending', 'processing'])->count();
        $totalSales = Order::whereDate('created_at', today())->where('payment_status', 'paid')->sum('total_price');

        return view('cashier.dashboard', compact(
            'incomingOrders',
            'processingOrders',
            'readyOrders',
            'ordersToday',
            'queueCount',
            'totalSales'
        ));
    }
}
