<?php
namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Setup\ProjectFactory;
use Tests\TestCase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_owners_may_not_invite_users()
    {
        $this->actingAs(factory(User::class)->create())
            ->post(app(ProjectFactory::class)->create()->path() . '/invitation/store')
            ->assertStatus(403);
        $project = app(ProjectFactory::class)->create();
        $user = factory(User::class)->create();

        $assertInvitationForbidden = function () use ($user, $project) {
            $this->actingAs($user)
                ->post($project->path() . '/invitation/store')
                ->assertStatus(403);
        };

        $assertInvitationForbidden();

        $project->invite($user);

        $assertInvitationForbidden();
    }

    public function test_a_project_owner_can_invite_a_user()
    {
        $project = app(ProjectFactory::class)->create();

        $userToInvite = factory(User::class)->create();

        $this->actingAs($project->owner)
            ->post($project->path() . '/invitation/store', [
                'email' => $userToInvite->email
            ])
            ->assertRedirect($project->path());

        $this->assertTrue($project->members->contains($userToInvite));
    }

    // TODO send an email to the user it not exist asking him to register to increase your users

    public function test_the_email_address_must_be_associated_with_a_valid_birdboard_account()
    {
        $project = app(ProjectFactory::class)->create();

        $this->actingAs($project->owner)
        ->post($project->path() . '/invitation/store', [
            'email' => 'example@example.com'
        ])
        ->assertSessionHasErrors([
            'email' => 'The user you are inviting must have a Birdboard account'
        ], null, 'invitations');
    }

    public function test_invited_users_may_update_project_details()
    {
        $project = app(ProjectFactory::class)->create();

        $project->invite($newUser = factory(User::class)->create());

        $this
            ->actingAs($newUser)
            ->post(action('ProjectTasksController@store', $project), $task = ['body' => 'Foo task']);

        $this->assertDatabaseHas('tasks', $task);
    }
}
