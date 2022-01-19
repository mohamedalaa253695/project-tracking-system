<?php
namespace Tests\Feature;

use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class TriggerActivityTest extends TestCase
{
    use RefreshDatabase ;

    public function test_creating_a_project_triggers_activity()
    {
        // $this->withoutExceptionHandling();
        $project = app(ProjectFactory::class)->create() ;
        // dd($project->activity);

        $this->assertCount(1, $project->activity);
        // $this->assertEquals('created', $project->activity[0]->description);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created', $activity->description);
            $this->assertNull($activity->changes);
        });
    }

    public function test_updating_a_project_triggers_activity()
    {
        $this->withoutExceptionHandling();
        $project = app(ProjectFactory::class)->create();
        $originalTitle = $project->title;

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activity);

        tap($project->activity->last(), function ($activity) use ($originalTitle) {
            $this->assertEquals('updated', $activity->description);
            $expected = [
                'before' => ['title' => $originalTitle],
                'after' => ['title' => 'Changed']
            ];

            $this->assertEquals($expected, $activity->changes);
        });
    }

    public function test_creating_a_task_triggers_project_activity()
    {
        $project = app(ProjectFactory::class)->create();

        $project->addTask('Some task');
        // dd($project->activity);
        $this->assertCount(2, $project->activity);
        // $this->assertEquals('created_task', $project->activity->last()->description);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('created_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
            $this->assertEquals('Some task', $activity->subject->body);
        });
    }

    public function test_completing_a_task_triggers_project_activity()
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
        // $this->assertEquals('completed_task', $project->activity->last()->description);

        tap($project->activity->last(), function ($activity) {
            $this->assertEquals('completed_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
        });
    }

    public function test_incompleting_a_task_triggers_activity()
    {
        $project = app(ProjectFactory::class)->withTasks(1)->create();

        $this->actingAs($project->owner)
            ->patch($project->tasks[0]->path(), [
                'body' => 'foobar',
                'completed' => true
            ]);

        $this->assertCount(3, $project->activity);

        $this->patch($project->tasks[0]->path(), [
            'body' => 'foobar',
            'completed' => false
        ]);

        $project->refresh();

        $this->assertCount(4, $project->activity);

        $this->assertEquals('incompleted-task', $project->activity->last()->description);
    }
}
