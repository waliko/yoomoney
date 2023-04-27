<?php

namespace waliko\Yoomoney;

use WpOrg\Requests\Requests;
use waliko\Yoomoney\Exceptions;
use waliko\Yoomoney\Account;

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

    public function __construct($base_url,$token,$method) {
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

        } else {
            waliko\Yoomoney\Exceptions\InvalidToken();
        }
    }

    private function _request() {

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