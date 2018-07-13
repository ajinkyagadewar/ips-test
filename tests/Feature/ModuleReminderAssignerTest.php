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

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Products;
use App\Models\User;
use Tests\Traits\ManageInfusionSoftHelper;
use Tests\Traits\ManageUsers;

class ModuleReminderAssignerTest extends TestCase
{
    use ManageUsers, ManageInfusionSoftHelper;
    
    /**
     * @var
     */
    public $user;
    /**
     * @var
     */
    public $mockContact;

    
    private static $moduleReminderAssignerUrl = 'api/module_reminder_assigner';
    
    public function setUp()
    {
        parent::setUp();
        $this->user = $this->createTestUser(factory(User::class)->make(), [
            Products::$IPHONE_EDITING_ACADEMY,
            Products::$IPHONE_PHOTO_ACADEMY,
            Products::$IPHONE_ART_ACADEMY
        ]);
        
        $this->mockContact = [
            "Email" => $this->user->email,
            "Groups" => 124,
            "_Products" => Products::$IPHONE_EDITING_ACADEMY . "," . 
            Products::$IPHONE_PHOTO_ACADEMY. "," . 
            Products::$IPHONE_ART_ACADEMY,
            "Id" => 134
        ];
    }
    
    /**
     * If no modules are completed it should attach first tag in order. 
     * In case any of first course modules are completed then it should 
     * attach next uncompleted module after the last completed of the 
     * first course.
     */

    public function testFirstModuleIfNoModuleIsCompleted()
    {
        $this->mockInfusionSoftHelper();
        $response = $this->post(self::$moduleReminderAssignerUrl, [
            'contact_email' => $this->user->email
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Start IEA Module 1 Reminders'
        ]);
    }

    public function testCorrectNextUncompletedModule()
    {
        $this->mockInfusionSoftHelper();
        $this->user->markModulesAsCompleted([
            Products::$IPHONE_EDITING_ACADEMY => [1, 2, 4],
            Products::$IPHONE_PHOTO_ACADEMY => [1, 3, 5, 6, 7]
        ]);
        $response = $this->post(self::$moduleReminderAssignerUrl, [
            'contact_email' => $this->user->email
        ]);
        
        $response->assertJson([
            'success' => true,
            'message' => 'Start IEA Module 5 Reminders'
        ]);
    }
    
   
   /**
    * If all (or last) first course modules are completed - attach next 
    * uncompleted module after the last completed of the second course. 
    * Same applies in case of a third course. 

    */ 
    public function testNextCourseModuleIfAllModulesCompleteInPreviousCourse()
    {
        $this->mockInfusionSoftHelper();
        $this->user->markModulesAsCompleted([
            Products::$IPHONE_EDITING_ACADEMY => [1, 2, 3, 4, 5, 6, 7],
            Products::$IPHONE_PHOTO_ACADEMY => [1, 3, 4],
            Products::$IPHONE_ART_ACADEMY => [1, 3, 4, 6],
        ]);
        $response = $this->post(self::$moduleReminderAssignerUrl, [
            'contact_email' => $this->user->email
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Start IPA Module 5 Reminders'
        ]);
    }

    
    /**
     * If all (or last) modules of all courses are completed - attach
     *  “Module reminders completed” tag.
     */
    public function testItTagsAsComplete()
    {
        
       $this->mockInfusionSoftHelper();
       
        $this->user->markModulesAsCompleted([
            Products::$IPHONE_EDITING_ACADEMY => [1, 2, 3, 4, 5, 6, 7],
            Products::$IPHONE_PHOTO_ACADEMY => [1, 2, 3, 4, 5, 6, 7],
            Products::$IPHONE_ART_ACADEMY => [1, 2, 3, 4, 5, 6, 7]
        ]);
        $response = $this->post(self::$moduleReminderAssignerUrl, [
            'contact_email' => $this->user->email
        ]);
        $response->assertJson([
            'success' => true,
            'message' => 'Module reminders completed'
        ]);
    }
}