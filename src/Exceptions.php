<?php

namespace waliko\Yoomoney;

class Exceptions
{
    /* Basic public function */

    public function InvalidToken()
    {
        $message = "Token is not valid, or does not have the appropriate rights";
        echo $message . "\n";
    }

    public function IllegalParamType()
    {
        $message = "Invalid parameter value 'type'";
        echo $message . "\n";
    }

    public function IllegalParamStartRecord()
    {
        $message = "Invalid parameter value 'start_record'";
        echo $message . "\n";
    }

    public function IllegalParamRecords()
    {
        $message = "Invalid parameter value 'records'";
        echo $message . "\n";
    }

    public function IllegalParamLabel()
    {
        $message = "Invalid parameter value 'label'";
        echo $message . "\n";
    }

    public function IllegalParamFromDate()
    {
        $message = "Invalid parameter value 'from_date'";
        echo $message . "\n";
    }

    public function IllegalParamTillDate()
    {
        $message = "Invalid parameter value 'till_date'";
        echo $message . "\n";
    }

    public function IllegalParamOperationId()
    {
        $message = "Invalid parameter value 'operation_id'";
        echo $message . "\n";
    }

    public function TechnicalError()
    {
        $message = "Technical error, try calling the operation again later";
        echo $message . "\n";
    }

    public function InvalidRequest()
    {
        $message = "Required query parameters are missing or have incorrect or invalid values";
        echo $message . "\n";
    }

    public function UnauthorizedClient()
    {
        $message = "Invalid parameter value 'client_id' or 'client_secret', or the application does not have the right to request authorization (for example, YooMoney blocked it 'client_id')";
        echo $message . "\n";
    }

    public function InvalidGrant()
    {
        $message = "In issue 'access_token' denied. YuMoney did not issue a temporary token, the token is expired, or this temporary token has already been issued 'access_token' (repeated request for an authorization token with the same temporary token)";
        echo $message . "\n";
    }

    public function EmptyToken()
    {
        $message = "Response token is empty. Repeated request for an authorization token";
        echo $message . "\n";
    }
}
