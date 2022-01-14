<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ManageProjectsTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    public function test_guests_cannot_create_project()
    {
        $attributes = factory('App\Project')->raw();

        $this->post('/project/store', $attributes)->assertRedirect('/login');
    }

    public function test_guests_cannot_view_create_page()
    {
        $this->get('/project/create')->assertRedirect('/login');
    }

    public function test_guests_may_not_view_projects()
    {
        $this->get('/projects')->assertRedirect('/login');
    }

    public function test_guests_cannot_view_a_single_project()
    {
        $project = factory('App\Project')->create();
        $this->get($project->path())->assertRedirect('/login');
    }

    public function test_a_user_can_create_a_project()
    {
        $this->withoutExceptionHandling();
        $this->actingAs(factory('App\User')->create());

        $this->get('/project/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker()->sentence(),
            'description' => $this->faker()->paragraph(),
        ];

        $this->post('/project/store', $attributes)->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $attributes);

        $this->get('/projects')->assertSee($attributes['title']);
    }

    public function test_a_project_requires_a_title()
    {
        $this->actingAs(factory('App\User')->create());

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/project/store', $attributes)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description()
    {
        $this->actingAs(factory('App\User')->create());
        $attributes = factory('App\Project')->raw(['description' => '']);
        $this->post('/project/store', $attributes)->assertSessionHasErrors('description');
    }

    public function test_a_user_can_view_thier_project()
    {
        $this->actingAs(factory('App\User')->create());
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())->assertSee($project->title)->assertSee($project->description);
    }

    public function test_an_unthenticated_user_cannot_view_the_project_of_others()
    {
        $this->actingAs(factory('App\User')->create());

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }
}
