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
        $this->withExceptionHanding();
        // $this->get('/threads/create')
        //     ->assertRedirect('/login');

            $this->post('/threads')
            ->assertRedirect('/login');
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
        $this->singIn();

        // Give we have a signed in user
        $this->actingAs(create('App\User'));

        // Then we hit the endpoit to create a new thread
        $thread = make('App\Thread');
        $response = $this->post('/threads',$thread->toArray());

        // Then, we vistion the thread page.
        $response = $this->get($response->headers->get('Location')) ;
        
        $response->assertSee($thread->title);
        $response->assertSee($thread->body);

    }

    function test_a_thread_require_a_title()
    {
        $this->publicThread(['title' => null])
        ->assertSessionHasErrors('title');
      
    }

    function test_a_thread_require_a_body()
    {
        $this->publicThread(['body' => null])
        ->assertSessionHasErrors('body');
      
    }

    function test_a_thread_require_a_channel()
    {
        factory('App\Channel',2)->create();

        $this->publicThread(['channel_id' => null])
        ->assertSessionHasErrors('channel_id');

         $this->publicThread(['channel_id' => 999])
        ->assertSessionHasErrors('channel_id');
      
    }

    function publicThread($override)
    {
        $this->withExceptionHanding()->singIn();
        $thread = make('App\Thread',$override);
       return $this->post('/threads',$thread->toArray());
        
    }
}
