<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User as Customer;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customerList = collect([
            [
                'name' => 'customer1',
                'phone' => '01810000001',
                'email' => 'customer1@inventory.com',
            ],
            [
                'name' => 'customer2',
                'phone' => '01810000002',
                'email' => 'customer2@inventory.com',
            ],
            [
                'name' => 'customer3',
                'phone' => '01830000003',
                'email' => 'customer3@inventory.com',
            ],
            [
                'name' => 'customer4',
                'phone' => '01840000004',
                'email' => 'customer4@inventory.com',
            ],
        ]);

        foreach ($customerList as $supplier) {
            Customer::create([
                'role_id' => Customer::CUSTOMER,
                'name' => $supplier['name'],
                'phone' =>  $supplier['phone'],
                'email' =>  $supplier['email'],
                'password' => Hash::make(1234),
            ]);
        }
    }
}
