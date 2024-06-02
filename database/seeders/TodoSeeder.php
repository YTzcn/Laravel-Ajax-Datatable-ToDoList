<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('todos')->insert([
            ['Title' => Str::random(10),
                'Content' => Str::random(10),
                'Status' => Str::random(10),
            ], ['Title' => Str::random(10),
                'Content' => Str::random(10),
                'Status' => Str::random(10),
            ], ['Title' => Str::random(10),
                'Content' => Str::random(10),
                'Status' => Str::random(10),
            ], ['Title' => Str::random(10),
                'Content' => Str::random(10),
                'Status' => Str::random(10),
            ], ['Title' => Str::random(10),
                'Content' => Str::random(10),
                'Status' => Str::random(10),
            ], ['Title' => Str::random(10),
                'Content' => Str::random(10),
                'Status' => Str::random(10),
            ], ['Title' => Str::random(10),
                'Content' => Str::random(10),
                'Status' => Str::random(10),
            ],]);
    }
}
