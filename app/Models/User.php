<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function completed_modules()
    {
        return $this->belongsToMany(Module::class, 'user_completed_modules');
    }
    
    /**
     * Get an array of module Names using course keys and numbers
     *
     * @param array $modules
     * @return array
     */
    public function getModuleNames(array $modules)
    {
        $moduleNames = [];
        
        foreach ($modules as $courseKey => $moduleNumbers) {
            
            foreach ($moduleNumbers as $moduleNumber) {
                array_push($moduleNames, strtoupper($courseKey)." Module {$moduleNumber}");
            }
        }
        return $moduleNames;
    }
    
    /**
     * @param array $modules
     */
    public function markModulesAsCompleted(array $modules)
    {
        $moduleNames = $this->getModuleNames($modules);
        $this->completed_modules()->attach(Module::whereIn('name', $moduleNames)->get());
    }
}
