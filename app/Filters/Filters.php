<?php

namespace App\Filters;

use Illuminate\Http\Request;

abstract class Filters
{

	/**
	 * @var \Illuminate\Http\Request
	 */
	protected $request, $builder;

	protected $filters = [];

	/**
	 * ThreadFilters constructor.
	 *
	 * @param \Illuminate\Http\Request $request
	 */
	public function __construct(Request $request)
	{

		$this->request = $request;
	}

	public function apply($builder)
	{
		$this->builder = $builder;

		foreach ($this->getFilters() as $filter => $value) {
			if (method_exists($this, $filter)) {
				$this->$filter($value);
			}
		}

		return $this->builder;
	}

	/**
	 * @return array
	 */
	protected function getFilters(): array
	{
		return $this->request->intersect($this->filters);
	}
}