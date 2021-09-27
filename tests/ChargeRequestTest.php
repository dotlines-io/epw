<?php

/** @noinspection GlobalVariableUsageInspection */
/** @noinspection PhpComposerExtensionStubsInspection */
/** @noinspection SpellCheckingInspection */
/** @noinspection MethodVisibilityInspection */

namespace Dotlines\EPW\Tests;

use Dotenv\Dotenv;
use Dotlines\EPW\ChargeRequest;
use Exception;
use GuzzleHttp\Exception\ClientException;
use JsonException;
use PHPUnit\Framework\TestCase;

class ChargeRequestTest extends TestCase
{
    protected $backupStaticAttributes = false;
    protected $runTestInSeparateProcess = false;

    public string $serverUrl = '';
    public string $storeId = '';
    public string $signatureKey = '';

    public string $accessToken = "";
    public string $chargeUrl = "";
    public string $package = "";
    public string $callBackURL = "";
    public string $details = "";
    public string $mobile = ''; //optional
    public string $email = ''; //optional
    public string $reference = ''; //optional

    /**
     * @throws Exception
     */
    final public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        Dotenv::createImmutable(__DIR__ . '\\..')->safeLoad();

        $this->serverUrl = (array_key_exists('EPW_SERVER_URL', $_ENV) ? (string)$_ENV['EPW_SERVER_URL'] : (string)getenv('EPW_SERVER_URL'));
        $this->storeId = (array_key_exists('EPW_STORE_ID', $_ENV) ? (string)$_ENV['EPW_STORE_ID'] : (string)getenv('EPW_STORE_ID'));
        $this->signatureKey = array_key_exists('EPW_SIGNATURE_KEY', $_ENV) ? (string)$_ENV['EPW_SIGNATURE_KEY'] : (string)getenv('EPW_SIGNATURE_KEY');
        
