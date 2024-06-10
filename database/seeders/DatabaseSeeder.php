<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CalendarSeeder::class,
            RoleSeeder::class,
            RegionSeeder::class,
            CitySeeder::class,
            ProjectStatusSeeder::class,
            ProjectTypeSeeder::class,
            EquipmentTypeSeeder::class,
            CustomerSeeder::class,
            ProjectSeeder::class,
            EquipmentSeeder::class,
            TeamRankTypeSeeder::class,
            SettingSeeder::class,
            GmailsCredentialSeeder::class,
            AttractingTeamSeeder::class,
            ProjectTrainingTypeSeeder::class,
            RealestateTypeSeeder::class,
            TransactionHistorySeeder::class,
            UserSeeder::class,
        ]);
    }
}
