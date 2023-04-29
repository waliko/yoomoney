<?php

namespace waliko\Yoomoney;

//use WpOrg\Requests\Requests;
use waliko\Yoomoney\Account;
//use waliko\Yoomoney\Authorize;
use waliko\Yoomoney\History;
//use waliko\Yoomoney\Operation;
use waliko\Yoomoney\OperationDetails;
//use waliko\Yoomoney\Quickpay;
//use waliko\Yoomoney\Exceptions;

class Client {
    public $base_url;
    public $token;

    public function __construct($token="",$base_url="") {
        if ($base_url == "")
            $this->base_url = "https://yoomoney.ru/api/";

        if ($token != "")
            $this->token = $token;
    }

    public function account_info() {
        $method = "account-info";
        return new Account($this->base_url,$this->token,$method);
    }

    public function operation_history(
                          $type = "",
                          $label = "",
                          $from_date = "",
                          $till_date = "",
                          $start_record = "",
                          $records = 0,
                          $details = false
                          ) {
        $method = "operation-history";
        return new History($this->base_url,
                       $this->token,
                       $method,
                       $type,
                       $label,
                       $from_date,
                       $till_date,
                       $start_record,
                       $records,
                       $details
                          );
    }

    public function operation_details($operation_id) {
        $method = "operation-details";
        return OperationDetails($this->base_url,
                                $this->token,
                                $operation_id,
                                $method
                                );
    }
}