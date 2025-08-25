<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                // categories → contactsの順に作成
                $this->call(CategorySeeder::class);

                \App\Models\Contact::factory()->count(35)->create();
    }
}
