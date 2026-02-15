<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
            ->take(3)
            ->get();

        return view('customer.index', compact('featuredProducts'));
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
