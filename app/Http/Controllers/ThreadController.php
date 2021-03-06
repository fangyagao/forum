<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Thread;
use App\Filters\ThreadFilters;
use App\User;
use Illuminate\Http\Request;

class ThreadController extends Controller
{

	/**
	 * ThreadController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth')->except(['index', 'show']);
	}


	/**
	 * Display a listing of the resource.
	 *
	 * @param \App\Channel                                  $channel
	 * @param \App\Filters\ThreadFilters
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function index(Channel $channel, ThreadFilters $filters)
    {
        //
		$threads = $this->getThreads($channel, $filters);

		if (request()->wantsJson()) {
			return $threads;
		}

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$this->validate($request, [
    		'title' => 'required',
    		'body' => 'required',
    		'channel_id' => 'required|exists:channels,id',
		]);
        //
		$thread = Thread::create([
			'user_id' => auth()->id(),
			'channel_id' => request('channel_id'),
			'title' => request('title'),
			'body' => request('body')
		]);

		return redirect($thread->path())
			->with('flash', 'Your thread has been published.');
    }

	/**
	 * Display the specified resource.
	 *
	 * @param              $channel
	 * @param  \App\Thread $thread
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function show($channel, Thread $thread)
    {
        //
        return view('threads.show', [
        	'thread' => $thread,
			'replies' => $thread->replies()->paginate(15)
		]);
    }

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param              $channelId
	 * @param  \App\Thread $thread
	 *
	 * @return \Illuminate\Http\Response
	 */
    public function destroy($channel, Thread $thread)
    {
        //
		$this->authorize('update', $thread);
		if($thread->user_id != auth()->id()) {
			abort(403, 'You do not have permission to do this.');
		}
		$thread->delete();

		if(request()->wantsJson()) {
			return response([], 204);
		}

		return redirect('/threads');
    }

	/**
	 * @param \App\Channel               $channel
	 * @param \App\Filters\ThreadFilters $filters
	 *
	 * @return mixed
	 */
	protected function getThreads(Channel $channel, ThreadFilters $filters)
	{
		$threads = Thread::latest()->filter($filters);

		if ($channel->exists)
		{
			$threads->where('channel_id', $channel->id);
		}

		return $threads->get();
	}
}
