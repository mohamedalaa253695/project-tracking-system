<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ActivityFeedTest extends TestCase
{
    use RefreshDatabase ;

    public function test_creating_a_project_records_activity()
    {
        // $this->withoutExceptionHandling();
        $project = app(ProjectFactory::class)->create() ;
        // dd($project->activity);

        $this->assertCount(1, $project->activity);
        $this->assertEquals('created', $project->activity[0]->description);
    }

    public function test_updating_a_project_records_activity()
    {
        $project = app(ProjectFactory::class)->create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);
        // dd($project->activity);
        $this->assertEquals('updated', $project->activity->last()->description);
    }

    public function test_creating_a_new_task_records_project_activity()
    {
        $project = app(ProjectFactory::class)->create();

        $project->addTask('Some task');
        // dd($project->activity);
        $this->assertCount(2, $project->activity);
        $this->assertEquals('created_task', $project->activity->last()->description);
    }

    public function test_completing_a_new_task_records_project_activity()
    {
        $this->refreshDatabase();
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        // dd($project->activity);

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);
        $this->assertEquals('completed_task', $project->activity->last()->description);
    }
}
