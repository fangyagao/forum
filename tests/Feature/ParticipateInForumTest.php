<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForumTest extends TestCase
{
	use DatabaseMigrations;
	
	/**	@test */
	public function unauthenticated_users_may_not_add_replies()
	{
		$this->withExceptionHanding()
			->post('threads/some-channel/1/replies', [])
			->assertRedirect('login');
	}

    /** @test */
	public function an_authenticated_user_may_participate_in_forum_threads()
	{
		$this->be(factory('App\User')->create());

		$thread = factory('App\Thread')->create();

		$reply = factory('App\Reply')->make();
		$this->post($thread->path() .'/replies', $reply->toArray());

		$this->get($thread->path())
			->assertSee($reply->body);
    }

	/** @test */
	public function a_reply_requires_a_body()
	{
		$this->withExceptionHanding()->signIn();

		$thread = factory('App\Thread')->create();
		$reply = factory('App\Reply')->make(['body' => null]);

		$this->post($thread->path() .'/replies', $reply->toArray())
			->assertSessionHasErrors('body');
	}
}
