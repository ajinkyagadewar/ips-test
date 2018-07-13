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

interface ModuleRepositoryInterface
{
    /**
     * Get an array of all the modules in a course
     *
     * @param string $courseKey
     * @return array
     */
    public function getAllModulesInCourse($courseKey);
    
    /**
     * Get a multi dimensional array containing all modules across the 
     * courses
     *
     * @param array $courseKeys
     * @return array
     */
    public function getAllModulesInCourses(array $courseKeys);
    
    /**
     * Get all modules that the user has completed
     *
     * @param User $user
     * @return array
     */
    public function getCompletedModules(User $user);
    
    /**
     * @param array $completedModules
     * @param array $allCoursesModules
     * @return string
     */
    public function getNextModuleToRemind(array $completedModules, 
            array $allCoursesModules = []);
}