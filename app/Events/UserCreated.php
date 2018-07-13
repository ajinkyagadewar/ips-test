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

namespace App\Events;
use App\Models\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UserCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var App\Models\User
     */
    public $user;
    /**
     * @var Array
     */
    public $products;
    
    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param array $products
     */
    public function __construct(User $user, Array $products)
    {
        $this->user = $user;
        $this->products = $products;
    }
    
    /**
     * We've used the private channel as we want to restrict the event 
     * broadcast to logged-in users.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.'.$this->user);
    }
}

