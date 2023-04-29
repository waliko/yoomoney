<?php

namespace waliko\Yoomoney;

use WpOrg\Requests\Requests;
use waliko\Yoomoney\Exceptions;

class Authorize
{
    public function __construct($client_id="",$redirect_uri="",$scope=array())
    {
        $url = "https://yoomoney.ru/oauth/authorize?client_id=${client_id}&response_type=code&redirect_uri=${redirect_uri}&scope=".implode('%20',$scope);

        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded'
        );

        $response = Requests::post($url, $headers);

        if ($response->status_code == 200) {
            echo("Visit this website and confirm the application authorization request:\n");
            echo($response->url."\n");
        }

        $code = readline("Enter redirected url (https://yourredirect_uri?code=XXXXXXXXXXXXX) or just code: ");

        if(strpos($code,"code=") !== false) {
            $code = substr($code,strpos($code,"code=")+5);
        }

        $url = "https://yoomoney.ru/oauth/token?code=${code}&client_id=${client_id}&grant_type=authorization_code&redirect_uri=${redirect_uri}";

        $response = Requests::post($url, $headers);

        if (isset($response->decode_body()["error"])) {
            $error = $response->decode_body()["error"];
            if ($error == "invalid_request") {
                new Exceptions->InvalidRequest();
            } elseif ($error == "unauthorized_client") {
                new Exceptions->UnauthorizedClient();
            } elseif ($error == "invalid_grant") {
                new Exceptions->InvalidGrant();
            }
        }

        if ($response->decode_body()['access_token'] == "") {
            new Exceptions\EmptyToken();
        }

        echo("Your access token: ");
        echo($response->decode_body()['access_token']);
    }
}