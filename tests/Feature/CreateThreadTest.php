<?php

namespace Tests\Feature;

use App\Activity;
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
    public function a_guest_cannot_see_the_create_thread_page()
    {
        // $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->withExceptionHanding()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_authenticated_user_can_create_a_new_forum_thread()
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
    function a_thread_require_a_title()
    {
        $this->publicThread(['title' => null])
        ->assertSessionHasErrors('title');
      
    }

    /** @test */
    function a_thread_require_a_body()
    {
        $this->publicThread(['body' => null])
        ->assertSessionHasErrors('body');
      
    }

    /** @test */
    function a_thread_require_a_channel()
    {
        factory('App\Channel',2)->create();

        $this->publicThread(['channel_id' => null])
        ->assertSessionHasErrors('channel_id');

         $this->publicThread(['channel_id' => 999])
        ->assertSessionHasErrors('channel_id');
      
    }

    /** @test */
    function an_unauthorizie_may_not_delete_thread()
    {

        $this->withExceptionHanding();

        $thread = create('App\Thread');

        $this->delete($thread->path())->assertRedirect('/login');

        $this->singIn();
        $this->delete($thread->path())->assertStatus(403);


    }

    /** @test */
    function authorize_a_thread_can_be_delete()
    {
        $this->singIn();

        $thread = create('App\Thread',['user_id' => auth()->id()]);
        $reply = create('App\Reply',['thread_id' => $thread->id]);

        $response = $this->json('DELETE',$thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads',['id' => $thread->id]);
        $this->assertDatabaseMissing('replies',['id' => $reply->id]);

        $this->assertEquals(0,Activity::count());

        $this->assertDatabaseMissing('activities',[
            'subject_id'    => $thread->id,
            'subject_type'  => get_class($thread)
        ]);
        $this->assertDatabaseMissing('activities',[
            'subject_id'    => $reply->id,
            'subject_type'  => get_class($reply)
        ]);

    }


    function publicThread($override)
    {
        $this->withExceptionHanding()->singIn();
        $thread = make('App\Thread',$override);
       return $this->post('/threads',$thread->toArray());
        
    }

}
