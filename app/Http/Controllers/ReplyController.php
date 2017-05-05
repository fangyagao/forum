<?php

namespace App\Http\Controllers;


use App\Thread;

class ReplyController extends Controller {

    //

	/**
	 * @param \App\Thread $thread
	 */
	public function store(Thread $thread)
    {
		$thread->addReply([
			'body' => request('body'),
			'user_id' => auth()->id()
		]);
    }
}
