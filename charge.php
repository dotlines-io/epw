<?php

use Dotlines\EPW\ChargeRequest;

include_once "vendor/autoload.php";


// print("<pre>");
// print_r($_POST);
// print("</pre>");
// die();

// $charge_url = 'https://sandbox.easypayway.com/payment/index.php';
// $store_id = 'epw'; //Your Merchant ID – Provided by EasyPayWay
$tran_id = 'rdfsdff55ef3'; //must be unique for each request
$success_url = 'http://localhost/epw/charge.php'; //URL to which the customer will be returned when the payment is made successfully.
$fail_url = 'http://localhost/epw/charge.php'; //URL to which the customer will be returned when the payment is made. But the Payment not Accepted by bank or card have insufficient balance etc
$cancel_url = 'http://localhost/epw/charge.php'; //URL to which the customer will be returned if the payment process is cancelled. If this field is not filled, the gateway window will simply close automatically upon clicking the cancellation button, so the customer will be returned to the last page on the Merchant's website where the customer has been before.
$ipn_url = ''; //Optional URL which easypayway will push the transaction details. Its required to confirm both party payment information updated to both party
$opt_a = ''; //Optional Field for Merchant Record
$opt_b = ''; //Optional Field for Merchant Record
$opt_c = ''; //Optional Field for Merchant Record
$opt_d = ''; //Optional Field for Merchant Record
// payment details
$amount = 39; // The total amount payable. Please note that you should skip the trailing zeroes in case the amount is a natural number
$payment_type = 'VISA'; //Optional Payment process card type that customer want to pay with
$currency = 'BDT'; //3­letter code of the currency of the amount according to ISO 4217 (see Annex I for accepted currencies)
// $signature_key = 'dc0c2802bf04d2ab3336ec21491146a3'; //Signature Key will be provided by EasyPayWay
$amount_vat = 10; //Optional
$amount_vatRatio = 10; //Optional
$amount_tax = 10; //Optional
$amount_taxRatio = 10; //Optional
$amount_processingfee = 10; //Optional
$amount_processingfee_ratio = 10; //Optional
$desc = 'T­Shirt'; //Merchant may specify a detailed calculation for the total amount payable. Please note that easypayway does check the validity of these data ­ they are only displayed in the ’More information’ section in the Merchant Panel of the gateway.
// Customer Details
$cus_name = 'Mr. ABc'; //Customer Full Name
$cus_email = 'abc@gmail.com'; //Email address of the customer who is making the payment.
$cus_add1 = 'Dhaka'; //cus_add1
$cus_add2 = ''; //Optional Customer’s address (e.g. town) 
$cus_city = 'Dhaka'; //Customer’s city
$cus_state = 'Dhaka'; //Customer’s state or region. 
$cus_postcode = '1206'; //Customer’s postal code/ZIP Code. Only alphanumeric values are accepted (no punctuation marks etc.)
$cus_country = 'Bangladesh'; //Customer’s country
$cus_phone = '01738084575'; //Customer’s phone number. Only numeric values are accepted
$cus_fax = ''; //Optional
// Shipping Details (If Ship to Same Address of Customer then No need to Fill Up)
$ship_name = ''; //Optional
$ship_add1 = ''; //Optional
$ship_add2 = ''; //Optional
$ship_city = ''; //Optional
$ship_state = ''; //Optional
$ship_postcode = ''; //Optional
$ship_country = ''; //Optional
$charge = ChargeRequest::getInstance($tran_id, $success_url, $fail_url, $cancel_url, $amount, $currency, $desc, $cus_name, $cus_email, $cus_add1, $cus_city, $cus_state, $cus_postcode, $cus_country, $cus_phone, $ipn_url, $opt_a, $opt_b, $opt_c, $opt_d, $payment_type, $amount_vat, $amount_vatRatio, $amount_tax, $amount_taxRatio, $amount_processingfee, $amount_processingfee_ratio, $cus_add2, $cus_fax, $ship_name, $ship_add1, $ship_add2, $ship_city, $ship_state, $ship_postcode, $ship_country);
echo json_encode($charge->send()) . '<br/>';


?>