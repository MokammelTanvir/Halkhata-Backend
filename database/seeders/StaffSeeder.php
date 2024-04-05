<?php

namespace Database\Seeders;

use App\Models\User as Staff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffList = collect([
            [
                'name' => 'staff1',
                'phone' => '01610000001',
                'email' => 'staff1@inventory.com',
                'nid' => '0161-000-000-1',
                'address' => 'staff1 Address',
            ],
            [
                'name' => 'staff2',
                'phone' => '01610000002',
                'email' => 'staff2@inventory.com',
                'nid' => '0161-000-000-2',
                'address' => 'staff2 Address',
            ],
            [
                'name' => 'staff3',
                'phone' => '01630000003',
                'email' => 'staff3@inventory.com',
                'nid' => '0163-000-000-3',
                'address' => 'staff3 Address',
            ],
            [
                'name' => 'staff4',
                'phone' => '01640000004',
                'email' => 'staff4@inventory.com',
                'nid' => '0164-000-000-4',
                'address' => 'staff4 Address',
            ],
            [
                'name' => 'staff5',
                'phone' => '01650000005',
                'email' => 'staff5@inventory.com',
                'nid' => '0165-000-000-5',
                'address' => 'staff5 Address',
            ],
        ]);

        foreach ($staffList as $staff) {
            Staff::create([
                'role_id' => Staff::STAFF,
                'name' => $staff['name'],
                'phone' =>  $staff['phone'],
                'email' =>  $staff['email'],
                'nid' =>  $staff['nid'],
                'address' =>  $staff['address'],
                'password' => Hash::make(1234),
            ]);
        }
    }
}
