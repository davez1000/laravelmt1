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
		// Create status and multiple image rules.
		$image_rule = 'mimes:jpeg,gif,png|max:3145728';
		$rules = [];
		$rules['status'] = 'required|max:140';
		for ($i=0; $i<4; $i++) { 
			$rules['image'. $i] = $image_rule;
		}
		return $rules;
	}

}
