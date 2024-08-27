<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $created_at = date('Y-m-d H:i:s');

        DB::table('categories')->insert([
            ['name' => 'Mandatory', 'created_at' => $created_at, 'updated_at' => $created_at],
            ['name' => 'Optional', 'created_at' => $created_at, 'updated_at' => $created_at],
        ]);

        DB::table('question_types')->insert([
            ['name' => 'Single Answer', 'created_at' => $created_at, 'updated_at' => $created_at],
            ['name' => 'Multiple Answer', 'created_at' => $created_at, 'updated_at' => $created_at],
        ]);

        DB::table('training_type')->insert([
            ['name' => 'Quiz', 'created_at' => $created_at, 'updated_at' => $created_at],
            ['name' => 'Materi', 'created_at' => $created_at, 'updated_at' => $created_at],
        ]);

        DB::table('module_types')->insert([
            ['name' => 'All Employee', 'created_at' => $created_at, 'updated_at' => $created_at],
            ['name' => 'Assign by Trainer', 'created_at' => $created_at, 'updated_at' => $created_at],
        ]);
    }
}
