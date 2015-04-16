<?php namespace App;

class MetarRegex {

  public function __construct() {

  }
  
  /**
   * METAR regex, trims the initial type and date.
   *
   * @param $data
   *  The METAR string.
   * @return string
   *  The trimmed string.
   */
  public static function metar($data) {
    return preg_replace('/^(?:.+?\s+){2}(.+)$/', '\1', $data);
  }
  
  /**
   * TAF regex, trims the initial type and date.
   *
   * @param $data
   *  The TAF string.
   * @return string
   *  The trimmed string.
   */
  public static function taf($data) {
    return preg_replace('/^(?:.+?\s+){3}(.+)$/', '\1', $data);
  }


}
