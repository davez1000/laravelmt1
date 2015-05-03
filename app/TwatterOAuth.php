<?php namespace App;

use Abraham\TwitterOAuth\TwitterOAuth;

class TwatterOAuth extends TwitterOAuth 
{
  public function __construct()
  {
    // Set the constructor up so we can inject it.
    parent::__construct(
      env('OAUTH_CONSUMER_KEY'),
      env('OAUTH_CONSUMER_SECRET'),
      env('OAUTH_ACCESS_TOKEN'),
      env('OAUTH_ACCESS_TOKEN_SECRET')
    );
    // Set default timeouts for OAuth.
    // This should be long enough to upload multiple images (up to 4).
    $this->setTimeouts(600, 600);
  }

  /**
   * Error code descriptions.
   * 
   * @return array
   */
  public function requestErrorMessages() {
    return [
      '304' => 'Not Modified',
      '400' => 'Bad Request',
      '401' => 'Unauthorized',
      '403' => 'Forbidden',
      '404' => 'Not Found',
      '406' => 'Not Acceptable',
      '410' => 'Gone',
      '420' => 'Enhance Your Calm',
      '422' => 'Unprocessable Entity',
      '429' => 'Too Many Requests',
      '500' => 'Internal Server Error',
      '502' => 'Bad Gateway',
      '503' => 'Service Unavailable',
      '504' => 'Gateway timeout',
    ];
  }

}
