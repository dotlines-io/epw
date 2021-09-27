<?php
$url="https://sandbox.easypayway.com/payment/request.php";

$fields = array(    
    'store_id' => 'epw',
    'signature_key' => 'dc0c2802bf04d2ab3336ec21491146a3',
    'amount' => '10.00',
    'payment_type' => 'VISA',
    'currency' => 'BDT',
    'tran_id' => bin2hex(openssl_random_pseudo_bytes(12)),
    'cus_name' => 'Abdullah Bin Amin',
    'cus_email' => 'emran@fosterpayments.com',
    'cus_city' => 'Dhaka',
    'cus_state' => 'Dhaka',
    'cus_postcode' => '1206',
    'cus_country' => 'BD',
    'cus_phone' => '01700718904',
    'cus_fax' => 'Not¬Applicable',
    'ship_name' => 'Abdullah Bin Amin',
    'ship_add1' => 'House B-121, Road 21',
    'ship_add2' => 'Mohakhali',
    'ship_city' => 'Dhaka',
    'ship_state' => 'Dhaka',
    'ship_postcode' => '1212',
    'ship_country' => 'BD',
    'desc' => 'T-Shirt',
    'success_url' => 'https://epwbd.free.beeceptor.com',
    'fail_url' => 'https://epwbd.free.beeceptor.com',
    'cancel_url' => 'https://epwbd.free.beeceptor.com',
    'opt_a' => 'Optional Value A',
    'opt_b' => 'Optional Value B',
    'opt_c' => 'Optional Value C',
    'opt_d' => 'Optional Value D',
	'type_of_transaction'=>'',
	'emi_amout_per_month'=>'',
	'emi_duration'=>'',
	'emi_gw'=>'');
$fields_string = "";
print_r($fields);

foreach ($fields as $key => $value) {
    echo $key . ":" . $value . "<br/>";
    $fields_string .= $key . '=' . $value . '&';
}
$fields_string = rtrim($fields_string, '&');

echo $fields_string ;die;

$ch = curl_init();
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
echo $resultData = json_decode($result, true);
print_r($result);
?>