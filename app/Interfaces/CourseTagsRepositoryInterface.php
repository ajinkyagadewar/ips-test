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

namespace App\Interfaces;

use App\Models\User;

interface CourseTagsRepositoryInterface
{
    /**
     * Create / Update all Start Module Reminder tags into the database
     *
     * @return mixed
     */
    public function createOrUpdateTags();
    
    /**
     * Get the id of the tag to be set for a contact
     *
     * @param User $user
     * @param $contact
     * @return Tag
     */
    public function getModuleReminderTag(User $user, $contact);
    
    /**
     * @param $email
     * @return mixed
     */
    public function setUserModuleReminderTag($email);
}