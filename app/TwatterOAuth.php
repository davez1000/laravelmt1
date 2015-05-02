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

}
