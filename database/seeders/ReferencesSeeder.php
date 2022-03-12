<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\References;

class ReferencesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        References::insert([
            'id' => 1,
            'code' => 'overtime_method',
            'name' => 'Salary / 173',
            'expression' => '(salary / 173) * overtime_duration_total',
        ]);

        References::insert([
            'id' => 2,
            'code' => 'overtime_method',
            'name' => 'Fixed',
            'expression' => '10000 * overtime_duration_total',
        ]);

        References::insert([
            'id' => 3,
            'code' => 'employee_status',
            'name' => 'Tetap',
            'expression' => '',
        ]);

        References::insert([
            'id' => 4,
            'code' => 'employee_status',
            'name' => 'Percobaan',
            'expression' => '',
        ]);
    }
}
