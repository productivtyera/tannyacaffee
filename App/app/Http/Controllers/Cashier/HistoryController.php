<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query()
            ->with(['items.product', 'cashier'])
            ->whereIn('status', ['completed', 'cancelled'])
            ->latest();

        // Search
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('cashier', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by date
        $filter = $request->get('filter', 'today');
        
        if ($filter === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($filter === 'week') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter === 'month') {
            $query->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        }

        $orders = $query->paginate(10);
        
        // Calculate stats for the view
        // Re-build query for stats to avoid pagination limit
        $statsQuery = Order::query()
            ->whereIn('status', ['completed', 'cancelled']);
            
        if ($search = $request->get('search')) {
            $statsQuery->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('cashier', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($filter === 'today') {
            $statsQuery->whereDate('created_at', today());
        } elseif ($filter === 'week') {
            $statsQuery->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($filter === 'month') {
            $statsQuery->whereMonth('created_at', now()->month)
                  ->whereYear('created_at', now()->year);
        }

        $totalTransactions = $statsQuery->count();
        $totalRevenue = $statsQuery->sum('total_price');

        return view('cashier.history.index', compact('orders', 'filter', 'totalTransactions', 'totalRevenue'));
    }
}
