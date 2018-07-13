<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * @var array
     */
    protected $hidden = ['pivot'];
    
    public function getNameAttribute($value) {
        return strtolower($value);
    }
}
