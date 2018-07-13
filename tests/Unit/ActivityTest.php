<?php

namespace Tests\Feature;

use App\Activity;
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
}
 