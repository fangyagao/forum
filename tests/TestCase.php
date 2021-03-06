<?php

namespace Tests;

use App\Exceptions\Handler;
use Exception;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

	/**
	 * @var
	 */
	private $oldExceptionHandler;

	/**
	 *
	 */
	public function setUp()
	{
		parent::setUp();

		$this->disableExceptionHanding();
    }

	/**
	 * @param null $user
	 *
	 * @return $this
	 */
	public function signIn($user = null)
	{
		$user = $user ?: create('App\User');

		$this->actingAs($user);

		return $this;
	}

	/**
	 *
	 */
	protected function disableExceptionHanding()
	{
		$this->oldExceptionHandler = $this->app->make(ExceptionHandler::class);

		$this->app->instance(ExceptionHandler::class, new class extends Handler {
			public function __construct(){}
			public function report(Exception $e) {}
			public function render($request, Exception $e) {
				throw $e;
			}
		});
	}

	/**
	 * @return $this
	 */
	protected function withExceptionHanding()
	{
		$this->app->instance(ExceptionHandler::class, $this->oldExceptionHandler);

		return $this;
	}

}
