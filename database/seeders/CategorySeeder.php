<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            "name" => "World",
            "description" => "World",
            "slug" => Str::slug("World"),
            "parent" => 0,
            "position" => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categories')->insert([
            "name" => "Zimbabwe",
            "description" => "Zimbabwe",
            "slug" => Str::slug("Zimbabwe"),
            "parent" => 0,
            "position" => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categories')->insert([
            "name" => "Companies",
            "description" => "Companies",
            "slug" => Str::slug("Companies"),
            "parent" => 0,
            "position" => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categories')->insert([
            "name" => "Technology",
            "description" => "Technology",
            "slug" => Str::slug("Technology"),
            "parent" => 0,
            "position" => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categories')->insert([
            "name" => "Markets",
            "description" => "Markets",
            "slug" => Str::slug("Markets"),
            "parent" => 0,
            "position" => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categories')->insert([
            "name" => "Climate",
            "description" => "Climate",
            "slug" => Str::slug("Climate"),
            "parent" => 0,
            "position" => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categories')->insert([
            "name" => "Opinion",
            "description" => "Opinion",
            "slug" => Str::slug("Opinion"),
            "parent" => 0,
            "position" => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('categories')->insert([
            "name" => "Work & Careers",
            "description" => "Work & Careers",
            "slug" => Str::slug("Work & Careers"),
            "parent" => 0,
            "position" => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

    }
}
