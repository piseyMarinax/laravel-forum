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
//            $profileUser = create('App\User');
            $profileUser = $this->singIn();
            $this->get('/profiles/'.auth()->user()->name)
                ->assertSee(auth()->user()->name);
        }
        /** @test */
        public function profiles_display_all_threads_that_relate_to_user()
        {
            $this->singIn();

            $thread = create('App\Thread',['user_id' => auth()->id()]);
            $this->get('/profiles/'.auth()->user()->name)

                ->assertSee($thread->title)
                ->assertSee($thread->body);
        }

    }
