<?php
namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_a_path()
    {
        $project = factory('App\Project')->create();

        $this->assertEquals('/project/' . $project->id, $project->path());
    }

    public function test_it_belongs_to_an_owner()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf('App\User', $project->owner) ;
    }

    public function test_it_can_add_a_task()
    {
        $project = factory('App\Project')->create();

        $task = $project->addTask('Test task');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }

    public function test_it_can_invite_a_user()
    {
        $project = app(ProjectFactory::class)->create();
        $project->invite($user = factory(User::class)->create());
        $this->assertTrue($project->members->contains($user));
    }
}
