<?php

namespace App\Http\Controllers;


use App\Thread;

class ReplyController extends Controller {

    //
	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * @param             $channelId
	 * @param \App\Thread $thread
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store($channelId, Thread $thread)
    {
    	$this->validate(request(), [
    		'body' => 'required'
		]);
		$thread->addReply([
			'body' => request('body'),
			'user_id' => auth()->id()
		]);

		return back()->with('flash', 'Your reply has been left.');
    }
}
