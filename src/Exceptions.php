<?php

namespace Waliko\Exceptions;

interface YooMoneyError {
    /* Basic class */
    public function __construct();
}


class InvalidToken implements YooMoneyError {
    private $message = "Token is not valid, or does not have the appropriate rights";
    public function __construct() {
        echo $this->message."\n";
    }
}

class IllegalParamType implements YooMoneyError {
    private $message = "Invalid parameter value 'type'";
    public function __construct() {
        echo $this->message."\n";
    }
}

class IllegalParamStartRecord implements YooMoneyError {
    private $message = "Invalid parameter value 'start_record'";
    public function __construct() {
        echo $this->message."\n";
    }
}

class IllegalParamRecords implements YooMoneyError {
    private $message = "Invalid parameter value 'records'";
    public function __construct() {
        echo $this->message."\n";
    }
}

class IllegalParamLabel implements YooMoneyError {
    private $message = "Invalid parameter value 'label'";
    public function __construct() {
        echo $this->message."\n";
    }
}

class IllegalParamFromDate implements YooMoneyError {
    private $message = "Invalid parameter value 'from_date'";
    public function __construct() {
        echo $this->message."\n";
    }
}

class IllegalParamTillDate implements YooMoneyError {
    private $message = "Invalid parameter value 'till_date'";
    public function __construct() {
        echo $this->message."\n";
    }
}

class IllegalParamOperationId implements YooMoneyError {
    private $message = "Invalid parameter value 'operation_id'";
    public function __construct() {
        echo $this->message."\n";
    }
}

class TechnicalError implements YooMoneyError {
    private $message = "Technical error, try calling the operation again later";
    public function __construct() {
        echo $this->message."\n";
    }
}

class InvalidRequest implements YooMoneyError {
    private $message = "Required query parameters are missing or have incorrect or invalid values";
    public function __construct() {
        echo $this->message."\n";
    }
}

class UnauthorizedClient implements YooMoneyError {
    private $message = "Invalid parameter value 'client_id' or 'client_secret', or the application does not have the right to request authorization (for example, YooMoney blocked it 'client_id')";
    public function __construct() {
        echo $this->message."\n";
    }
}

class InvalidGrant implements YooMoneyError {
    private $message = "In issue 'access_token' denied. YuMoney did not issue a temporary token, the token is expired, or this temporary token has already been issued 'access_token' (repeated request for an authorization token with the same temporary token)";
    public function __construct() {
        echo $this->message."\n";
    }
}

class EmptyToken implements YooMoneyError {
    private $message = "Response token is empty. Repeated request for an authorization token";
    public function __construct() {
        echo $this->message."\n";
    }
}