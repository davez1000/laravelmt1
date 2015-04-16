<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp as Guzzle;
use Illuminate\Support\Collection;
use App\MetarRegex;

class Metar extends Model {

  protected $table = "metar";

  /**
   * Fetches and parses METAR and TAF information.
   * 
   * @param  boolean $icao  The ICAO identifier.
   * @return Array          Parsed METAR and TAF.
   */
  public static function parse($icao = FALSE) {
    $output = self::fetch($icao);
    return view('dbo.metar', ['metar' => $output]);
  }

  /**
   * 
   * @param  string $icao ICAO identifier.
   * @return array        Array of METAR and TAF information.
   */
  public static function fetch($icao, $type = 'metar', $import = FALSE) {
    $icao = strtoupper($icao);

    $client = new Guzzle\Client();
    $output = [];

    try {
      $url = self::getEndpoint()[$type] . $icao . '.TXT';
      $r = $client->get($url);
      if ($r->getBody()) {
        $body = $r->getBody();
        if (!$import) {
          $body = MetarRegex::$type($body);
        }
        return $body;
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
      'egac',
      'egcc',
      'eghi',
      'egjj',
      'eggp',
      'egvn',
      'eggd',
      'egff',
      'egcn',
    ])->random();
  }

}
