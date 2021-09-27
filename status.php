<?php

use Dotlines\EPW\StatusRequest;

include_once "vendor/autoload.php";

$url = 'http://sandbox.easypayway.com/api/v1/trxcheck/request.php?request_id​=1011&store
_id​=epw&signature_key​=dc0c2802bf04d2ab3336ec21491146a3&type​=xml'; //must be unique for each request
$request_id​ = 'EPW1621853905452832'; //must be unique for each request

$charge = StatusRequest::getInstance($request_id​);
echo json_encode($charge->send()) . '<br/>';


?>