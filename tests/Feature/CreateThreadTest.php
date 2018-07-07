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

    /** @test */
    function test_a_thread_require_a_title()
    {
        $this->publicThread(['title' => null])
        ->assertSessionHasErrors('title');
      
    }

    /** @test */
    function test_a_thread_require_a_body()
    {
        $this->publicThread(['body' => null])
        ->assertSessionHasErrors('body');
      
    }

    /** @test */
    function test_a_thread_require_a_channel()
    {
        factory('App\Channel',2)->create();

        $this->publicThread(['channel_id' => null])
        ->assertSessionHasErrors('channel_id');

         $this->publicThread(['channel_id' => 999])
        ->assertSessionHasErrors('channel_id');
      
    }

    /** @test */
    function guest_can_not_delete_the_thread()
    {

        $this->withExceptionHanding();

        $thread = create('App\Thread');

        $response = $this->delete($thread->path());

        $response->assertRedirect('/login');


    }

    /** @test */
    function thread_maybe_delete_who_will_have_permission()
    {

    }


    /** @test */
    function test_a_thread_can_be_delete()
    {
        $this->singIn();


        $thread = create('App\Thread');
        $reply = create('App\Reply',['thread_id' => $thread->id]);

        $response = $this->json('DELETE',$thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads',['id' => $thread->id]);
        $this->assertDatabaseMissing('replies',['id' => $reply->id]);

    }


    function publicThread($override)
    {
        $this->withExceptionHanding()->singIn();
        $thread = make('App\Thread',$override);
       return $this->post('/threads',$thread->toArray());
        
    }
}
