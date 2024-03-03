<?php

namespace Database\Seeders;

use App\Models\Novels\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::create([
            'name' => 'Saint Fictions',
        ]);

        Genre::create([
            'name' => 'Psychology',
        ]);
    }
}
