<?php

namespace waliko\Yoomoney;

use WpOrg\Requests\Requests;
use waliko\Yoomoney\Exceptions;

class OperationDetails
{

}

class DigitalProduct
{
    public $serial;
    public $secret;
    public $merchant_article_id;

    public function __construct($merchant_article_id,$serial,$secret) {
        $this->merchant_article_id = $merchant_article_id;
        $this->serial = $serial;
        $this->secret = $secret;
    }
}

class DigitalBonus
{
    public $serial;
    public $secret;

    public function __construct($serial,$secret) {
        $this->serial = $serial;
        $this->secret = $secret;
    }
}