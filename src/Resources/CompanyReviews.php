<?php

namespace Gonzaloner\TrustSpotApiClient\Resources;

use Gonzaloner\TrustSpotApiClient\TrustSpotApiClient;

class CompanyReviews
{

  const GET_ENDPOINT = 'https://trustspot.io/api/pub/get_company_reviews';
  const GET_METHOD = 'POST';
  const DEFAULT_LIMIT = 10;
  const DEFAULT_OFFSET = 0;
  const DEFAULT_SORT = 'date desc';

  protected $api;

  public function __construct(TrustSpotApiClient $api)
  {
    $this->api = $api;
  }

  public function get($limit = self::DEFAULT_LIMIT, $offset = self::DEFAULT_OFFSET, $sort = self::DEFAULT_SORT)
  {
    $options = array(
      "limit" => $limit,
      "offset" => $offset,
      "sort" => $sort
    );

    $api_call = $this->api->apiCall(self::GET_ENDPOINT, self::GET_METHOD, $options);

    return $api_call;
  }
}
