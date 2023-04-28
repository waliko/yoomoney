<?php

namespace waliko\Yoomoney;

use WpOrg\Requests\Requests;
use waliko\Yoomoney\Operation;
use waliko\Yoomoney\Exceptions;

class History
{
    private $method;
    private $base_url;
    private $token;

    public $type;
    public $label;
    public $from_date;
    public $till_date;
    public $start_record;
    public $records;
    public $details;

    public $next_record;
    public $operations;

    public function __construct($base_url="",$token="",$method="",$type="",$label="",$from_date="",$till_date="",$start_record="",$records=0,$details=false) {
        $this->method = $method;
        $this->base_url = $base_url;
        $this->token = $token;
    
        $this->type = $type;
        $this->label = $label;

        if(preg_match('%^\d{4,4}-\d{2,2}-\d{2,2}T\d{2,2}:\d{2,2}:\d{2,2}$%',$from_date)) {
            $this->from_date = $from_date;
        } else {
            waliko\Yoomoney\Exceptions\IllegalParamFromDate();
        }

        if(preg_match('%^\d{4,4}-\d{2,2}-\d{2,2}T\d{2,2}:\d{2,2}:\d{2,2}$%',$till_date)) {
            $this->till_date = $till_date;
        } else {
            waliko\Yoomoney\Exceptions\IllegalParamTillDate();
        }

        $this->start_record = $start_record;
        $this->records = $records;
        $this->details = $details;

        $data = $this->_request();

        if (isset($data["error"])) {
            if ($data["error"] == "illegal_param_type")
                waliko\Yoomoney\Exceptions\IllegalParamType();
            elseif ($data["error"] == "illegal_param_start_record")
                waliko\Yoomoney\Exceptions\IllegalParamStartRecord();
            elseif ($data["error"] == "illegal_param_records")
                waliko\Yoomoney\Exceptions\IllegalParamRecords();
            elseif ($data["error"] == "illegal_param_label")
                waliko\Yoomoney\Exceptions\IllegalParamLabel();
            elseif ($data["error"] == "illegal_param_from")
                waliko\Yoomoney\Exceptions\IllegalParamFromDate();
            elseif ($data["error"] == "illegal_param_till")
                waliko\Yoomoney\Exceptions\IllegalParamTillDate();
            else
                waliko\Yoomoney\Exceptions\TechnicalError();
        }

        if (isset($data["next_record"])) {
            $this->next_record = $data["next_record"];
        }

        $this->operations = array();
        foreach ($data["operations"] as $operation_data) {
            $param = array();

            $operation = new Operation();
            $this->operations[] = $operation;
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
        if ($this->type != "")
            $payload["type"] = $this->type;

        if ($this->label != "")
            $payload["label"] = $this->label;

        if ($this->from_date != "")
            $payload["from"] = $this->from_date;

        if ($this->till_date != "")
            $payload["till"] = $this->till_date;

        if ($this->start_record != "")
            $payload["start_record"] = $this->start_record;

        if ($this->records != "")
            $payload["records"] = $this->records;

        if ($this->details != "")
            $payload["details"] = $this->details;

        $response = Requests::post($url, $headers, $payload);

        return $response->decode_body();
    }
}