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

	/** @test */
	public function unauthorized_users_cannot_delete_replies()
	{
		$this->withExceptionHanding();

		$reply = create('App\Reply');

		$this->delete('/replies/' . $reply->id)
			->assertRedirect('login');

		$this->signIn()
			->delete('/replies/' . $reply->id)
			->assertStatus(403);
	}

	/** @test */
	public function authorized_users_can_delete_replies()
	{
		$this->signIn();

		$reply = create('App\Reply', ['user_id' => auth()->id()]);

		$this->delete('/replies/' . $reply->id);

		$this->assertDatabaseMissing('replies', [
			'id' => $reply->id
		]);
	}

	/** @test */
	public function unauthorized_users_cannot_update_replies()
	{
		$this->withExceptionHanding();

		$reply = create('App\Reply');

		$this->patch('/replies/' . $reply->id)
			->assertRedirect('login');

		$this->signIn()
			->patch('/replies/' . $reply->id)
			->assertStatus(403);
	}

	/** @test */
	public function authorize_users_can_update_replies()
	{
		$this->signIn();

		$reply = create('App\Reply', ['user_id' => auth()->id()]);

		$updatedReply = 'You been changed, fool.';
		$this->patch('/replies/' . $reply->id, ['body' => $updatedReply]);

		$this->assertDatabaseHas('replies', [
			'id' => $reply->id,
			'body' => $updatedReply
		]);
	}
}
