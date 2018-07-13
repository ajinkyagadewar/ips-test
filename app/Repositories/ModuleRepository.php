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

namespace App\Repositories;

use App\Interfaces\ModuleRepositoryInterface;
use App\Models\Course;
use App\Models\User;

class ModuleRepository implements ModuleRepositoryInterface
{
    /**
     * @var Course
     */
    public $course;
    
    /**
     * @var int
     */
    public static $modulesPerCourse = 7;
    public static $moduleRemindersCompletedTag = "reminders completed";

    
    public function __construct(Course $course)
    {
        $this->course = $course;
    }
    /**
     * Get an array of all the modules in a course
     *
     * @param string $courseKey
     * @return array
     */
    public function getAllModulesInCourse($courseKey)
    {
        return $this->course->getAllModules($courseKey);
    }
    
    /**
     * Get a multi dimensional array containing all modules across the 
     * courses
     * @param array $courseKeys
     * @return array
     */
    public function getAllModulesInCourses(array $courseKeys)
    {
        $allModules = [];
        foreach ($courseKeys as $courseKey) {
            $allModules[$courseKey] = $this->getAllModulesInCourse($courseKey);
        }
        return $allModules;
    }
    /**
     * Get all modules that the user has completed
     *
     * @param User $user
     * @return array
     */
    public function getCompletedModules(User $user)
    {
        $completedModules = $user->completed_modules()->get();
        
        $modules = [];
        foreach ($completedModules as $module) {
            if (!isset($modules[$module->course_key])) {
                $modules[$module->course_key] = [];
            }
            array_push($modules[$module->course_key], $module->module_no);
        }
        return $modules;
    }
    /**
     * @param array $completedModules
     * @param array $allCoursesModules
     * @return string
     */
    public function getNextModuleToRemind(array $completedModules = [], array $allCoursesModules = [])
    {
        $courses = array_keys($allCoursesModules);
        // Return the first module if no modules have been completed
        if ($this->hasNoCompletedModules($completedModules)) {
            $nextModule = "{$courses[0]} module 1";
            return $nextModule;
        }
        
        
        foreach ($courses as $course) {
            $uncompletedModules = array_diff($allCoursesModules[$course], $completedModules[$course]);
            
            // Continue to the next course if the current course is completed
            if($this->courseModulesCompleted($uncompletedModules)) {
                continue;
            } else {
                // Return the next uncompleted module after the last completed module
                $maxCompletedModule = max($completedModules[$course]);
                $nextUncompletedModule = $this->getNextUncompletedModule($maxCompletedModule, $uncompletedModules);
                $nextModule = "{$course} module {$nextUncompletedModule}";
                return $nextModule;
            }
        }
       
        return self::$moduleRemindersCompletedTag;
    }
    
    /**
     * Determine if a particular course fits our completed criteria
     * @param $uncompletedModules
     * @return bool
     */
    public function courseModulesCompleted($uncompletedModules)
    {
        return (empty($uncompletedModules) || !in_array(self::$modulesPerCourse, $uncompletedModules));
    }
    /**
     * @param $completedModules
     * @return bool
     */
    public function hasNoCompletedModules($completedModules)
    {
        return empty($completedModules);
    }
    /**
     * Find the next highest uncompleted module, after the highest completed module.
     *
     * @param $maxCompletedModule
     * @param $uncompletedModules
     * @return mixed
     */
    public function getNextUncompletedModule($maxCompletedModule, $uncompletedModules)
    {
        foreach ($uncompletedModules as $uncompletedModule) {
            if($uncompletedModule > $maxCompletedModule) {
                return $uncompletedModule;
            }
        }
    }
}