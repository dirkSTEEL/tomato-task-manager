<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Project;
use App\Models\Story;
use App\Models\ProjectTask;

class ProjectController extends Controller
{
    // Index
    public function index()
    {
        $projects = Project::all();
        return view('project.index', [
            'projects' => $projects
        ]);
    }

    // Manage Tasks page
    public function manage_tasks($id)
    {
        $project = Project::findOrFail($id);
        return view('project.arrange-tasks', [
            'project' => $project,
            'task_groups' => json_encode($project->task_groups)
        ]);
    }

    // Save Arranged Tasks
    public function arrange_tasks(Request $request, $id)
    {
        $this->validate($request, [
            'project_tasks.*.id' => [
                'required',
                'exists:project_tasks,id'
            ],
            'project_tasks.*.project_id' => [
                'required',
                Rule::in([$id]),
            ],
            'project_tasks.*.story_id' => [
                'nullable',
                'exists:stories,id'
            ],
            'project_tasks.*.name' => [
                'required',
                'max:45'
            ],
            'project_tasks.*.absolute_day' => [
                'required',
                'integer',
            ],
        ]);
        $project = Project::findOrFail($id);
        $project->project_tasks()->delete();
        foreach($request->project_tasks as $task){
            $project_task = new ProjectTask;
            $project_task->fill($task);
            $project_task->save();
        }
        return $project->task_groups;
    }
}
