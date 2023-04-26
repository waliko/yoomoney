<?php

namespace waliko\Yoomoney;

use WpOrg\Requests;
use waliko\Yoomoney\Exceptions;

class Authorize
{
    public function __construct($client_id="",$redirect_uri="",$scope=array())
    {
        $url = "https://yoomoney.ru/oauth/authorize?client_id=${client_id}&response_type=code&redirect_uri=${redirect_uri}&scope=".implode('%20',$scope);

        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded'
        );

        $response = Requests::request("POST", $url, $headers);

        if ($response->status_code == 200) {
            echo("Visit this website and confirm the application authorization request:\n");
            echo($response->url."\n");
        }

        $code = readline("Enter redirected url (https://yourredirect_uri?code=XXXXXXXXXXXXX) or just code: ");

        if($pos !== strpos($code,"code=")) {
            $code = substr($code,$pos+5);
        }

        $url = "https://yoomoney.ru/oauth/token?code=${code}&client_id=${client_id}&grant_type=authorization_code&redirect_uri=${redirect_uri}";

        $response = Requests::request("POST", $url, $headers);

        if (isset($response->json()["error"])) {
            $error = $response->json()["error"];
            if ($error == "invalid_request") {
                waliko\Yoomoney\Exceptions\InvalidRequest();
            } elseif ($error == "unauthorized_client") {
                waliko\Yoomoney\Exceptions\UnauthorizedClient();
            } elseif ($error == "invalid_grant") {
                waliko\Yoomoney\Exceptions\InvalidGrant();
            }
        }

        if ($response->json()['access_token'] == "") {
            waliko\Yoomoney\Exceptions\EmptyToken();
        }

        echo("Your access token: ");
        echo($response->json()['access_token']);
    }
}