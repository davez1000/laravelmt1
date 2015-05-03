<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\TwatterRequest;
use App\TwatterOAuth;

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
		public function store(TwatterRequest $request, TwatterOAuth $connection)
		{

			$parameters = [];
			$media_id_strings = [];
			$parameters['status'] = trim($request->input('status'));

			for ($i=0; $i < 4; $i++) {
				if ($request->file('image' . $i)) {
					$file_ext = $request->file('image' . $i)->getClientOriginalExtension();
					$file_ext  = (strcasecmp($file_ext, 'jpeg') == 0)? 'jpg' : strtolower($file_ext);
					$file_name = uniqid() . '_' . substr(md5(mt_rand()), 0, 18) . '.' . $file_ext;

					$moved_file = $request->file('image' . $i)->move(
						base_path() . env('IMAGE_CATALOG_PATH', '/public/images/catalog/'), $file_name
					);
					$media = $connection->upload('media/upload', array('media' => $moved_file));
					$media_id_strings[] = $media->media_id_string;
				}
			}

			if (count($media_id_strings) > 0) {
				$parameters['media_ids'] = implode(',', $media_id_strings);
			}

			$result = $connection->post('statuses/update', $parameters);
			if ($connection->getLastHttpCode() == 200) {
				\Session::flash('message', 'Sent successfully!');
				\Session::flash('alert-class', 'alert-info');
			}
			else {
				$body_error_messages = [];
				if ($connection->getLastBody()->errors) {
					foreach ($connection->getLastBody()->errors as $key => $value) {
						$body_error_messages[] = '(' . $value->code . ' : ' . $value->message . ')';
					}
				}
				$error_messages = [
					$connection->getLastHttpCode(),
					$connection->requestErrorMessages()[$connection->getLastHttpCode()],
					implode(' ', $body_error_messages),
				];
				\Session::flash('message', 'There was a problem sending the message: ' . implode(' - ', $error_messages));
				\Session::flash('alert-class', 'alert-danger');
			}
			return redirect('twatter/api/update');
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
