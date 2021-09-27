<?php


namespace Dotlines\EPW;

use Dotenv\Dotenv;

use Dotlines\Core\Helpers\RequestHelper;
use Dotlines\Core\Request;

class StatusRequest extends Request
{
    private string $request_id​;

    public static function getInstance(string $request_id​): StatusRequest
    {
        return new StatusRequest($request_id​);
    }

    /**
     * ChargeRequest constructor.
     *
     * @param string $request_id​
     */
    private function __construct(string $request_id​)
    {
        Dotenv::createImmutable(__DIR__ . '\\..')->safeLoad();
        $this->requestMethod = 'GET';
        // http://sandbox.easypayway.com/api/v1/trxcheck/request.php?request_id​=1011&store
        // _id​=epw&signature_key​=dc0c2802bf04d2ab3336ec21491146a3&type​=xml
        $url = "https://sandbox.easypayway.com/api/v1/trxcheck/request.php";
        // $url = (array_key_exists('EPW_SERVER_URL', $_ENV) ? (string)$_ENV['EPW_SERVER_URL'] : (string)getenv('EPW_SERVER_URL'));
        $this->store_id = (array_key_exists('EPW_STORE_ID', $_ENV) ? (string)$_ENV['EPW_STORE_ID'] : (string)getenv('EPW_STORE_ID'));
        $this->signature_key = (array_key_exists('EPW_SIGNATURE_KEY', $_ENV) ? (string)$_ENV['EPW_SIGNATURE_KEY'] : (string)getenv('EPW_SIGNATURE_KEY'));

        $this->request_id​ = $request_id​;

        $this->url = $url . "?request_id​=$request_id​&store_id=$this->store_id&signature_key​=$this->signature_key&type​=json";
        $this->url = "https://sandbox.easypayway.com/api/v1/trxcheck/request.php";
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
        // dd($this->url);
        return RequestHelper::send_form_params_request($this->requestMethod, $this->url, $this->headers(), $this->params());
    }

    final public function params(): array
    {
        return [
            'request_id' => $this->request_id,
            'signature_key' => $this->signature_key,
            'store_id' => $this->store_id,
            'type' => 'json',
        ];
    }
}
