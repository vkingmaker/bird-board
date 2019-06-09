<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Psy\CodeCleaner\AssignThisVariablePass;
use Facades\Tests\Setup\ProjectFactory;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function guest_cannot_add_tasks_to_projects()
    {
        $project = factory('App\Project')->create();

        $this->post($project->path().'/tasks')->assertRedirect('/login');
    }

    /** @test */

    public function only_the_owner_of_a_project_can_add_tasks()
    {
        $this->signIn();

        $project = factory('App\Project')->create();

        $this->post($project->path().'/tasks', ['body' => 'Test Tasks'])

             ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'Test Tasks']);
    }

    /** @test */

    public function only_the_owner_of_a_project_can_update_a_tasks()
    {
        // $this->withoutExceptionHandling();

        $this->signIn();

        $project = ProjectFactory::withTask(1)->create();

        $this->patch($project->tasks[0]->path(), ['body' => 'changed'])

             ->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'changed']);
    }

    /** @test */

    public function a_project_can_have_tasks()
    {
        $this->signIn();

        $project =  auth()->user()->projects()->create(

           factory('App\Project')->raw()

        );

        $this->post($project->path().'/tasks', ['body' => 'Test Tasks']);

        $this->get($project->path())

             ->assertSee('Test Tasks');
    }


    /** @test */

    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();


        $project = ProjectFactory::withTask(1)->create();

        $this->actingAs($project->owner)->patch($project->tasks->first()->path(), [

            'body' => 'Changed task',

            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks',[

            'body' => 'Changed task',

            'completed' => true

        ]);
    }

    /** @test */

    public function a_task_requires_a_body()
    {
        $project = ProjectFactory::create();

        $attributes = factory('App\Task')->raw(['body' => '']);

        $this->actingAs($project->owner)

                ->post($project->path().'/tasks', $attributes)

                ->assertSessionHasErrors('body');
    }
}
