<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bradList = collect([
            ['name' => 'Apple', 'code' => 101],
            ['name' => 'Samsung', 'code' => 102],
            ['name' => 'Xiaomi', 'code' => 103],
            ['name' => 'Oppo', 'code' => 104],
            ['name' => 'Vivo', 'code' => 105],
            ['name' => 'Nokia', 'code' => 106],
            ['name' => 'Huawei', 'code' => 107],
            ['name' => 'OnePlus', 'code' => 108],
            ['name' => 'Realme', 'code' => 109],
            ['name' => 'Sony', 'code' => 110]

        ]);

        foreach ($bradList as $brand) {
            Brand::create([
                'name' => $brand['name'],
                'slug' => Str::slug($brand['name']),
                'code' => $brand['code'],
            ]);
        }
    }
}
