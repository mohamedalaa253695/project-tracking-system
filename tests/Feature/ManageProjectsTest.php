<?php
namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Str;


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
        $this->signIn();

        $this->get('/project/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker()->sentence(),
            'description' => $this->faker->sentence(),
            'notes' => 'General notes here.'
        ];

       $response =  $this->post('/project/store', $attributes);

       $project = Project::where($attributes)->first();

       $response->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);

        $this->get($project->path())
            ->assertSee($attributes['title'])
            ->assertSee($attributes['description'])
            ->assertSee($attributes['notes']);
    }

    public function test_a_project_requires_a_title()
    {
        $this->signIn();

        $attributes = factory('App\Project')->raw(['title' => '']);

        $this->post('/project/store', $attributes)->assertSessionHasErrors('title');
    }

    public function test_a_project_requires_a_description()
    {
        
        $this->signIn();

        $attributes = factory('App\Project')->raw(['description' => '']);
        $this->post('/project/store', $attributes)->assertSessionHasErrors('description');
    }

    public function test_a_user_can_view_thier_project()
    {
        $this->withoutExceptionHandling();
        $this->signIn();
        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $this->get($project->path())->assertSee($project->title)->assertSee(Str::limit($project->description,100));
    }

    public function test_an_unthenticated_user_cannot_view_the_project_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    public function test_a_user_can_update_a_project()
    {
        $this->signIn();
        $this->withoutExceptionHandling();
        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);
        $this->patch($project->path() ,[
            'notes'=>'Changed'
        ])->assertRedirect($project->path());

        $this->assertDatabaseHas('projects' ,['notes' =>'Changed']);
    }

    public function test_an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->patch($project->path(), [])->assertStatus(403);
    }
}
