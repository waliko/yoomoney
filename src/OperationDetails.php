<?php

namespace waliko\Yoomoney;

use WpOrg\Requests\Requests;
use waliko\Yoomoney\Errors;

class OperationDetails
{
    private $method;
    private $base_url;
    private $token;

    public $operation_id;

    public $status;
    public $pattern_id;
    public $direction;
    public $amount;
    public $amount_due;
    public $fee;
    public $datetime;
    public $title;
    public $sender;
    public $recipient;
    public $recipient_type;
    public $message;
    public $comment;
    public $codepro;
    public $protection_code;
    public $expires;
    public $answer_datetime;
    public $label;
    public $details;
    public $type;
    public $digital_goods;

    public function __construct($base_url,$token,$operation_id,$method="") {
        $this->method = $method;
        $this->base_url = $base_url;
        $this->token = $token;
        
        $this->operation_id = $operation_id;

        $data = $this->_request();

        if (isset($data["error"])) {
            if ($data["error"] == "illegal_param_operation_id")
                Errors::IllegalParamOperationId();
            else
                Errors::TechnicalError();
        }

        $this->status = "";
        $this->pattern_id = "";
        $this->direction = "";
        $this->amount = "";
        $this->amount_due = "";
        $this->fee = "";
        $this->datetime = "";
        $this->title = "";
        $this->sender = "";
        $this->recipient = "";
        $this->recipient_type = "";
        $this->message = "";
        $this->comment = "";
        $this->codepro = "";
        $this->protection_code = "";
        $this->expires = "";
        $this->answer_datetime = "";
        $this->label = "";
        $this->details = "";
        $this->type = "";
        $this->digital_goods = "";

        if (array_key_exists("status",$data))
            $this->status = $data["status"];

        if (array_key_exists("pattern_id",$data))
            $this->pattern_id = $data["pattern_id"];

        if (array_key_exists("direction",$data))
            $this->direction = $data["direction"];

        if (array_key_exists("amount",$data))
            $this->amount = $data["amount"];

        if (array_key_exists("amount_due",$data))
            $this->amount_due = $data["amount_due"];

        if (array_key_exists("fee",$data))
            $this->fee = $data["fee"];

        if (array_key_exists("datetime",$data))
            $this->datetime = str_replace("T", " ",str_replace("Z","",$data["datetime"]));

        if (array_key_exists("title",$data))
            $this->title = $data["title"];

        if (array_key_exists("sender",$data))
            $this->sender = $data["sender"];

        if (array_key_exists("recipient",$data))
            $this->recipient = $data["recipient"];

        if (array_key_exists("recipient_type",$data))
            $this->recipient_type = $data["recipient_type"];

        if (array_key_exists("message",$data))
            $this->message = $data["message"];

        if (array_key_exists("comment",$data))
            $this->comment = $data["comment"];

        if (array_key_exists("codepro",$data))
            $this->codepro = (bool)$data["codepro"];

        if (array_key_exists("protection_code",$data))
            $this->protection_code = $data["protection_code"];

        if (array_key_exists("expires",$data))
            $this->expires = str_replace("T", " ",str_replace("Z","",$data["expires"]));

        if (array_key_exists("answer_datetime",$data))
            $this->answer_datetime = str_replace("T", " ",str_replace("Z","",$data["answer_datetime"]));

        if (array_key_exists("label",$data))
            $this->label = $data["label"];

        if (array_key_exists("details",$data))
            $this->details = $data["details"];

        if (array_key_exists("type",$data))
            $this->type = $data["type"];

        if (array_key_exists("digital_goods",$data)) {
            $products = array();
            foreach ( $data["digital_goods"]["article"] as $product) {
                $digital_product = new DigitalProduct($product["serial"],$product["secret"],$product["merchantArticleId"]);
                $products[] = $digital_product;
            }

            $bonuses = array();
            foreach ( $data["digital_goods"]["bonus"] as $bonus) {
                $digital_product = new DigitalBonus($bonus["serial"],$bonus["secret"]);
                $bonuses[] = $digital_product;
            }

            $this->digital_goods = new DigitalGood($products,$bonuses);
        }
    }

    private function _request() {
        $access_token = $this->token;
        $url = $this->base_url.$this->method;

        $headers = array(
            'Authorization' => 'Bearer '.$access_token,
            'Content-Type' => 'application/x-www-form-urlencoded'
        );

        $payload = array();

        $payload["operation_id"] = $this->operation_id;

        $response = Requests::post($url, $headers, $payload);

        return $response->decode_body();
    }
}

class DigitalGood {
    public $products;
    public $bonuses;

    public function __construct($products=array(),$bonuses=array()) {
        $this->products = $products;
        $this->bonuses = $bonuses;
    }
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