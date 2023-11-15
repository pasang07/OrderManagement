<?php

use Illuminate\Database\Seeder;

class SiteSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\DB::table('site_settings')->insert(
            array(
                array(
                    'title'=> 'Ordex',
                    'email'=> 'info@pocketstudionepal.com',
                    'currency_format' => 'USD $',
                    'product_type' => 'Bottles',
                    'product_format' => 'Volume [ML]',
                    'bank_details' => '<p>Bank Name: Sunrise Bank Ltd</p><p>Swift Code: SBLNPK</p><p>Address: Gairidhara, Kathmandu</p>',
                    'created_at'=> \Carbon\Carbon::now(),
                    'updated_at'=> \Carbon\Carbon::now(),
                ),
            ));
    }
}
