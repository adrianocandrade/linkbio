<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Clear existing plans to avoid duplicates or mixed states
        DB::table('plans')->delete();

        $now = Carbon::now();

        // 1. FREE FOREVER
        DB::table('plans')->insert([
            'name' => 'Free Forever',
            'slug' => 'free',
            'status' => 1,
            'is_default' => 0, // Set to 1 if you want this auto-assigned
            'position' => 0,
            'price_type' => 'free',
            'price' => json_encode([]),
            'settings' => json_encode([
                'blocks_limit' => 10,
                'pixel_limit' => 0,
                'workspaces_limit' => 1,
                'remove_branding' => 0,
                'custom_branding' => 0,
                'statistics' => 0,
                'verified_check' => 0,
                'pwa' => 0,
                'seo' => 0,
            ]),
            'extra' => json_encode([
                'description' => 'Perfect for getting started.',
                'featured' => 0
            ]),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. STARTER (R$ 9.90/mo)
        DB::table('plans')->insert([
            'name' => 'Starter',
            'slug' => 'starter',
            'status' => 1,
            'is_default' => 0,
            'position' => 1,
            'price_type' => 'paid',
            'price' => json_encode([
                'monthly' => 9.90,
                'annually' => 99.00
            ]),
            'settings' => json_encode([
                'blocks_limit' => 50,
                'pixel_limit' => 1,
                'workspaces_limit' => 3,
                'remove_branding' => 1,
                'custom_branding' => 0,
                'statistics' => 1,
                'verified_check' => 0,
                'pwa' => 0,
                'seo' => 1,
            ]),
            'extra' => json_encode([
                'description' => 'For growing creators.',
                'featured' => 0
            ]),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3. PRO (R$ 19.90/mo) - Featured
        DB::table('plans')->insert([
            'name' => 'Pro',
            'slug' => 'pro',
            'status' => 1,
            'is_default' => 0,
            'position' => 2,
            'price_type' => 'paid',
            'price' => json_encode([
                'monthly' => 19.90,
                'annually' => 199.00
            ]),
            'settings' => json_encode([
                'blocks_limit' => -1, // Unlimited
                'pixel_limit' => 5,
                'workspaces_limit' => 10,
                'remove_branding' => 1,
                'custom_branding' => 1,
                'statistics' => 1,
                'verified_check' => 1,
                'pwa' => 1,
                'seo' => 1,
            ]),
            'extra' => json_encode([
                'description' => 'Everything you need to scale.',
                'featured' => 1 // Highlight this plan
            ]),
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 4. AGENCY / VIP (R$ 49.90/mo)
        DB::table('plans')->insert([
            'name' => 'Agency',
            'slug' => 'agency',
            'status' => 1,
            'is_default' => 0,
            'position' => 3,
            'price_type' => 'paid',
            'price' => json_encode([
                'monthly' => 49.90,
                'annually' => 499.00
            ]),
            'settings' => json_encode([
                'blocks_limit' => -1,
                'pixel_limit' => -1,
                'workspaces_limit' => 50,
                'remove_branding' => 1,
                'custom_branding' => 1,
                'statistics' => 1,
                'verified_check' => 1,
                'pwa' => 1,
                'seo' => 1,
            ]),
            'extra' => json_encode([
                'description' => 'Power for professionals and agencies.',
                'featured' => 0
            ]),
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
