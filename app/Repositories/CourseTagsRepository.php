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

use App\Http\Helpers\InfusionsoftHelper;
use App\Interfaces\CourseTagsRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ModuleRepositoryInterface;
use App\Models\CourseTag;
use App\Models\Tag;
use App\Models\User;

class CourseTagsRepository implements CourseTagsRepositoryInterface {
    
    /**
     * @var App\Http\Helpers\InfusionsoftHelper
     */
    public $infusionSoftHelper;
    
    /**
     * @var UserRepositoryInterface
     */
    public $userRepository;
    
    /**
     * @var ModuleRepositoryInterface
     */
    public $moduleRepository;
    
    public function __construct(InfusionsoftHelper $infusionSoftHelper, 
            UserRepositoryInterface $userRepository,
            ModuleRepositoryInterface $moduleRepository)
    {
        $this->infusionSoftHelper = $infusionSoftHelper;
        $this->userRepository = $userRepository;
        $this->moduleRepository = $moduleRepository;
    }
    
    /**
     * Create / Update all module tags into the database
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
    
    /**
     * Get the id of the tag to be set for a contact
     *
     * @param User $user
     * @param $contact
     * @return Tag
     */
    public function getModuleReminderTag(User $user, $contact)
    {
        // Convert the comma delimited string to an array
        $courses = explode(',', $contact['_Products']);
        $allPurchasedModules = $this->moduleRepository->getAllModulesInCourses($courses);
        $allCompletedModules = $this->moduleRepository->getCompletedModules($user);
        $nextModuleToRemind = $this->moduleRepository->getNextModuleToRemind($allCompletedModules, $allPurchasedModules);
        
        $courseTag = CourseTag::where('name', 'like', "%{$nextModuleToRemind}%")->first();
        return $courseTag;
    }
    
    /**
     * Set the Start Module reminder tag for a user.
     *
     * @param $email
     * @return mixed
     */
    public function setUserModuleReminderTag($email)
    {
        $contact = $this->userRepository->findContactByEmail($email);
        $user = $this->userRepository->findUserByEmail($email);
        
        $courseTag = $this->getModuleReminderTag($user, $contact);
        
        $this->infusionSoftHelper->addTag($contact['Id'], $courseTag->id);
        return $courseTag;
    }

}