<?php


namespace Dotlines\EPW;

use Dotlines\Core\Request;

use Dotenv\Dotenv;
use Dotlines\Core\Helpers\RequestHelper;

class ChargeRequest extends Request
{
    private string $store_id;
    private string $tran_id;
    private string $success_url;
    private string $fail_url;
    private string $cancel_url;
    private float $amount;
    private string $currency;
    private string $signature_key;
    private string $desc;
    private string $cus_name;
    private string $cus_email;
    private string $cus_add1;
    private string $cus_city;
    private string $cus_state;
    private string $cus_postcode;
    private string $cus_country;
    private string $cus_phone;

    private string $ipn_url;
    private string $opt_a;
    private string $opt_b;
    private string $opt_c;
    private string $opt_d;
    private string $payment_type;
    private float $amount_vat;
    private float $amount_vatRatio;
    private float $amount_tax;
    private float $amount_taxRatio;
    private float $amount_processingfee;
    private float $amount_processingfee_ratio;
    private string $cus_add2;
    private string $cus_fax;
    private string $ship_name;
    private string $ship_add1;
    private string $ship_add2;
    private string $ship_city;
    private string $ship_state;

    public static function getInstance(
        string $tran_id,
        string $success_url,
        string $fail_url,
        string $cancel_url,
        float $amount,
        string $currency,
        string $desc,
        string $cus_name,
        string $cus_email,
        string $cus_add1,
        string $cus_city,
        string $cus_state,
        string $cus_postcode,
        string $cus_country,
        string $cus_phone,
        string $ipn_url = '',
        string $opt_a = '',
        string $opt_b = '',
        string $opt_c = '',
        string $opt_d = '',
        string $payment_type = '',
        float $amount_vat = 0,
        float $amount_vatRatio = 0,
        float $amount_tax = 0,
        float $amount_taxRatio = 0,
        float $amount_processingfee = 0,
        float $amount_processingfee_ratio = 0,
        string $cus_add2 = '',
        string $cus_fax = '',
        string $ship_name = '',
        string $ship_add1 = '',
        string $ship_add2 = '',
        string $ship_city = '',
        string $ship_state = '',
        string $ship_postcode = '',
        string $ship_country = ''
    ): ChargeRequest {
        return new ChargeRequest(
            $tran_id,
            $success_url,
            $fail_url,
            $cancel_url,
            $amount,
            $currency,
            $desc,
            $cus_name,
            $cus_email,
            $cus_add1,
            $cus_city,
            $cus_state,
            $cus_postcode,
            $cus_country,
            $cus_phone,
            $ipn_url,
            $opt_a,
            $opt_b,
            $opt_c,
            $opt_d,
            $payment_type,
            $amount_vat,
            $amount_vatRatio,
            $amount_tax,
            $amount_taxRatio,
            $amount_processingfee,
            $amount_processingfee_ratio,
            $cus_add2,
            $cus_fax,
            $ship_name,
            $ship_add1,
            $ship_add2,
            $ship_city,
            $ship_state,
            $ship_postcode,
            $ship_country
        );
    }

    /**
     * ChargeRequest constructor.
     *
     * @param string $url
     * @param string $store_id;
     * @param string $tran_id;
     * @param string $success_url;
     * @param string $fail_url;
     * @param string $cancel_url;
     * @param float $amount;
     * @param string $currency;
     * @param string $signature_key;
     * @param string $desc;
     * @param string $decus_namesc;
     * @param string $cus_email;
     * @param string $cus_add1;
     * @param string $cus_city;
     * @param string $cus_state;
     * @param string $cus_postcode;
     * @param string $cus_country;
     * @param string $cus_phone;
     * @param string $ipn_url;
     * @param string $opt_a;
     * @param string $opt_b;
     * @param string $opt_c;
     * @param string $opt_d;
     * @param string $payment_type;
     * @param float $amount_vat;
     * @param float $amount_vatRatio;
     * @param float $amount_tax;
     * @param float $amount_taxRatio;
     * @param float $amount_processingfee;
     * @param float $amount_processingfee_ratio;
     * @param string $cus_add2;
     * @param string $cus_acus_faxdd2;
     * @param string $ship_name;
     * @param string $ship_add1;
     * @param string $ship_add2;
     * @param string $ship_city;
     * @param string $ship_state;
     */
    private function __construct(
        string $tran_id,
        string $success_url,
        string $fail_url,
        string $cancel_url,
        float $amount,
        string $currency,
        string $desc,
        string $cus_name,
        string $cus_email,
        string $cus_add1,
        string $cus_city,
        string $cus_state,
        string $cus_postcode,
        string $cus_country,
        string $cus_phone,
        string $ipn_url = '',
        string $opt_a = '',
        string $opt_b = '',
        string $opt_c = '',
        string $opt_d = '',
        string $payment_type = '',
        float $amount_vat = 0,
        float $amount_vatRatio = 0,
        float $amount_tax = 0,
        float $amount_taxRatio = 0,
        float $amount_processingfee = 0,
        float $amount_processingfee_ratio = 0,
        string $cus_add2 = '',
        string $cus_fax = '',
        string $ship_name = '',
        string $ship_add1 = '',
        string $ship_add2 = '',
        string $ship_city = '',
        string $ship_state = '',
        string $ship_postcode = '',
        string $ship_country = ''
    ) {

        Dotenv::createImmutable(__DIR__ . '\\..')->safeLoad();

        $this->url = (array_key_exists('EPW_SERVER_URL', $_ENV) ? (string)$_ENV['EPW_SERVER_URL'] : (string)getenv('EPW_SERVER_URL'));
        $this->store_id = (array_key_exists('EPW_STORE_ID', $_ENV) ? (string)$_ENV['EPW_STORE_ID'] : (string)getenv('EPW_STORE_ID'));
        $this->signature_key = (array_key_exists('EPW_SIGNATURE_KEY', $_ENV) ? (string)$_ENV['EPW_SIGNATURE_KEY'] : (string)getenv('EPW_SIGNATURE_KEY'));

        $this->requestMethod = 'POST';
        $this->tran_id = $tran_id;
        $this->success_url = $success_url;
        $this->fail_url = $fail_url;
        $this->cancel_url = $cancel_url;
        $this->amount = $amount;
        $this->currency = $currency;
        $this->desc = $desc;
        $this->cus_name = $cus_name;
        $this->cus_email = $cus_email;
        $this->cus_add1 = $cus_add1;
        $this->cus_city = $cus_city;
        $this->cus_state = $cus_state;
        $this->cus_postcode = $cus_postcode;
        $this->cus_country = $cus_country;
        $this->cus_phone = $cus_phone;

        $this->ipn_url = $ipn_url;
        $this->opt_a = $opt_a;
        $this->opt_b = $opt_b;
        $this->opt_c = $opt_c;
        $this->opt_d = $opt_d;
        $this->payment_type = $payment_type;
        $this->amount_vat = $amount_vat;
        $this->amount_vatRatio = $amount_vatRatio;
        $this->amount_tax = $amount_tax;
        $this->amount_taxRatio = $amount_taxRatio;
        $this->amount_processingfee = $amount_processingfee;
        $this->amount_processingfee_ratio = $amount_processingfee_ratio;
        $this->cus_add2 = $cus_add2;
        $this->cus_fax = $cus_fax;
        $this->ship_name = $ship_name;
        $this->ship_add1 = $ship_add1;
        $this->ship_add2 = $ship_add2;
        $this->ship_city = $ship_city;
        $this->ship_state = $ship_state;
        $this->ship_postcode = $ship_postcode;
        $this->ship_country = $ship_country;
    }

