<?php

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
        //< ORDINE IMPORTANTE QUANDO HO RELAZIONI TRA LE CLASSI: 
        //< PRIMA LE ENTITA' FORTI E DOPO LE DEBOLI
        $this->call([CategorySeeder::class, UserSeeder::class, PostSeeder::class]);
    }
}
