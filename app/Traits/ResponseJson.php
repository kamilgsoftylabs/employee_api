<?php

namespace App\Traits;

trait ResponseJson
{
	/**
	 * Return success.
	 */
	protected function success(string $message, array $data = [], int $status = 200)
	{
		return response([
			'success' => true,
			'data'    => $data,
			'message' => $message,
		], $status);
	}

	/**
	 * Return error.
	 */
	protected function error(string $message, int $status = 422)
	{
		return response([
			'success' => false,
			'message' => $message,
		], $status);
	}
}