    /**
     * @noinspection MethodShouldBeFinalInspection
     */
    final public function headers(): array
    {
        return RequestHelper::make_form_params_headers($this->accessToken);
    }

    /**
     * @return array
     * @throws JsonException
     * @throws Exception|GuzzleException
     * @noinspection MethodShouldBeFinalInspection
     */
    public function send(): array
    {
        return RequestHelper::send_form_params_request($this->requestMethod, $this->url, $this->headers(), $this->params());
    }

    final public function params(): array
    {
        $params = [
            'store_id' => $this->store_id,
            'tran_id' => $this->tran_id,
            'success_url' => $this->success_url,
            'fail_url' => $this->fail_url,
            'cancel_url' => $this->cancel_url,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'signature_key' => $this->signature_key,
            'desc' => $this->desc,
            'cus_name' => $this->cus_name,
            'cus_email' => $this->cus_email,
            'cus_add1' => $this->cus_add1,
            'cus_city' => $this->cus_city,
            'cus_state' => $this->cus_state,
            'cus_postcode' => $this->cus_postcode,
            'cus_country' => $this->cus_country,
            'cus_phone' => $this->cus_phone,
        ];

        if (!empty($this->ipn_url)) {
            $params['ipn_url'] = $this->ipn_url;
        }
        if (!empty($this->opt_a)) {
            $params['opt_a'] = $this->opt_a;
        }
        if (!empty($this->opt_b)) {
            $params['opt_b'] = $this->opt_b;
        }
        if (!empty($this->opt_c)) {
            $params['opt_c'] = $this->opt_c;
        }
        if (!empty($this->opt_d)) {
            $params['opt_d'] = $this->opt_d;
        }
        if (!empty($this->payment_type)) {
            $params['payment_type'] = $this->payment_type;
        }
        if (!empty($this->amount_vat)) {
            $params['amount_vat'] = $this->amount_vat;
        }
        if (!empty($this->amount_vatRatio)) {
            $params['amount_vatRatio'] = $this->amount_vatRatio;
        }
        if (!empty($this->amount_tax)) {
            $params['amount_tax'] = $this->amount_tax;
        }
        if (!empty($this->amount_taxRatio)) {
            $params['amount_taxRatio'] = $this->amount_taxRatio;
        }
        if (!empty($this->amount_processingfee)) {
            $params['amount_processingfee'] = $this->amount_processingfee;
        }
        if (!empty($this->amount_processingfee_ratio)) {
            $params['amount_processingfee_ratio'] = $this->amount_processingfee_ratio;
        }
        if (!empty($this->cus_add2)) {
            $params['cus_add2'] = $this->cus_add2;
        }
        if (!empty($this->cus_fax)) {
            $params['cus_fax'] = $this->cus_fax;
        }
        if (!empty($this->ship_name)) {
            $params['ship_name'] = $this->ship_name;
        }
        if (!empty($this->ship_add1)) {
            $params['ship_add1'] = $this->ship_add1;
        }
        if (!empty($this->ship_add2)) {
            $params['ship_add2'] = $this->ship_add2;
        }
        if (!empty($this->ship_city)) {
            $params['ship_city'] = $this->ship_city;
        }
        if (!empty($this->ship_state)) {
            $params['ship_state'] = $this->ship_state;
        }
        if (!empty($this->ship_postcode)) {
            $params['ship_postcode'] = $this->ship_postcode;
        }
        if (!empty($this->ship_country)) {
            $params['ship_country'] = $this->ship_country;
        }
        // $client = new Client();
        // $response = $client->post($this->url, ['form_params' => $params]);
        // dd($response->getBody()->getContents());

        return $params;
    }
}
