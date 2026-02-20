<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'recipes.stock']);

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        $products = $query->orderBy('name')->get();
        $stocks = Stock::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $selectedProduct = null;

        if ($products->isNotEmpty()) {
            $selectedProduct = $products->first();
        }

        return view('admin.recipes.index', compact('products', 'selectedProduct', 'stocks', 'categories'));
    }

    public function show(Product $product)
    {
        $products = Product::with(['category', 'recipes.stock'])->orderBy('name')->get();
        $stocks = Stock::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $selectedProduct = $product->load(['category', 'recipes.stock']);

        return view('admin.recipes.index', compact('products', 'selectedProduct', 'stocks', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'base_price' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable|string',
        ]);

        $data = [
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'base_price' => $validated['base_price'] ?? 0,
            'description' => $validated['description'] ?? '',
            'is_available' => true,
        ];

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($data);

        return response()->json([
            'success' => true,
            'product' => $product->load('category'),
            'message' => 'Produk berhasil dibuat!'
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'base_price' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'recipes' => 'sometimes|array',
            'recipes.*.stock_id' => 'required_with:recipes|exists:stocks,id',
            'recipes.*.amount_needed' => 'required_with:recipes|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($product, $validated, $request) {
                $updateData = [];
                if (isset($validated['name'])) $updateData['name'] = $validated['name'];
                if (isset($validated['category_id'])) $updateData['category_id'] = $validated['category_id'];
                
                if ($request->hasFile('image')) {
                    $updateData['image_path'] = $request->file('image')->store('products', 'public');
                }

                if (array_key_exists('base_price', $validated)) {
                    $updateData['base_price'] = $validated['base_price'];
                }
                if (array_key_exists('description', $validated)) {
                    $updateData['description'] = $validated['description'] ?? '';
                }
                
                if (!empty($updateData)) {
                    $product->update($updateData);
                }

                if (isset($validated['recipes'])) {
                    $product->recipes()->delete();

                    foreach ($validated['recipes'] as $recipeData) {
                        $product->recipes()->create($recipeData);
                    }
                }
            });

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'product' => $product->fresh()->load('category'),
                    'message' => 'Resep berhasil diperbarui!'
                ]);
            }

            return redirect()->back()->with('success', 'Resep berhasil diperbarui!');
        } catch (\Exception $e) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menyimpan resep: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menyimpan resep!');
        }
    }

    public function destroy(Product $product)
    {
        try {
            DB::transaction(function () use ($product) {
                $product->recipes()->delete();
                $product->delete();
            });

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Produk berhasil dihapus!'
                ]);
            }

            return redirect()->route('admin.recipes.index')->with('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus produk: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Gagal menghapus produk!');
        }
    }

    public function export()
    {
        $products = Product::with(['category', 'recipes.stock'])->get();
        
        $csvHeader = ['Product Name', 'Category', 'Base Price', 'Ingredient Name', 'Amount Needed', 'Unit'];
        $csvData = [];
        
        foreach ($products as $product) {
            if ($product->recipes->isEmpty()) {
                $csvData[] = [
                    $product->name,
                    $product->category->name ?? '',
                    $product->base_price,
                    '',
                    '',
                    ''
                ];
            } else {
                foreach ($product->recipes as $recipe) {
                    $csvData[] = [
                        $product->name,
                        $product->category->name ?? '',
                        $product->base_price,
                        $recipe->stock->name ?? '',
                        $recipe->amount_needed,
                        $recipe->stock->measure_unit ?? ''
                    ];
                }
            }
        }
        
        $filename = "recipes_export_" . date('Y-m-d_H-i-s') . ".csv";
        $handle = fopen('php://output', 'w');
        
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        fputcsv($handle, $csvHeader);
        foreach ($csvData as $row) {
            fputcsv($handle, $row);
        }
        
        fclose($handle);
        exit;
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt'
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        
        // Skip header
        fgetcsv($handle);
        
        $importedCount = 0;
        
        try {
            DB::transaction(function () use ($handle, &$importedCount) {
                while (($data = fgetcsv($handle)) !== FALSE) {
                    if (count($data) < 6) continue;
                    
                    [$productName, $categoryName, $basePrice, $stockName, $amountNeeded, $unit] = $data;
                    
                    if (empty($productName)) continue;

                    // Find or create category
                    $category = Category::firstOrCreate(['name' => $categoryName]);
                    
                    // Find or create product
                    $product = Product::firstOrCreate(
                        ['name' => $productName],
                        [
                            'category_id' => $category->id,
                            'base_price' => $basePrice ?: 0,
                            'is_available' => true
                        ]
                    );

                    if (!empty($stockName)) {
                        // Find stock
                        $stock = Stock::where('name', $stockName)->first();
                        
                        if ($stock) {
                            // If first time seeing this product in this import, clear its recipes
                            static $clearedProducts = [];
                            if (!isset($clearedProducts[$product->id])) {
                                $product->recipes()->delete();
                                $clearedProducts[$product->id] = true;
                            }

                            $product->recipes()->create([
                                'stock_id' => $stock->id,
                                'amount_needed' => $amountNeeded ?: 0
                            ]);
                        }
                    }
                    
                    $importedCount++;
                }
            });
            
            fclose($handle);
            return redirect()->back()->with('success', "Berhasil mengimpor data resep.");
        } catch (\Exception $e) {
            fclose($handle);
            return redirect()->back()->with('error', "Gagal mengimpor resep: " . $e->getMessage());
        }
    }
}
