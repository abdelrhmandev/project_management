<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\GmailCredential;

class GmailsCredentialSeeder extends Seeder
{
        /**
         * Run the database seeds.
         *
         * @return void
         */
        public function run()
        {
                DB::table('gmails_credential')->delete();

                GmailCredential::create([
                        'email'            => 'noreply@al-fares.sa',
                        'password'         => 'ZWdNaGhIM0VXWA==',
                ]);
                 
        }
}
