<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CustomerModeController extends Controller
{
    public function index()
    {
        // Get featured products (e.g., random 3 or specific ones)
        // For now, let's get 3 random available products
        $featuredProducts = Product::where('is_available', true)
            ->inRandomOrder()
            ->take(20)
            ->get();

        return view('customer.index', compact('featuredProducts'));
    }

    public function order()
    {
        $categories = Category::all();
        $products = Product::where('is_available', true)->with('category')->get();

        return view('customer.order', compact('categories', 'products'));
    }

    public function preCheckout(Request $request)
    {
        $request->validate([
            'cart' => 'required|array',
            'orderType' => 'required|in:dine_in,takeaway',
            'tableNumber' => 'required_if:orderType,dine_in',
        ]);

        session([
            'checkout_cart' => $request->cart,
            'checkout_orderType' => $request->orderType,
            'checkout_tableNumber' => $request->tableNumber,
        ]);

        return response()->json(['redirect' => route('customer.checkout')]);
    }

    public function checkout()
    {
        $cart = session('checkout_cart', []);
        $orderType = session('checkout_orderType', 'dine_in');
        $tableNumber = session('checkout_tableNumber', '');

        if (empty($cart)) {
            return redirect()->route('customer.order');
        }

        // Generate a draft order reference for display
        $orderRef = '#TNY-' . rand(100, 999);
        session(['checkout_orderRef' => $orderRef]);

        return view('customer.checkout', compact('cart', 'orderType', 'tableNumber', 'orderRef'));
    }

    public function store(Request $request)
    {
        $cart = session('checkout_cart', []);
        
        if (empty($cart)) {
            return redirect()->route('customer.order')->with('error', 'Keranjang kosong');
        }

        $request->validate([
            'payment_method' => 'required|in:midtrans_qris,cash',
        ]);

        $orderType = session('checkout_orderType', 'dine_in');
        $tableNumber = session('checkout_tableNumber', '');
        $orderRef = session('checkout_orderRef', '#TNY-' . rand(100, 999));
        
        // Use the order ref as part of the order number or just generate a new one
        // For consistency, let's use the one shown to the user if possible, but keep it unique
        $orderNumber = $orderRef . '-' . time();
        
        $totalPrice = 0;
        $totalHpp = 0;
        $orderItemsData = [];

        foreach ($cart as $item) {
            $product = Product::find($item['product']['id']);
            if ($product) {
                $qty = $item['quantity'];
                $price = $product->base_price;
                $hpp = $product->total_hpp ?? 0;
                
                $totalPrice += $price * $qty;
                $totalHpp += $hpp * $qty;
                
                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'unit_price' => $price,
                    'unit_hpp' => $hpp,
                ];
            }
        }

        $order = Order::create([
            'order_number' => $orderNumber,
            'order_type' => $orderType,
            'table_number' => $tableNumber,
            'status' => 'pending', 
            'payment_method' => $request->payment_method,
            'payment_status' => 'unpaid',
            'total_price' => $totalPrice,
            'total_hpp' => $totalHpp,
            'cashier_id' => Auth::id(),
        ]);

        foreach ($orderItemsData as $data) {
            $order->items()->create($data);
        }

        // Clear session
        session()->forget(['checkout_cart', 'checkout_orderType', 'checkout_tableNumber', 'checkout_orderRef']);

        return redirect()->route('customer.payment-process', ['order' => $order->id]);
    }

    public function paymentProcess(Order $order)
    {
        return view('customer.payment-process', compact('order'));
    }

    public function checkStatus(Order $order)
    {
        return response()->json([
            'status' => $order->status,
            'payment_status' => $order->payment_status,
        ]);
    }

    public function exit(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        if (!Hash::check($request->password, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'password' => ['Password yang Anda masukkan salah.'],
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('cashier.login');
    }
}
