<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
   /** @test */
    public function it_has_a_path()
    {
        $project = factory('App\Project')->create();

        $this->assertEquals('/projects/'.$project->id, $project->path());
    }

    /** @test */

    public function it_should_have_an_owner()
    {
        $project = factory('App\Project')->create();

        $this->assertInstanceOf('App\User', $project->owner);
    }

    /** @test */

    public function a_project_should_add_a_task()
    {
        $this-> withoutExceptionHandling();

        $this->signIn();

        $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $task = $project->addTask('Test Task');

        $this->assertCount(1, $project->tasks);

        $this->assertTrue($project->tasks->contains($task));
    }
}
