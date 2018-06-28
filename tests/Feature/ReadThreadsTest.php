    <?php

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @property mixed thread
 */
class ThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $response = $this->get('/threads');
        $response->assertSee($this->thread->title);
    }
    /** @test */
    public function test_a_thread_can_make_string_path()
    {
       $thread = create('App\Thread');
       $this->assertEquals("/threads/{$thread->channel->slug}/{$thread->id}",$thread->path());
    }

    /** @test */
    public function a_user_can_view_a_threads()
    {
        $response = $this->get( $this->thread->path());
        $response->assertSee($this->thread->title);
    }

     /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        //Give we have a thread
        //And that thread include replies
        $reply = create('App\Reply',['thread_id' => $this->thread->id]);
        //We visite a thread
         $response = $this->get($this->thread->path());
        //Then we should see the replies
        $response->assertSee($reply->body);

    }

    /** @test */
    public function test_a_thread_belong_to_a_chanel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel', $thread->channel);
    }
}
