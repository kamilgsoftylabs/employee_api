<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Jekk0\laravel\Iso3166\Validation\Rules\Iso3166Alpha2;

class CreateEmployeeDelegationRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, mixed>
	 */
	public function rules()
	{
		return [
			'start_date'  => ['required', 'date'],
			'end_date'    => ['required', 'date', 'after:start_date'],
			'country'     => ['required', 'in:PL,DE,GB', new Iso3166Alpha2()]
		];
	}

	protected function failedValidation(Validator $validator)
	{
		throw new HttpResponseException(response()->json($validator->errors(), 422));
	}
}
