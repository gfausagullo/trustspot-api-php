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

  public $limit = self::DEFAULT_LIMIT;
  public $offset = self::DEFAULT_OFFSET;
  public $sort = self::DEFAULT_SORT;

  protected $api;

  public function __construct(TrustSpotApiClient $api)
  {
    $this->api = $api;
  }

  public function get($limit = NULL, $offset = NULL, $sort = NULL)
  {
    $options = array(
      "limit" => !$limit ? $this->limit : $limit,
      "offset" => !$offset ? $this->offset : $offset,
      "sort" => !$sort ? $this->sort : $sort
    );

    $api_call = $this->api->apiCall(self::GET_ENDPOINT, self::GET_METHOD, $options);

    return $api_call;
  }
}
