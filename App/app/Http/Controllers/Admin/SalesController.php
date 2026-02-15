<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    public function index()
    {
        $orders = Order::with('items.product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Stats calculation
        $totalGrossSales = Order::sum('total_price');
        $totalOrders = Order::count();
        $averageOrderValue = $totalOrders > 0 ? $totalGrossSales / $totalOrders : 0;
        $totalNetProfit = Order::sum(DB::raw('total_price - total_hpp'));

        // For the live feed, get the latest 3 orders
        $liveSalesFeed = Order::with('items.product')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Popular products (mock for now, but could be derived from OrderItem)
        $popularProducts = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(order_items.qty) as total_qty'))
            ->groupBy('products.id', 'products.name')
            ->orderBy('total_qty', 'desc')
            ->take(2)
            ->get();

        return view('admin.sales.index', compact(
            'orders',
            'totalGrossSales',
            'averageOrderValue',
            'totalNetProfit',
            'liveSalesFeed',
            'popularProducts'
        ));
    }
}
