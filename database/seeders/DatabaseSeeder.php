<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use TelephoneBooks;
use Illuminate\Database\Eloquent\Factories\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         \App\Models\TelephoneBook::factory(100000)->create(); // php artisan db:seed
        //$this->call(TelephoneBookSeeder::class);
    }
}
