<?php

namespace Tests\Unit;

use App\Project;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }



    function test_it_belongs_to_a_project(){
        $task = factory(Task::class)->create();
        $this->assertInstanceOf(Project::class, $task->project);
    }


    function test_it_path_(){
        $task= factory(Task::class)->create();
        $this->assertEquals("/project/{$task->project->id}/tasks/{$task->id}", $task->path());

    }
}
