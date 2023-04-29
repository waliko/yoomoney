<?php

namespace waliko\Yoomoney;

use WpOrg\Requests\Requests;
use waliko\Yoomoney\Operation;
use waliko\Yoomoney\Errors;

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
            Errors::IllegalParamFromDate();
        }

        if(preg_match('%^\d{4,4}-\d{2,2}-\d{2,2}T\d{2,2}:\d{2,2}:\d{2,2}$%',$till_date)) {
            $this->till_date = $till_date;
        } else {
            Errors::IllegalParamTillDate();
        }

        $this->start_record = $start_record;
        $this->records = $records;
        $this->details = $details;

        $data = $this->_request();

        if (isset($data["error"])) {
            if ($data["error"] == "illegal_param_type")
                Errors::IllegalParamType();
            elseif ($data["error"] == "illegal_param_start_record")
                Errors::IllegalParamStartRecord();
            elseif ($data["error"] == "illegal_param_records")
                Errors::IllegalParamRecords();
            elseif ($data["error"] == "illegal_param_label")
                Errors::IllegalParamLabel();
            elseif ($data["error"] == "illegal_param_from")
                Errors::IllegalParamFromDate();
            elseif ($data["error"] == "illegal_param_till")
                Errors::IllegalParamTillDate();
            else
                Errors::TechnicalError();
        }

        if (isset($data["next_record"])) {
            $this->next_record = $data["next_record"];
        }

        $this->operations = array();
        foreach ($data["operations"] as $operation_data) {
            $param = array();

            if (array_key_exists("operation_id",$operation_data))
                $param["operation_id"] = $operation_data["operation_id"];
            else
                $param["operation_id"] = "";

            if (array_key_exists("status",$operation_data))
                $param["status"] = $operation_data["status"];
            else
                $param["status"] = "";

            if (array_key_exists("datetime",$operation_data))
                $param["datetime"] = str_replace("T", " ",str_replace("Z","",$operation_data["datetime"]));
            else
                $param["datetime"] = "";

            if (array_key_exists("title",$operation_data))
                $param["title"] = $operation_data["title"];
            else
                $param["title"] = "";

            if (array_key_exists("pattern_id",$operation_data))
                $param["pattern_id"] = $operation_data["pattern_id"];
            else
                $param["pattern_id"] = "";

            if (array_key_exists("direction",$operation_data))
                $param["direction"] = $operation_data["direction"];
            else
                $param["direction"] = "";

            if (array_key_exists("amount",$operation_data))
                $param["amount"] = $operation_data["amount"];
            else
                $param["amount"] = "";

            if (array_key_exists("label",$operation_data))
                $param["label"] = $operation_data["label"];
            else
                $param["label"] = "";
                
            if (array_key_exists("type",$operation_data))
                $param["type"] = $operation_data["type"];
            else
                $param["type"] = "";

            $operation = new Operation(
                $param["operation_id"],
                $param["status"],
                str_replace("T", " ",str_replace("Z","",$param["datetime"])),
                $param["title"],
                $param["pattern_id"],
                $param["direction"],
                $param["amount"],
                $param["label"],
                $param["type"]
            );
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