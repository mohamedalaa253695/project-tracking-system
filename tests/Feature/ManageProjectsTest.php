<?php
namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\Setup\ProjectFactory;
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

    public function test_guests_cannot_update_project()
    {
        $project = app(ProjectFactory::class)->create();
        $this->get($project->path() . '/edit')->assertRedirect('/login');
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
        $this->signIn();

        $this->get('/project/create')->assertStatus(200);

        $attributes = [
            'title' => $this->faker()->sentence(),
            'description' => $this->faker->sentence(),
            'notes' => 'General notes here.'
        ];

        // $attributes = app(ProjectFactory::class)->create()->raw(['owner_id']);

        $response = $this->post('/project/store', $attributes);

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

        $this->get($project->path())->assertSee($project->title)->assertSee(Str::limit($project->description, 100));
    }

    public function test_an_unthenticated_user_cannot_view_the_project_of_others()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertStatus(403);
    }

    public function test_a_user_can_update_a_project()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
        ->patch($project->path(), $attributes = ['title' => 'Changed', 'description' => 'Changed', 'notes' => 'Changed'])
        ->assertRedirect($project->path());

        $this->assertDatabaseHas('projects', $attributes);
    }

    public function test_a_user_can_update_a_projects_general_notes()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->patch($project->path(), $attributes = ['notes' => 'Changed']);

        $this->assertDatabaseHas('projects', $attributes);
    }

    public function test_an_authenticated_user_cannot_update_the_projects_of_others()
    {
        $this->signIn();

        $project = app(ProjectFactory::class)->create();

        $this->patch($project->path())->assertStatus(403);
    }

    public function test_unauthorized_users_cannot_delete_projects()
    {
        // $this->withoutExceptionHandling();

        $project = app(ProjectFactory::class)->create();

        $this->delete($project->path())
            ->assertRedirect('/login');

        $user = $this->signIn();

        $this->delete($project->path())->assertStatus(403);

        $project->invite($user);

        $this->actingAs($user)->delete($project->path())->assertStatus(403);
    }

    /** @test */
    public function test_a_user_can_delete_a_project()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
            ->delete($project->path())
            ->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    public function testa_user_can_see_all_projects_they_have_been_invited_to_on_their_dashboard()
    {
        $project = tap(app(ProjectFactory::class)->create())->invite($this->signIn());

        $this->get('/projects')->assertSee($project->title);
    }

    public function test_tasks_can_be_included_as_part_a_new_project_creation()
    {
        $this->signIn();

        $attributes = factory(Project::class)->raw();
        // dd('here');
        $attributes['tasks'] = [
            ['body' => 'Task 1'],
            ['body' => 'Task 2']
        ];

        $this->post('/project/store', $attributes);

        $this->assertCount(2, Project::first()->tasks);
    }
}
