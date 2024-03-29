<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::create([
            'site_name' => 'Halkhata Inventory',
            'site_logo' => 'logo.png',
            'site_favicon' => 'favicon.png',
            'site_email' => 'info@halkhata.com',
            'site_phone' => '01712345678',
            'site_address' => 'Dhaka, Bangladesh',
            'site_description' => 'Inventory Management System',
            'site_facebook_link' => 'https://www.facebook.com/',
            'site_twitter_link' => 'https://www.twitter.com/',
            'site_instagram_link' => 'https://www.instagram.com/',
            'meta_title' => 'Halkhata Inventory',
            'meta_description' => 'Inventory Management System',
            'meta_keywords' => 'inventory, management, system, POS',

        ]);
    }
}
