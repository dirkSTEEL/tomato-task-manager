<?php

use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\Story;
use App\Models\ProjectTask;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // Seed projects table
        $json = file_get_contents( storage_path("data/projects.json") );
        $projects_data = json_decode($json);
        foreach ($projects_data as $obj) {
            Project::create(array(
                'id'    => $obj->id,
                'name'  => $obj->name,
            ));
        }

        // Seed stories table
        $json = file_get_contents( storage_path("data/stories.json") );
        $stories_data = json_decode($json);
        foreach ($stories_data as $obj) {
            Story::create(array(
                'id'                => $obj->id,
                'name'              => $obj->name,
                'take_days'         => $obj->take_days,
                'daily_tasks_list'  => json_encode($obj->daily_tasks_list),
            ));
        }

        // Seed project_tasks table
        $json = file_get_contents( storage_path("data/project_tasks.json") );
        $project_tasks_data = json_decode($json);
        foreach ($project_tasks_data as $obj) {
            ProjectTask::create(array(
                'id'            => $obj->id,
                'project_id'    => $obj->project_id,
                'absolute_day'  => $obj->absolute_day,
                'name'          => $obj->name,
                'story_id'      => $obj->story_id,
            ));
        }
    }
}
