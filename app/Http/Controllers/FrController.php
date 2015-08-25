<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class FrController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() #DEBUG TEST FOR FR FDATA
	{
    try {
      // Guzzle request.
      $client = new \GuzzleHttp\Client();
      $output = [];

      $r = $client->get(self::getEndpoint()['all']);
      if ($r->getBody()) {
        $body = $r->getBody();
        $body = json_decode($body);
        unset($body->full_count);
        unset($body->version);
        if (count($body)) {
        	foreach ($body as $key => $item) {
        		if (preg_match('/W67712/i', $item[13])) {
	        		$fid = $key;
	        		$f = $client->get(self::getEndpoint()['flight']. $fid);
	        		if ($fbody = $f->getBody()) {
	        			$fdbody = json_decode($fbody);
	        			$from_tz = new \DateTimeZone($fdbody->from_tz_code);
	        			$from_time = new \DateTime("@$fdbody->departure", $from_tz);
	        			echo "ATD:" . $from_time->format('r');
	        			$to_tz = new \DateTimeZone($fdbody->to_tz_code);
	        			$to_time = new \DateTime("@$fdbody->arrival", $to_tz);
	        			echo "ATA:" . $to_time->format('r'); exit;
	        			
	        			echo $fbody; exit;
	        		}
        		}
        	}
        }
      }
    } catch (RequestException $e) {
      Log::notice('Metar: Problem with request: ' . $e->getRequest());
      if ($e->hasResponse()) {
        Log::notice('Metar: Problem with response: ' . $e->hasResponse());
      }
    }
	}


  /**
   * Endpoints for METAR and TAF.
   * 
   * @return Array The endpoint URL's.
   */
  public static function getEndpoint() {
    return [
      'all' => 'http://lhr.data.fr24.com/zones/fcgi/full_all.json',
      'flight' => 'http://lhr.data.fr24.com/_external/planedata_json.1.3.php?f=',
    ];
  }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
