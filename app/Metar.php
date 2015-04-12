<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MetarParse;

class Metar extends Model {

  protected $table = "metar";

  /**
   * Parses METAR and TAF.
   * 
   * @param  boolean $icao  The ICAO identifier.
   * @return Array          Parsed METAR and TAF.
   */
  public static function parse($icao = FALSE) {
    return $output = MetarParse::fetch($icao);
  }

}
