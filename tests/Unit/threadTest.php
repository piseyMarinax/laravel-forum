<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;


class threadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }
    /** @test */
    public function test_a_thread_has_reply()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection',$this->thread->replies);
    }
    /** @test */
    public function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf('App\User',$this->thread->creator);
    }
    /** @test */
    public function test_a_thead_can_add_reply(Type $var = null)
    {
        $this->thread->addReply([
            'body'  => 'Foobar',
            'user_id' => 1
        ]);
        $this->assertCount(1,$this->thread->replies);
    }

}
