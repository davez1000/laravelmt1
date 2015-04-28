<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Input;
use Validator;
use Redirect;
use Session;

class TwatterController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($type = FALSE)
	{
		switch ($type) {
			case 'update':
				return view('twatter.update');
				break;
			default:
			// Default API page, list links
				$data = 'nothing here';
				break;
		}
		// return view('twatter.api', ['data' => $data]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		// getting all of the post data
		$file = array('image' => Input::file('image'));
		// setting up rules
		// $rules = array('image' => 'image|mimes:jpeg,gif,png|max:3145728');
		$rules = array('required');
		// doing the validation, passing post data, rules and the messages
		$validator = Validator::make($file, $rules);
		if ($validator->fails()) {
		  // send back to the page with the input data and errors
		  return Redirect::to('twatter/api/update')->withInput()->withErrors($validator);
		}
		else {
		  // checking file is valid.
		  if (Input::file('image')->isValid()) {
		    $destinationPath = 'public/uploads/' . str_random(8); // upload path
		    $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension
		    $fileName = rand(11111,99999) . '.' . $extension; // renaming image
		    Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
		    // sending back with message
		    Session::flash('success', 'Upload successfully'); 
		    return Redirect::to('twatter/api/update');
		  }
		  else {
		    // sending back with error message.
		    Session::flash('error', 'uploaded file is not valid');
		    return Redirect::to('twatter/api/update');
		  }
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
