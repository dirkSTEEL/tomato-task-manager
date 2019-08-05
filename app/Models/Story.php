<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'take_days',
        'daily_task_list',
    ];
    
    // Relationships
    public function project_tasks()
    {
        return $this->hasMany('App\Models\ProjectTask');
    }
}
