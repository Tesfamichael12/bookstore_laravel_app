<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Import DB facade
use Carbon\Carbon; // Import Carbon for timestamps

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Truncate the books table before seeding
        \DB::table('books')->truncate();

        \DB::table('books')->insert([
            [
                'title' => 'Fikir Eske Mekabir',
                'author' => 'Haddis Alemayehu',
                'genre' => 'Novel',
                'cover_photo' => 'fikir_eske_mekabir.jpg',
                'published_year' => 1968,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Oromay',
                'author' => 'Bealu Girma',
                'genre' => 'Novel',
                'cover_photo' => 'oromay.jpg',
                'published_year' => 1983,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Tobbya',
                'author' => 'Gebreyesus Hailu',
                'genre' => 'Novel',
                'cover_photo' => 'tobbya.jpg',
                'published_year' => 1944,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Dertogada',
                'author' => 'Makonnen Endalkachew',
                'genre' => 'Drama',
                'cover_photo' => 'dertogada.jpg',
                'published_year' => 1932,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Ye Guzo Tizita',
                'author' => 'Sahle Sellassie',
                'genre' => 'Memoir',
                'cover_photo' => 'ye_guzo_tizita.jpg',
                'published_year' => 1970,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Adefris',
                'author' => 'Yismake Worku',
                'genre' => 'Novel',
                'cover_photo' => 'adefris.jpg',
                'published_year' => 2011,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'title' => 'Love Made in Addis',
                'author' => 'Hama Tuma',
                'genre' => 'Short Stories',
                'cover_photo' => 'love_made_in_addis.jpg',
                'published_year' => 2006,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
