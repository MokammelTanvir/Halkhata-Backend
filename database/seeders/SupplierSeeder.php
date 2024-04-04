<?php

namespace Database\Seeders;

use App\Models\User as Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supplierList = collect([
            [
                'name' => 'Supplier 1',
                'phone' => '01710000001',
                'email' => 'supplier1@inventory.com',
                'nid' => '2314526783',
                'address' => 'Dhaka, Bangladesh',
                'company_name' => 'Supplier 1 Company'
            ],
            [
                'name' => 'Supplier 2',
                'phone' => '01710000002',
                'email' => 'supplier2@inventory.com',
                'nid' => '2314526784',
                'address' => 'Dhaka, Bangladesh',
                'company_name' => 'Supplier 2 Company'
            ],
            [
                'name' => 'Supplier 3',
                'phone' => '01710000003',
                'email' => 'supplier3@inventory.com',
                'nid' => '2314526785',
                'address' => 'Dhaka, Bangladesh',
                'company_name' => 'Supplier 3 Company'
            ],
            [
                'name' => 'Supplier 4',
                'phone' => '01710000004',
                'email' => 'supplier4@inventory.com',
                'nid' => '2314526786',
                'address' => 'Dhaka, Bangladesh',
                'company_name' => 'Supplier 4 Company'
            ],

        ]);

        foreach ($supplierList as $supplier) {
            Supplier::create([
                'role_id' => Supplier::SUPPLIER,
                'name' => $supplier['name'],
                'phone' =>  $supplier['phone'],
                'email' =>  $supplier['email'],
                'nid' =>  $supplier['nid'],
                'address' =>  $supplier['address'],
                'company_name' =>  $supplier['company_name'],
                'password' => Hash::make(1234),
            ]);
        }
    }
}
