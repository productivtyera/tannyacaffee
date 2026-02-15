<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Stock;
use App\Models\StockAdjustment;
use App\Models\StockActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Stock::query();

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%");
        }

        $stocks = $query->orderBy('name')->paginate(10)->withQueryString();
        
        $totalItems = Stock::count();
        $lowStockCount = Stock::whereRaw('current_stock <= min_stock_alert')->count();
        $totalValue = Stock::sum(DB::raw('current_stock * price_per_unit'));
        
        $recentActivities = StockActivity::with(['stock', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('admin.inventory.index', compact(
            'stocks',
            'totalItems',
            'lowStockCount',
            'totalValue',
            'recentActivities'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'measure_unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
            'current_stock' => 'required|numeric|min:0',
            'min_stock_alert' => 'required|numeric|min:0',
        ]);

        $stock = Stock::create($validated);

        StockActivity::create([
            'stock_id' => $stock->id,
            'user_id' => Auth::id(),
            'type' => 'created',
            'description' => "Menambahkan bahan baru: {$stock->name}",
            'changes' => $stock->toArray(),
        ]);

        return redirect()->back()->with('success', 'Bahan berhasil ditambahkan!');
    }

    public function show(Stock $stock)
    {
        return response()->json($stock);
    }

    public function update(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'measure_unit' => 'required|string|max:50',
            'price_per_unit' => 'required|numeric|min:0',
            'current_stock' => 'required|numeric|min:0',
            'min_stock_alert' => 'required|numeric|min:0',
        ]);

        $oldData = $stock->only(array_keys($validated));
        $stock->update($validated);
        $newData = $stock->only(array_keys($validated));

        $changes = [];
        foreach ($newData as $key => $value) {
            if ($value != $oldData[$key]) {
                $changes[$key] = [
                    'old' => $oldData[$key],
                    'new' => $value,
                ];
            }
        }

        if (!empty($changes)) {
            StockActivity::create([
                'stock_id' => $stock->id,
                'user_id' => Auth::id(),
                'type' => 'updated',
                'description' => "Memperbarui bahan: {$stock->name}",
                'changes' => $changes,
            ]);
        }

        return redirect()->back()->with('success', 'Bahan berhasil diperbarui!');
    }

    public function adjust(Request $request, Stock $stock)
    {
        $validated = $request->validate([
            'type' => 'required|in:in,out,waste',
            'amount' => 'required|numeric|min:0.01',
            'reason' => 'nullable|string|max:255',
        ]);

        $oldStock = $stock->current_stock;
        
        if ($validated['type'] === 'in') {
            $stock->current_stock += $validated['amount'];
        } else {
            $stock->current_stock -= $validated['amount'];
        }

        $stock->save();

        // Log to StockAdjustment
        StockAdjustment::create([
            'stock_id' => $stock->id,
            'user_id' => Auth::id(),
            'type' => $validated['type'],
            'amount' => $validated['amount'],
            'reason' => $validated['reason'],
        ]);

        // Log to StockActivity
        $typeLabel = $validated['type'] === 'in' ? 'Stok Masuk' : ($validated['type'] === 'waste' ? 'Waste' : 'Stok Keluar');
        StockActivity::create([
            'stock_id' => $stock->id,
            'user_id' => Auth::id(),
            'type' => 'adjustment',
            'description' => "Penyesuaian stok ({$typeLabel}): {$stock->name}",
            'changes' => [
                'type' => $validated['type'],
                'amount' => $validated['amount'],
                'old_stock' => $oldStock,
                'new_stock' => $stock->current_stock,
                'reason' => $validated['reason'],
            ],
        ]);

        return redirect()->back()->with('success', 'Stok berhasil disesuaikan!');
    }
}
