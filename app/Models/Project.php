<?php

namespace App\Models;

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
        return $this->hasMany('App\Models\ProjectTask');
    }
    public function getStoriesAttribute()
    {
        $id = $this->id;
        return Story::select()->whereHas('project_tasks', function($query) use($id){
            $query->where('project_id', $id)->orderBy('absolute_day');
        })->with('project_tasks')->get()->sortBy('max(project_tasks.absolute_day)')->values()->all();
    }

    
    public function getTaskGroupsAttribute(){
        $tasks = $this->project_tasks->sortBy('absolute_day')->where('story_id', null)->values()->all();
        $stories = $this->stories;
        $result = collect();
        foreach($tasks as $task){
            $result->push([
                'standalone' => true,
                'start_day' => $task->absolute_day,
                'end_day' => $task->absolute_day,
                'task' => $task
            ]);
        }
        foreach($stories as $story){
            $result->push([
                'standalone' => false,
                'start_day' => $story->project_tasks->first()->absolute_day,
                'end_day' => $story->project_tasks->last()->absolute_day,
                'story' => $story
            ]);
        }
        return $result->sortBy('start_day')->values()->all();
    }
}
