// --- SISTEM PENGGUNA ---
Table users {
  id ulid [pk]
  username string[50]
  email string[255] [unique]
  password string[255]
  role enum // [admin, cashier, customer]
  is_admin bool
}

// --- MANAJEMEN STOK & BAHAN BAKU ---
Table stocks {
  id ulid [pk]
  name string[50]
  measure_unit enum // [g, ml, pcs, btl, kg, litter]
  price_per_unit float // Harga unit terkecil (hasil konversi)
  current_stock float // Sisa stok dalam angka (misal: 1500.5)
  min_stock_alert float // Batas bawah sebelum muncul peringatan
  updated_at timestamp
}

// Log jika ada bahan tumpah atau penambahan stok manual
Table stock_adjustments {
  id ulid [pk]
  stock_id ulid [ref: > stocks.id]
  user_id ulid [ref: > users.id]
  type enum // [in, out, waste]
  amount float
  reason text
  created_at timestamp
}

// --- MANAJEMEN PRODUK & RESEP ---
Table products {
  id ulid [pk]
  name string[100]
  category_id ulid [ref: > categories.id]
  base_price int // Harga jual ke pelanggan
  image_path string
  is_available bool [default: true] // Auto-false jika stok resep tak cukup
}

Table categories {
  id ulid [pk]
  name string[50]
}

// Pivot untuk HPP: Satu produk butuh banyak bahan
Table product_recipes {
  id ulid [pk]
  product_id ulid [ref: > products.id]
  stock_id ulid [ref: > stocks.id]
  amount_needed float // Misal: 10 (untuk 10g)
}

// --- SISTEM TRANSAKSI (KIOSK) ---
Table orders {
  id ulid [pk]
  order_number string [unique] // Contoh: TNY-20260214-001
  order_type enum // [takeaway, dine_in]
  status enum // [pending, paid, processing, completed, cancelled]
  payment_method enum // [cash, midtrans_qris, midtrans_bank]
  payment_status enum // [unpaid, paid]
  total_hpp int // Total biaya bahan saat transaksi (untuk profit/loss)
  total_price int // Total uang yang diterima dari user
  cashier_id ulid [ref: > users.id, note: "Kasir yang ACC manual"]
  created_at timestamp
}

Table order_items {
  id ulid [pk]
  order_id ulid [ref: > orders.id]
  product_id ulid [ref: > products.id]
  qty int
  unit_hpp int // HPP per item saat terjual
  unit_price int // Harga per item saat terjual
}