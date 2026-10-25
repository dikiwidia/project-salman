<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['code' => 'PRD-0001', 'name' => 'Beras Premium 5kg', 'price' => 78000, 'expired_date' => '2027-10-25', 'supplier_name' => 'PT Sumber Pangan Makmur'],
            ['code' => 'PRD-0002', 'name' => 'Minyak Goreng 2L', 'price' => 36500, 'expired_date' => '2027-06-30', 'supplier_name' => 'PT Sawit Nusantara'],
            ['code' => 'PRD-0003', 'name' => 'Gula Pasir 1kg', 'price' => 17500, 'expired_date' => '2027-12-31', 'supplier_name' => 'PT Manis Jaya'],
            ['code' => 'PRD-0004', 'name' => 'Susu UHT Full Cream 1L', 'price' => 19900, 'expired_date' => '2027-03-15', 'supplier_name' => 'CV Segar Abadi'],
            ['code' => 'PRD-0005', 'name' => 'Mie Instan Goreng (Dus 40)', 'price' => 115000, 'expired_date' => '2027-05-20', 'supplier_name' => 'PT Indo Pangan Sejahtera'],
            ['code' => 'PRD-0006', 'name' => 'Kopi Bubuk 200g', 'price' => 28000, 'expired_date' => '2027-08-10', 'supplier_name' => 'CV Kopi Nusantara'],
            ['code' => 'PRD-0007', 'name' => 'Teh Celup (Isi 25)', 'price' => 8500, 'expired_date' => '2028-01-31', 'supplier_name' => 'PT Teh Wangi'],
            ['code' => 'PRD-0008', 'name' => 'Sabun Mandi Cair 450ml', 'price' => 32000, 'expired_date' => '2028-09-01', 'supplier_name' => 'PT Bersih Sentosa'],
            ['code' => 'PRD-0009', 'name' => 'Air Mineral 600ml (Dus 24)', 'price' => 48000, 'expired_date' => '2027-11-11', 'supplier_name' => 'PT Tirta Alam'],
            ['code' => 'PRD-0010', 'name' => 'Tisu Wajah 250 Lembar', 'price' => 15000, 'expired_date' => null, 'supplier_name' => 'CV Lembut Selalu'],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(['code' => $product['code']], $product);
        }
    }
}
