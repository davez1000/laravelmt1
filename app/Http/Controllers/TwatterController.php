<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\TwatterRequest;
use Abraham\TwitterOAuth\TwitterOAuth;

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
	public function store(TwatterRequest $request)
	{
		if ($request->file('image')) {
	    $file_ext = $request->file('image')->getClientOriginalExtension();
	    $file_name = md5(uniqid()) . sha1(uniqid()) . '.' . $file_ext;

	    $moved_file = $request->file('image')->move(
	      base_path() . '/public/images/catalog/', $file_name
	    );
  	}

    $connection = new TwitterOAuth(
    	env('OAUTH_CONSUMER_KEY'),
    	env('OAUTH_CONSUMER_SECRET'),
    	env('OAUTH_ACCESS_TOKEN'),
    	env('OAUTH_ACCESS_TOKEN_SECRET')
    );
    $media1 = $connection->upload('media/upload', array('media' => $moved_file));
    // $media2 = $connection->upload('media/upload', array('media' => ''));
    $parameters = array(
        'status' => trim($request->input('status')),
        'media_ids' => implode(',', array($media1->media_id_string)),
    );
    $result = $connection->post('statuses/update', $parameters);
    
    // $request = new \stdClass();
    // $request->created_at = 'debug = TRUE';
    if (!empty($request->created_at)) {
  		\Session::flash('message', 'Sent successfully!'); 
			\Session::flash('alert-class', 'alert-info');
    	return redirect('twatter/api/update');
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
