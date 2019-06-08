<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function a_project_can_have_tasks()
    {
        $this->withoutExceptionHandling();

        $this->signIn();

       $project =  auth()->user()->projects()->create(
            factory('App\Project')->raw()
        );

        $this->post($project->path().'/tasks', ['body' => 'Test Tasks']);

        $this->get($project->path())

             ->assertSee('Test Tasks');
    }
}
