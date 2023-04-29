<?php

namespace waliko\Yoomoney;

use WpOrg\Requests\Requests;
use waliko\Yoomoney\Exceptions;

class Account
{
    private $method;
    private $base_url;
    private $token;

    public $account;
    public $balance;
    public $currency;
    public $account_status;
    public $account_type;
    
    public $balance_details;
    public $cards_linked;

    public function __construct($base_url="",$token="",$method="") {
        $this->method = $method;
        $this->base_url = $base_url;
        $this->token = $token;

        $data = $this->_request();

        if(is_array($data) && count($data) > 0) {
            $this->account = $data['account'];
            $this->balance = $data['balance'];
            $this->currency = $data['currency'];
            $this->account_status = $data['account_status'];
            $this->account_type = $data['account_type'];

            $this->balance_details = new BalanceDetails();
            if (array_key_exists('balance_details',$data)) {
                if (array_key_exists('available',$data['balance_details']))
                    $this->balance_details->available = (float)$data['balance_details']['available'];

                if (array_key_exists('blocked',$data['balance_details']))
                    $this->balance_details->blocked = (float)$data['balance_details']['blocked'];

                if (array_key_exists('debt',$data['balance_details']))
                    $this->balance_details->debt = (float)$data['balance_details']['debt'];

                if (array_key_exists('deposition_pending',$data['balance_details']))
                    $this->balance_details->deposition_pending = (float)$data['balance_details']['deposition_pending'];

                if (array_key_exists('total',$data['balance_details']))
                    $this->balance_details->total = (float)$data['balance_details']['total'];

                if (array_key_exists('hold',$data['balance_details']))
                    $this->balance_details->hold = (float)$data['balance_details']['hold'];

            }

            $this->cards_linked = array();
            if (array_key_exists('cards_linked',$data)) {
                foreach ($data['cards_linked'] as $card_linked)  {
                    $card = new Card($card_linked['pan_fragment'], $card_linked['type']);
                    $this->cards_linked[] = $card;
                }
            }
        } else {
            new Exceptions->InvalidToken();
        }
    }

    private function _request() {
        $access_token = $this->token;
        $url = $this->base_url.$this->method;

        $headers = array(
            'Authorization' => 'Bearer '.$access_token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        );

        $response = Requests::post($url, $headers);

        return $response->decode_body();
    }
}

class Card
{
    public $pan_fragment;
    public $type;

    public function __construct($pan_fragment="",$type="") {
        $this->pan_fragment = $pan_fragment;
        $this->type = $type;
    }
}

class BalanceDetails
{
    public $total;
    public $available;
    public $deposition_pending;
    public $blocked;
    public $debt;
    public $hold;

    public function __construct($total=0.0,$available=0.0,$deposition_pending=0.0,$blocked=0.0,$debt=0.0,$hold=0.0) {
        $this->total = $total;
        $this->available = $available;
        $this->deposition_pending = $deposition_pending;
        $this->blocked = $blocked;
        $this->debt = $debt;
        $this->hold = $hold;
    }
}