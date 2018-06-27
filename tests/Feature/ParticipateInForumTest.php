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
        $thread = factory('App\Thread')->create();

        // then user add a reply to the thread
        $reply = factory('App\Reply')->create();
        $this->post('/threads/'. $thread->id.'/replies',$reply->toArray());

    }

    /** @test */
    public function test_an_authenticated_user_may_participate_in_forum_thread()
    {
        // Given we have a authenticate user
 
        //    $user = factory('App\User')->create();
        $this->be($user = factory('App\User')->create());

        // And an existing thread
        $thread = factory('App\Thread')->create();

        // then user add a reply to the thread
        $reply = factory('App\Reply')->make();
        $this->post('/threads/'. $thread->id.'/replies',$reply->toArray());

        // Then their reply should visible on the page.
        $response = $this->get($thread->path());
        //Then we should see the replies
        $response->assertSee($reply->body);

    }
}
