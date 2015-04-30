<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class TwatterRequest extends Request {

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
	 * @return array
	 */
	public function rules()
	{
		return [
			'status' => 'required|max:140',
			'image' => 'mimes:jpeg,gif,png|max:3145728',
		];
	}

}
