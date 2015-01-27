<?php

namespace InPay;

class API_Client {
    private $availableCurrencies = array("PLN", "USD", "EUR", "CZK");
    private $apiUrl = "https://api.test-inpay.pl";
    private $apiKey = "";
    private $apiKeySecret = "";
    private $currency = "PLN";
    private $callbackUrl;
    private $successUrl;

    public function init($options) {
        foreach((array) $options as $key => $val) {
            $this->$key = $val;
        }
    }

    public function invoiceCreate($amount, $orderCode = "") {
        $data = array(
            'apiKey' => $this->apiKey,
            'amount' => number_format(str_replace(",",".", $amount), 2),
            'currency' => $this->currency,
            'callbackUrl' => $this->callbackUrl,
            'orderCode' => $orderCode,
            'successUrl' => $this->successUrl
        );
        return $this->requestPost("/invoice/create", $data);
    }

    public function invoiceStatus($invoiceCode) {
        $data = array(
            'invoiceCode' => $invoiceCode,
        );
        return $this->requestPost("/invoice/status", $data);
    }

    public function setCurrency($name) {
        if(in_array($name, $this->availableCurrencies)) {
            $this->currency = $name;
        } else {
            throw new Exception("Currency unavailable");
        }
    }

    /*
     * private methods, don't use directly
     */

    private function requestPost($method, $data) {
        $url = $this->apiUrl . $method;
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return json_decode($result, true);
    }

    private function checkApiHash() {
        $apiHash = $_SERVER['HTTP_API_HASH'];
        $query = http_build_query($_POST);
        $hash = hash_hmac("sha512", $query, $this->apiKeySecret);
        return $apiHash == $hash;
    }
} 