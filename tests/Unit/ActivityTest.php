<?php

namespace Tests\Feature;

use App\Activity;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_recodes_activity_when_a_thread_is_created()
    {

        $this->singIn();

        $thread = create('App\Thread');

//        $this->assertDatabaseHas('activities', [
//            'type' => 'create_thread',
//            'user_id' => auth()->id(),
//            'subject_id' => $thread->id,
//            'subject_type' => 'App\Thread'
//        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id,$thread->id);

    }

    /** @test */
    public function it_recodes_activity_when_a_reply_is_created()
    {
        $this->singIn();

        create('App\Reply');

        $this->assertEquals(2,Activity::count());
    }

    /** @test */
    public function it_fetches_a_feed_for_any_user()
    {

        $this->singIn();
        // Given we have a thread
        create('App\Thread',['user_id' => auth()->id()],2);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);
        // When we feed their feed

        $feed = Activity::feed(auth()->user());

        //Then, it should be return in the proper format.
        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));
    }
}
 