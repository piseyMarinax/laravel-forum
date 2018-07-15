    <?php

    use Tests\TestCase;
    use App\Filters\ThreadFilters;
    use Illuminate\Foundation\Testing\RefreshDatabase;

    /**
     * @property mixed thread
     */
    class ProfileTest extends TestCase
    {
        use RefreshDatabase;

        public function setUp()
        {
            parent::setUp();
            $this->user = create('App\User');
        }

        /** @test */
        public function a_user_has_a_profile()
        {
            $profileUser = create('App\User');
            $this->get('/profiles/'.$profileUser->name)
                ->assertSee($profileUser->name);
                
        }
        /** @test */
        public function display_all_threads_that_relate_to_user()
        {
            $profileUser = create('App\User');
            $thread = create('App\Thread',['user_id' => $profileUser->id]);
            $this->get('/profiles/'.$profileUser->name)
                ->assertSee($profileUser->name);
//                ->assertSee($thread->title)
//                ->assertSee($thread->body);

        }

    }
