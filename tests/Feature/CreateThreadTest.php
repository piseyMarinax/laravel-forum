<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadTest extends TestCase
{
    use RefreshDatabase;
/** @test */
    public function guest_may_not_create_a_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        // Then we hit the endpoit to create a new thread
        $thread = factory('App\Thread')->create();
        $this->post('/threads',$thread->toArray());
    }

    /** @test */
    public function test_an_authenticated_user_can_create_a_new_forum_thread()
    {
        // Give we have a signed in user
        $this->actingAs(factory('App\User')->create());

        // Then we hit the endpoit to create a new thread
        $thread = factory('App\Thread')->create();
        $this->post('/threads',$thread->toArray());

        // Then, we vistion the thread page.
        $response = $this->get($thread->path()) ;
        
        $response->assertSee($thread->title);
        $response->assertSee($thread->body);

    }
}
