<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
    ];
    
    // Relationships
    public function project_tasks()
    {
        return $this->hasMany('App\ProjectTask');
    }
}
