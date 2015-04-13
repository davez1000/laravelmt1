<?php namespace App;

use Illuminate\Support\Facades\log;
use GuzzleHttp as Guzzle;


class MetarParse {

  /**
   * 
   * @param  string $icao ICAO identifier.
   * @return array        Array of METAR and TAF information.
   */
  public static function fetch($icao) {
    $icao = strtoupper($icao);

    $request_uris = [
      'metar' => 'http://weather.noaa.gov/pub/data/observations/metar/stations/' . $icao . '.TXT',
      'taf' => 'http://weather.noaa.gov/pub/data/forecasts/taf/stations/' . $icao . '.TXT',
    ];

    $client = new Guzzle\Client();
    $output = [];

    try {
      foreach ($request_uris as $k => $v) {
        $r = $client->get($v);
        if ($r->getBody()) {
          $trimmed = preg_replace("/^(?:.+?\s+){2}(.+)$/", "\\1", $r->getBody());
          $output[] = $trimmed;
        }
      }
      return $output;
    } catch (RequestException $e) {
//      $monolog = Log::getMonolog();
      // Log errors.
      Log::notice('Metar: Problem with request: ' . $e->getRequest());
      if ($e->hasResponse()) {
        Log::notice('Metar: Problem with response: ' . $e->hasResponse());
      }
    }
  }
}
