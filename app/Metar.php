<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp as Guzzle;
use Illuminate\Support\Collection;

class Metar extends Model {

  protected $table = "metar";

  /**
   * Fetches and parses METAR and TAF information.
   * 
   * @param  boolean $icao  The ICAO identifier.
   * @return Array          Parsed METAR and TAF.
   */
  public static function parse($icao = FALSE) {
    return $output = self::fetch($icao);
  }

  /**
   * 
   * @param  string $icao ICAO identifier.
   * @return array        Array of METAR and TAF information.
   */
  public static function fetch($icao, $type = 'metar') {
    $icao = strtoupper($icao);

    $client = new Guzzle\Client();
    $output = [];

    try {
      $url = self::endpoints()[$type] . $icao . '.TXT';
      $r = $client->get($url);
      if ($r->getBody()) {
        return $r->getBody();
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
  public static function endpoints() {
    return [
      'metar' => 'http://weather.noaa.gov/pub/data/observations/metar/stations/',
      'taf' => 'http://weather.noaa.gov/pub/data/forecasts/taf/stations/',
    ];
  }

  /**
   * Picks random ICAO's for import.
   * 
   * @return String ICAO code.
   */
  public static function randomIcao() {
    return Collection::make([
      'egll',
      'egkk',
      'egss',
      'eggw',
      'eglc',
      'egph',
      'egnt',
    ])->random();
  }

}
