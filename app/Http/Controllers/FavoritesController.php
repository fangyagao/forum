<?php

namespace App\Http\Controllers;

use App\Favorite;
use App\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller {

	/**
	 * FavoritesController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}


	/**
	 * @param \App\Reply $reply
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Reply $reply)
	{
		$reply->favorite();

		return back();
	}
}
