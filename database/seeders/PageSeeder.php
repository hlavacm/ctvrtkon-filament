<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run()
    {
        Page::factory()
            ->times(30)
            ->referenced()
            ->create();
    }
}
