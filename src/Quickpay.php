<?php

namespace waliko\Yoomoney;

use WpOrg\Requests\Requests;

class Quickpay 
{
    private $base_url;

    public $receiver;
    public $quickpay_form;
    public $targets;
    public $paymentType;
    public $sum;
    public $formcomment="";
    public $short_dest="";
    public $label="";
    public $comment="";
    public $successURL="";
    public $need_fio=false;
    public $need_email=false;
    public $need_phone=false;
    public $need_address=false;

    public $response;
    
    public function __construct(
            $receiver,
            $quickpay_form,
            $targets,
            $paymentType,
            $sum,
            $formcomment="",
            $short_dest="",
            $label="",
            $comment="",
            $successURL="",
            $need_fio="",
            $need_email="",
            $need_phone="",
            $need_address=""
            ) {
        $this->receiver = $receiver;
        $this->quickpay_form = $quickpay_form;
        $this->targets = $targets;
        $this->paymentType = $paymentType;
        $this->sum = $sum;
        $this->formcomment = $formcomment;
        $this->short_dest = $short_dest;
        $this->label = $label;
        $this->comment = $comment;
        $this->successURL = $successURL;
        $this->need_fio = $need_fio;
        $this->need_email = $need_email;
        $this->need_phone = $need_phone;
        $this->need_address = $need_address;

        $this->response = $this->_request();
    }

    private function _request() {
        $this->base_url = "https://yoomoney.ru/quickpay/confirm.xml?";

        $payload = array();

        $payload["receiver"] = $this->receiver;
        $payload["quickpay_form"] = $this->quickpay_form;
        $payload["targets"] = $this->targets;
        $payload["paymentType"] = $this->paymentType;
        $payload["sum"] = $this->sum;

        if ($this->formcomment != "")
            $payload["formcomment"] = $this->formcomment;

        if ($this->short_dest != "")
            $payload["short_dest"] = $this->short_dest;

        if ($this->label != "")
            $payload["label"] = $this->label;

        if ($this->comment != "")
            $payload["comment"] = $this->comment;

        if ($this->successURL != "")
            $payload["successURL"] = $this->successURL;

        if ($this->need_fio != "")
            $payload["need_fio"] = $this->need_fio;

        if ($this->need_email != "")
            $payload["need_email"] = $this->need_email;

        if ($this->need_phone != "")
            $payload["need_phone"] = $this->need_phone;

        if ($this->need_address != "")
            $payload["need_address"] = $this->need_address;
            
        foreach( $payload as $key => $value) {
            $this->base_url .= str_replace("_","-",$key) . "=" . $value;
            $this->base_url .= "&";
        }

        $this->base_url = str_replace(" ", "%20",$this->base_url);

        $response = Requests::post($this->base_url);

        $this->redirected_url = $response->url;
        return $response;
    }
}