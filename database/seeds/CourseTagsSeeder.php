<?php

/* 
 * Copyright (C) 2018 ajeenckyagadewar
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

use App\Models\CourseTag;
use Illuminate\Database\Seeder;

class CourseTagsSeeder extends Seeder
{
    private static $tags = [
        [
            "id" => 110,
            "name" => 'Start IPA Module 1 Reminders'
        ],
        [
            "id" => 112,
            "name" => 'Start IPA Module 2 Reminders'
        ],
        [
            "id" => 114,
            "name" => 'Start IPA Module 3 Reminders'
        ],
        [
            "id" => 116,
            "name" => 'Start IPA Module 4 Reminders'
        ],
        [
            "id" => 118,
            "name" => 'Start IPA Module 5 Reminders'
        ],
        [
            "id" => 120,
            "name" => 'Start IPA Module 6 Reminders'
        ],
        [
            "id" => 122,
            "name" => 'Start IPA Module 7 Reminders'
        ],
        [
            "id" => 124,
            "name" => 'Start IEA Module 1 Reminders'
        ],
        [
            "id" => 126,
            "name" => 'Start IEA Module 2 Reminders'
        ],
        [
            "id" => 128,
            "name" => 'Start IEA Module 3 Reminders'
        ],
        [
            "id" => 130,
            "name" => 'Start IEA Module 4 Reminders'
        ],
        [
            "id" => 132,
            "name" => 'Start IEA Module 5 Reminders'
        ],
        [
            "id" => 134,
            "name" => 'Start IEA Module 6 Reminders'
        ],
        [
            "id" => 136,
            "name" => 'Start IEA Module 7 Reminders'
        ],
        [
            "id" => 138,
            "name" => 'Start IAA Module 1 Reminders'
        ],
        [
            "id" => 140,
            "name" => 'Start IAA Module 2 Reminders'
        ],
        [
            "id" => 142,
            "name" => 'Start IAA Module 3 Reminders'
        ],
        [
            "id" => 144,
            "name" => 'Start IAA Module 4 Reminders'
        ],
        [
            "id" => 146,
            "name" => 'Start IAA Module 5 Reminders'
        ],
        [
            "id" => 148,
            "name" => 'Start IAA Module 6 Reminders'
        ],
        [
            "id" => 150,
            "name" => 'Start IAA Module 7 Reminders'
        ],
        [
            "id" => 154,
            "name" => 'Module reminders completed'
        ]
    ];
    /**
     * Database seeder
     *
     * @return void
     */
    public function run()
    {
        foreach(self::$tags as $tag) {
            CourseTag::insert([
                'id' => $tag['id'],
                'name' => $tag['name']
            ]);
        }
    }
}