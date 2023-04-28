<?php

namespace waliko\Yoomoney;

class Operation
{
    public $opation_id;
    public $status;
    public $datetime;
    public $title;
    public $parent_id;
    public $direction;
    public $amount;
    public $lable;
    public $type;

    public function __construct($operation_id="",$status="",$datetime="",$title="",$pattern_id="",$direction="",$amount=0.0,$label="",$type="") {
        $this->operation_id = $operation_id;
        $this->status = $status;
        $this->datetime = $datetime;
        $this->title = $title;
        $this->pattern_id = $pattern_id;
        $this->direction = $direction;
        $this->amount = $amount;
        $this->label = $label;
        $this->type = $type;
    }
}
