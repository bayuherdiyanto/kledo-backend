<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::insert([
            'key' => 'overtime_method',
            'value' => '1',
            'expression' => '(salary / 173) * overtime_duration_total',
        ]);
    }
}
