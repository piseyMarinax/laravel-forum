<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_guests_can_not_favorite_anything()
    {
        $this->withExceptionHanding();
        $this->post('/replies/1/favorites')
            ->assertRedirect('/login');
    }

    /** @test */
    public function test_an_authenticated_user_can_favorite_any_reply()
    {
        // /threads/channel/id/replies/id/favorites
        // ***/replies/id/favorites
        // /replies/id/favorite
        // /favorites   <-- reply_id in the request

        $this->singIn();

        $reply = create('App\Reply');

        // if i post to a 'favorite' endpoint
        $this->post('/replies/'.$reply->id.'/favorites');


        // It should be recode in the database.
        $this->assertCount(1,$reply->favorites);

    }

    /** @test */
    public function test_an_authenticated_user_may_only_favorite_a_reply_once()
    {

        $this->singIn();

        $reply = create('App\Reply');

        try
        {
            // if i post to a 'favorite' endpoint
            $this->post('/replies/'.$reply->id.'/favorites');
            $this->post('/replies/'.$reply->id.'/favorites');

        }catch (\Exception $e)
        {
            $this->fail('Did not expect to insert the same recode set twice');
        }



        // It should be recode in the database.
        $this->assertCount(1,$reply->favorites);

    }
}
