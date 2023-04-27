<?php

namespace waliko\Yoomoney;

use WpOrg\Requests\Requests;
use waliko\Yoomoney\Exceptions;

class History
{
    private $method;
    private $base_url;
    private $token;

    public $type;
    public $label;

    public function __construct($base_url,$token,$method,$type,$label) {
        $this->method = $method;
        $this->base_url = $base_url;
        $this->token = $token;
    
        $this->type = $type;
        $this->label = $label;
    }
}