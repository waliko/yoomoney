<?php

namespace Waliko\Authorize;

use WpOrg\Requests;

class Authorize
{
    public function __construct($client_id="",$redirect_uri="",$scope=array())
    {
        $url = "https://yoomoney.ru/oauth/authorize?client_id=${client_id}&response_type=code&redirect_uri=${redirect_uri}&scope=".implode('%20',$scope);

        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded'
        );
    }
}