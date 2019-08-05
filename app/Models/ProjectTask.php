<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id',
        'project_id',
        'absolute_day',
        'name',
        'story_id',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo('App\Models\Project');
    }
    public function story()
    {
        return $this->belongsTo('App\Models\Story');
    }
}
