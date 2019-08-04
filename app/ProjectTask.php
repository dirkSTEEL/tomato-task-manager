<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectTask extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'name',
        'absolute_day',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo('App\Project');
    }
    public function story()
    {
        return $this->belongsTo('App\Story');
    }
}
