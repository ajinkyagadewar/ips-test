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

namespace Tests\Traits;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Event;

/**
 * A Trait is intended to reduce some limitations of single inheritance by 
 * enabling a developer to reuse sets of methods freely in several independent 
 * classes living in different class hierarchies. 
 */
trait ManageUsers
{
    /**
     * @param $userData
     * @param array $products
     * @return mixed
     */
    public function createTestUser($userData, Array $products)
    {
        $userRepository = app()->make(UserRepositoryInterface::class);
        Event::fake();
        $user = $userRepository->saveUser($userData, $products);
        return $user;
    }
}