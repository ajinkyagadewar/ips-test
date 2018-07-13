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

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Traits\ManageUsers;
use App\Http\Helpers\InfusionsoftHelper;
use App\Models\Products;
use App\Models\User;

class UserCreationTest extends TestCase
{
    use ManageUsers;
    
    /**
     * Test to ensure that the saveUser functionality will be working as 
     * expected by checking whether the test database reflects appropriate 
     * entries
     */
    public function testItCreatesAUserAndInfusionSoftContact()
    {
        $products = [
            Products::$IPHONE_ART_ACADEMY,
            Products::$IPHONE_EDITING_ACADEMY
        ];
        
        $userData = factory(User::class)->make();
        $infusionSoftHelper = $this->mock(InfusionsoftHelper::class);
        $infusionSoftHelper->shouldReceive('createContact')
            ->with([
                'Email' => $userData->email,
                '_Products' => "iaa,iea"
            ])
            ->once();
        
        $user = $this->createTestUser($userData, $products);
        
        $this->assertDatabaseHas('users', [
           'email' => $user->email
        ]);
    }
}