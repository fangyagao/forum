<?php

namespace App\Policies;

use App\Reply;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

	/**
	 * @param \App\User           $user
	 * @param \App\Policies\Reply $reply
	 *
	 * @return bool
	 */
	public function update(User $user, Reply $reply)
	{
		return $reply->user_id == $user->id;
    }
}
