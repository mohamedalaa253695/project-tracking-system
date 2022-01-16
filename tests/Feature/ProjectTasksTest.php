<?php

namespace Tests\Feature;

use App\Project;
use App\Task;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_have_tasks(){

        // $this->withoutExceptionHandling();
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id'=>auth()->id()]);

        $this->post($project->path(). '/tasks' , ['body' => 'Test task']);

        $this->get($project->path())
            ->assertSee('Test task');


    }

    public function test_task_requires_a_body(){
        // $this->withoutExceptionHandling();
        $this->signIn();

        $project= factory(Project::class)->create(['owner_id' =>auth()->id()]);

        $attributes = factory(Task::class)->raw(['body' => '']);

        $this->post($project->path().'/tasks', $attributes)->assertSessionHasErrors('body');

    }

    public function test_only_the_owner_of_a_project_can_create_a_task(){
        
        $this->signIn();

        $project = factory(Project::class)->create();

        $this->post($project->path() .'/tasks' ,['body' =>"Test task"])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => "Test task"]);


    }

    public function test_only_the_owner_of_a_project_may_update_a_task(){
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = factory('App\Project')->create();
        $task = $project->addTask('test task');

        $this->patch($task->path(), ['body' => 'changed'])
            ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }


  public function test_a_task_can_be_updated(){
      $this->withoutExceptionHandling();
      $this->signIn();
      $project = auth()->user()->projects()->create(factory(Project::class)->raw());
      $task = $project->addTask('Test task');

      $this->patch($project->path(). '/tasks/' .$task->id ,[
          'body' =>'changed',
            'completed' => true
      ]);

      $this->assertDatabaseHas('tasks' ,[
          'body'=>'changed',
          'completed'=> true
      ]);
      
  }


}
