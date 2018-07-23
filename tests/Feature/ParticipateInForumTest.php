<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_unauthenticated_may_not_add_reply()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        // And an existing thread
        $thread = create('App\Thread');

        // then user add a reply to the thread
        $reply = create('App\Reply');
        $this->post('/threads/some-channel/'. $thread->id.'/replies',$reply->toArray());

    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_thread()
    {
        // Given we have a authenticate user
 
        //    $user = factory('App\User')->create();
        $this->be($user = create('App\User'));

        // And an existing thread
        $thread = create('App\Thread');

        // then user add a reply to the thread
        $reply = create('App\Reply');
        $this->post("/threads/some-channel/". $thread->id.'/replies',$reply->toArray());

        // Then their reply should visible on the page.
        $response = $this->get($thread->path());
        //Then we should see the replies
        $response->assertSee($reply->body);

    }

     function a_reply_require_a_body()
    {
        $this->withExceptionHanding()->singIn();

        // And an existing thread
        $thread = create('App\Thread');
  
         // then user add a reply to the thread
        $reply = make('App\Reply',['body' => null]);
      
        $this->post($thread->path().'/replies',$reply->toArray())
            ->assertSessionHasErrors('body');
    }

    /** @test */
    function unauthorized_user_connot_delete_replies()
    {
        $this->withExceptionHanding();

        $reply = create('App\Reply');

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->singIn()
            ->delete("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_delete_reply()
    {
        $this->singIn();

        $reply = create('App\Reply',['user_id' => auth()->id()]);

        $this->delete("/replies/{$reply->id}")
            ->assertStatus(302);

        $this->assertDatabaseMissing('replies',['id' => $reply->id]);
    }

    /** @test */
    function authorized_users_can_update_reply()
    {
        $this->singIn();

        $reply = create('App\Reply',['user_id' => auth()->id()]);

        $updateBody = 'you have been change';

        $this->patch("/replies/{$reply->id}",[
            'body' => $updateBody
        ]);

        $this->assertDatabaseHas('replies',[
            'id' => $reply->id,
        'body'=>$updateBody ]
        );
    }

    /** @test */
    function unauthorized_user_connot_update_replies()
    {
        $this->withExceptionHanding();

        $reply = create('App\Reply');

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->singIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }


}
