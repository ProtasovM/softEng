<?php

namespace Database\Seeders;

use App\Models\UserNote;
use Illuminate\Database\Seeder;

class UserNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserNote::factory()->count(1000)->create();
    }
}
