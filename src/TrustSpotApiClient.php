<?php

namespace Gonzaloner\TrustSpotApiClient;

use Gonzaloner\TrustSpotApiClient\Resources\CompanyReviews;

class TrustSpotApiClient
{

  public $company_reviews;
  protected $auth_key;
  protected $secret_key;
  protected $merchant_id;
  protected $last_http_response_status_code;

  public function __construct()
  {
    $this->company_reviews = new CompanyReviews($this);
  }

  public function setAuthKey($auth_key)
  {
    $auth_key = trim($auth_key);
    $this->auth_key = $auth_key;
  }

  public function company()
  {
    return $this->company_reviews;
  }

  public function apiCall($url, $http_method, $http_body = NULL)
  {
    if (empty($this->auth_key))
    {
      throw new \Exception("[TrustSpot API Client]: You have not set an auth key.");
    } else {
      $post_key = ['key' => $this->auth_key];
    }

    if (empty($this->ch) || !function_exists("curl_reset"))
    {
      $this->ch = curl_init();
    } else
    {
      curl_reset($this->ch);
    }

    if ($http_body !== NULL)
    {
      $post_params = array_merge($http_body, $post_key);
    }

    curl_setopt($this->ch, CURLOPT_URL, $url);
    curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $http_method);
    curl_setopt($this->ch, CURLOPT_POST, 1);
    curl_setopt($this->ch, CURLOPT_POSTFIELDS, !$http_body ? $post_key : $post_params);
    curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);

    $body = curl_exec($this->ch);

    $this->last_http_response_status_code = (int) curl_getinfo($this->ch, CURLINFO_HTTP_CODE);

    if (curl_errno($this->ch))
    {
      $message = "[TrustSpot API Client]: Unable to communicate with TrustSpot.";

      $this->closeApiConnection();
      throw new \Exception($message);
    }

    if (!function_exists("curl_reset"))
    {
      $this->closeApiConnection();
    }

    return $body;
  }

  private function closeApiConnection()
  {
    if (is_resource($this->ch))
    {
      curl_close($this->ch);
      $this->ch = null;
    }
  }

  public function __destruct()
  {
    $this->closeApiConnection();
  }
}
