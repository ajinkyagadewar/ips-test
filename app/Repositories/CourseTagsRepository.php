<?php

/* 
 * Copyright (C) 2018 Ajeenckya Gadewar
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

namespace App\Repositories;
use App\Interfaces\CourseTagsRepositoryInterface;
use App\Http\Helpers\InfusionsoftHelper;
use App\Models\CourseTag;

class CourseTagsRepository implements CourseTagsRepositoryInterface {
    
    /**
     * @var App\Http\Helpers\InfusionsoftHelper
     */
    public $infusionSoftHelper;
    public function __construct(InfusionsoftHelper $infusionSoftHelper)
    {
        $this->infusionSoftHelper = $infusionSoftHelper;
    }
    
    /**
     * Create / Update all Start Module Reminder tags into the database
     * @inheritdoc
     * @return mixed
     */
    public function createOrUpdateTags(){
        $courseTags = $this->infusionSoftHelper->getAllTags()->toArray();
        
        foreach ($courseTags as $courseTag) {
            CourseTag::updateOrCreate([
                'id' => $courseTag['id'],
                'name' => $courseTag['name'],
                'description' => $courseTag['description']
            ]);
        }
        return $courseTags;
    }
}