        $this->chargeUrl = $this->serverUrl . "/api/v2.0/charge";
        $this->package = 'BBC_Janala_Course1';
        $this->callBackURL = 'https://test-app.local';
        $this->details = 'Test Transaction'; //optional
    }


    /**
     * @test
     * @throws JsonException
     */
    final public function it_can_fetch_charge_url(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = random_int(10, 100);
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken, $this->clientID, $orderID, $this->package, $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);

        $chargeResponse = $chargeRequest->send();

        self::assertNotEmpty($chargeResponse);
        self::assertArrayHasKey('url', $chargeResponse);
        self::assertArrayHasKey('spTransID', $chargeResponse);
        self::assertArrayHasKey('errorCode', $chargeResponse);
        self::assertArrayHasKey('errorMessage', $chargeResponse);
        self::assertNotEmpty($chargeResponse['url']);
        self::assertNotEmpty($chargeResponse['spTransID']);
        self::assertNotEmpty($chargeResponse['errorCode']);
        self::assertNotEmpty($chargeResponse['errorMessage']);
    }


    /**
     * @test
     * @throws Exception
     */
    final public function it_gets_exception_with_empty_serverUrl(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = random_int(10, 100);
        $chargeRequest = ChargeRequest::getInstance("", $this->accessToken, $this->clientID, $orderID, $this->package, $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $this->expectException(Exception::class);
        $chargeRequest->send();
    }

    /**
     * @test
     * @throws Exception
     */
    final public function it_gets_exception_with_wrong_serverUrl(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = random_int(10, 100);
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl."/wrong", $this->accessToken, $this->clientID, $orderID, $this->package, $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $this->expectException(ClientException::class);
        $chargeRequest->send();
    }

    /**
     * @test
     * @throws Exception
     */
    final public function it_gets_exception_with_empty_accesToken(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = random_int(10, 100);
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, "", $this->clientID, $orderID, $this->package, $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $this->expectException(ClientException::class);
        $chargeRequest->send();
    }

    /**
     * @test
     * @throws Exception
     */
    final public function it_gets_exception_with_wrong_accesToken(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = random_int(10, 100);
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken."skfhksg", $this->clientID, $orderID, $this->package, $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $this->expectException(ClientException::class);
        $chargeRequest->send();
    }

    /**
     * @test
     * @throws Exception
     */
    final public function it_can_not_fetch_with_wrong_clientID(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = random_int(10, 100);
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken, 99999, $orderID, $this->package, $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $chargeResponse = $chargeRequest->send();

        self::assertNotEmpty($chargeResponse);
        self::assertArrayNotHasKey('url', $chargeResponse);
        self::assertArrayNotHasKey('spTransID', $chargeResponse);
        self::assertArrayHasKey('errorCode', $chargeResponse);
        self::assertArrayHasKey('errorMessage', $chargeResponse);
        self::assertNotEmpty($chargeResponse['errorCode']);
        self::assertNotEmpty($chargeResponse['errorMessage']);
    }

    /**
     * @test
     * @throws Exception
     */
    final public function it_can_not_fetch_url_with_empty_orderID(): void
    {
        $amount = random_int(10, 100);
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken, $this->clientID, "", $this->package, $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $chargeResponse = $chargeRequest->send();

        self::assertNotEmpty($chargeResponse);
        self::assertArrayNotHasKey('url', $chargeResponse);
        self::assertArrayNotHasKey('spTransID', $chargeResponse);
        self::assertArrayHasKey('errorCode', $chargeResponse);
        self::assertArrayHasKey('errorMessage', $chargeResponse);
        self::assertNotEmpty($chargeResponse['errorCode']);
        self::assertNotEmpty($chargeResponse['errorMessage']);
    }

    /**
     * @test
     * @throws Exception
     */
    final public function it_can_not_fetch_url_with_amount_less_than_2(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken, $this->clientID, $orderID, $this->package, 2 - 5, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $chargeResponse = $chargeRequest->send();

        self::assertArrayNotHasKey('url', $chargeResponse);
        self::assertArrayNotHasKey('spTransID', $chargeResponse);
        self::assertArrayHasKey('errorCode', $chargeResponse);
        self::assertArrayHasKey('errorMessage', $chargeResponse);
        self::assertNotEmpty($chargeResponse['errorCode']);
        self::assertNotEmpty($chargeResponse['errorMessage']);
    }

    /**
     * @test
     * @throws Exception
     */
    final public function it_fails_to_fetch_url_with_amount_greater_than_99999(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken, $this->clientID, $orderID, $this->package, 99999 + 1, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $chargeResponse = $chargeRequest->send();

        self::assertArrayNotHasKey('url', $chargeResponse);
        self::assertArrayNotHasKey('spTransID', $chargeResponse);
        self::assertArrayHasKey('errorCode', $chargeResponse);
        self::assertArrayHasKey('errorMessage', $chargeResponse);
        self::assertNotEmpty($chargeResponse['errorCode']);
        self::assertNotEmpty($chargeResponse['errorMessage']);
    }

    /**
     * @test
     * @throws Exception
     */
    final public function it_can_not_fetch_url_with_amount_greater_than_one_lac(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = 100000;
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken, $this->clientID, $orderID, $this->package, $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $chargeResponse = $chargeRequest->send();

        self::assertArrayNotHasKey('url', $chargeResponse);
        self::assertArrayNotHasKey('spTransID', $chargeResponse);
        self::assertArrayHasKey('errorCode', $chargeResponse);
        self::assertArrayHasKey('errorMessage', $chargeResponse);
        self::assertNotEmpty($chargeResponse['errorCode']);
        self::assertNotEmpty($chargeResponse['errorMessage']);
    }

    /**
     * @test
     * @throws Exception
     */
    final public function it_can_not_fetch_url_with_empty_package(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = random_int(10, 100);
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken, $this->clientID, $orderID, "", $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $chargeResponse = $chargeRequest->send();

        self::assertNotEmpty($chargeResponse);
        self::assertArrayNotHasKey('url', $chargeResponse);
        self::assertArrayNotHasKey('spTransID', $chargeResponse);
        self::assertArrayHasKey('errorCode', $chargeResponse);
        self::assertArrayHasKey('errorMessage', $chargeResponse);
        self::assertNotEmpty($chargeResponse['errorCode']);
        self::assertNotEmpty($chargeResponse['errorMessage']);
    }

    /**
     * @test
     * @throws Exception
     */
    final public function it_can_not_fetch_url_with_wrong_package(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = random_int(10, 100);
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken, $this->clientID, $orderID, "wrong_package", $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $chargeResponse = $chargeRequest->send();

        self::assertNotEmpty($chargeResponse);
        self::assertArrayNotHasKey('url', $chargeResponse);
        self::assertArrayNotHasKey('spTransID', $chargeResponse);
        self::assertArrayHasKey('errorCode', $chargeResponse);
        self::assertArrayHasKey('errorMessage', $chargeResponse);
        self::assertNotEmpty($chargeResponse['errorCode']);
        self::assertNotEmpty($chargeResponse['errorMessage']);
    }

    /**
     * @test
     * @throws Exception
     */
    final public function it_can_not_fetch_url_with_empty_callbackUrl(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = random_int(10, 100);
        $this->callBackURL = "";
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken, $this->clientID, $orderID, $this->package, $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $chargeResponse = $chargeRequest->send();

        self::assertNotEmpty($chargeResponse);
        self::assertArrayNotHasKey('url', $chargeResponse);
        self::assertArrayNotHasKey('spTransID', $chargeResponse);
        self::assertArrayHasKey('errorCode', $chargeResponse);
        self::assertArrayHasKey('errorMessage', $chargeResponse);
        self::assertNotEmpty($chargeResponse['errorCode']);
        self::assertNotEmpty($chargeResponse['errorMessage']);
    }

    /**
     * @test
     * @throws Exception
     */

    final public function it_can_not_fetch_url_with_invalid_callbackUrl(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = random_int(10, 100);
        $this->callBackURL = "randomsite";
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken, $this->clientID, $orderID, $this->package, $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $chargeResponse = $chargeRequest->send();

        self::assertNotEmpty($chargeResponse);
        self::assertArrayNotHasKey('url', $chargeResponse);
        self::assertArrayNotHasKey('spTransID', $chargeResponse);
        self::assertArrayHasKey('errorCode', $chargeResponse);
        self::assertArrayHasKey('errorMessage', $chargeResponse);
        self::assertNotEmpty($chargeResponse['errorCode']);
        self::assertNotEmpty($chargeResponse['errorMessage']);
    }

    /**
     * @test
     * @throws Exception
     */

    final public function it_can_not_fetch_url_with_invalid_mobile_number(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = random_int(10, 100);
        $this->mobile = '1234333333';
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken, $this->clientID, $orderID, $this->package, $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $chargeResponse = $chargeRequest->send();

        self::assertNotEmpty($chargeResponse);
        self::assertArrayNotHasKey('url', $chargeResponse);
        self::assertArrayNotHasKey('spTransID', $chargeResponse);
        self::assertArrayHasKey('errorCode', $chargeResponse);
        self::assertArrayHasKey('errorMessage', $chargeResponse);
        self::assertNotEmpty($chargeResponse['errorCode']);
        self::assertNotEmpty($chargeResponse['errorMessage']);
    }

    /**
     * @test
     * @throws Exception
     */

    final public function it_can_not_fetch_url_with_invalid_email(): void
    {
        $orderID = 'test-app-' . random_int(111111, 999999);
        $amount = random_int(10, 100);
        $this->email = 'lsadjjoe';
        $chargeRequest = ChargeRequest::getInstance($this->chargeUrl, $this->accessToken, $this->clientID, $orderID, $this->package, $amount, $this->callBackURL, $this->details, $this->mobile, $this->email, $this->reference);
        $chargeResponse = $chargeRequest->send();

        self::assertNotEmpty($chargeResponse);
        self::assertArrayNotHasKey('url', $chargeResponse);
        self::assertArrayNotHasKey('spTransID', $chargeResponse);
        self::assertArrayHasKey('errorCode', $chargeResponse);
        self::assertArrayHasKey('errorMessage', $chargeResponse);
        self::assertNotEmpty($chargeResponse['errorCode']);
        self::assertNotEmpty($chargeResponse['errorMessage']);
    }
}
