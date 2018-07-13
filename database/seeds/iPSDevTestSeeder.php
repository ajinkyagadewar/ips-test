<?php

use Illuminate\Database\Seeder;
use App\Models\Module;

class iPSDevTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 1; $i <= 7; $i++){
            Module::insert([
                [
                    'course_key' => 'ipa',
                    'module_no' => $i,
                    'name' => 'IPA Module ' . $i
                ],

                [
                    'course_key' => 'iea',
                    'module_no' => $i,
                    'name' => 'IEA Module ' . $i
                ],

                [
                    'course_key' => 'iaa',
                    'module_no' => $i,
                    'name' => 'IAA Module ' . $i
                ]
            ]);
        }


    }
}
