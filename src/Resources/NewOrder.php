<?php

namespace Gonzaloner\TrustSpotApiClient\Resources;

use Gonzaloner\TrustSpotApiClient\TrustSpotApiClient;

class NewOrder
{

    const GET_ENDPOINT = 'https://trustspot.io/api/pub/new_order';
    const GET_METHOD = 'POST';
    const JSON_ENCODE = true;

    protected $api;
    protected $secret_key;
    protected $merchant_id;

    public function __construct(TrustSpotApiClient $api)
    {
        $this->api = $api;
    }

    public function setSecretKey($secret_key)
    {
        $secret_key = trim($secret_key);
        $this->secret_key = $secret_key;
    }

    public function setMerchantId($merchant_id)
    {
        $merchant_id = trim($merchant_id);
        $this->merchant_id = $merchant_id;
    }

    public function post($order_id, $order_email, $order_name, $order_date)
    {
        if (empty($this->merchant_id))
        {
            throw new \Exception("[TrustSpot API Client]: You have not set a merchant id.");
        }

        if (empty($this->secret_key))
        {
            throw new \Exception("[TrustSpot API Client]: You have not set a secret key.");
        }

        $data = $this->merchant_id . $order_id . $order_email;
        $hmac = base64_encode(hash_hmac( 'sha256' , $data, $this->secret_key, true ));
        $order_date = date('Y-m-d', strtotime($order_date));
        $options = [
            "merchant_id" => $this->merchant_id,
            "order_id" => $order_id,
            "customer_name" => $order_name,
            "customer_email" => $order_email,
            "purchase_date" => $order_date,
            "hmac" => $hmac
        ];

        $api_call = $this->api->apiCall(self::GET_ENDPOINT, self::GET_METHOD, $options, self::JSON_ENCODE);

        return $api_call;
    }
}
