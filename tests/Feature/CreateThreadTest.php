<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadTest extends TestCase
{
    use RefreshDatabase;
    
    /** @test */
    public function test_guest_may_not_create_a_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        // Then we hit the endpoit to create a new thread
        $thread = make('App\Thread');
        $this->post('/threads',$thread->toArray());
    }

     /** @test */
    public function test_guest_cannot_see_the_create_thread_page()
    {
        // $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withExceptionHanding()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function test_an_authenticated_user_can_create_a_new_forum_thread()
    {
        // Give we have a signed in user
        $this->actingAs(create('App\User'));

        // Then we hit the endpoit to create a new thread
        $thread = create('App\Thread');
        $this->post('/threads',$thread->toArray());

        // Then, we vistion the thread page.
        $response = $this->get($thread->path()) ;
        
        $response->assertSee($thread->title);
        $response->assertSee($thread->body);

    }
}
