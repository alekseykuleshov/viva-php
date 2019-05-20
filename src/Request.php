<?php namespace ATDev\Viva;

/**
 * An abstract class which handles all requests to api
 */
abstract class Request implements \JsonSerializable {

	/** @const Live api url */
	const LIVE_URL = 'https://www.vivapayments.com';
	/** @const Test api url */
	const TEST_URL = 'https://demo.vivapayments.com';
	/** @const string Url to required api */
	const URL = '/api';

	/** @var string Request method, can be overridden at child classes if required */
	protected $method = 'POST';

	/** @var string Merchant id, provided by wallet */
	protected $merchantId;
	/** @var string API key, provided by wallet */
	protected $apiKey;
	/** @var string Source code, provided by wallet */
	protected $sourceCode;

	/** @var the amount to auth, charge, capture, refund */
	protected $amount;

	/** @var bool Test mode */
	private $testMode = false;
	/** @var string|null Error message, empty if no error, some text if any */
	protected $error;

	/**
	 * Class constructor
	 *
	 * @param string $merchantId Merchant id
	 */
	public function __construct($merchantId) {

		$this->setMerchantId($merchantId);
	}

	/**
	 * Sets merchant id
	 *
	 * @param string $merchantId Merchant id
	 *
	 * @return \ATDev\Viva\Request
	 */
	public function setMerchantId($merchantId) {

		$this->merchantId = $merchantId;

		return $this;
	}

	/**
	 * Gets merchant id
	 *
	 * @return string
	 */
	public function getMerchantId() {

		return $this->merchantId;
	}

	/**
	 * Set api key
	 *
	 * @param string $apiKey
	 *
	 * @return \ATDev\Viva\Request
	 */
	public function setApiKey($apiKey) {

		$this->apiKey = $apiKey;

		return $this;
	}

	/**
	 * Gets api key
	 *
	 * @return string
	 */
	public function getApiKey() {

		return $this->apiKey;
	}

	/**
	 * Set source code
	 *
	 * @param string $sourceCode
	 *
	 * @return \ATDev\Viva\Request
	 */
	public function setSourceCode($sourceCode) {

		$this->sourceCode = $sourceCode;

		return $this;
	}

	/**
	 * Gets source code
	 *
	 * @return string
	 */
	public function getSourceCode() {

		return $this->sourceCode;
	}

	/**
	 * Sets test mode
	 *
	 * @param bool $testMode
	 *
	 * @return \ATDev\Viva\Request
	 */
	public function setTestMode($testMode) {

		$this->testMode = $testMode;

		return $this;
	}

	/**
	 * Gets test mode
	 *
	 * @return bool
	 */
	public function getTestMode() {

		return $this->testMode;
	}

	/**
	 * Gets error
	 *
	 * @return string
	 */
	public function getError() {

		return $this->error;
	}

	/**
	 * Sets amount
	 *
	 * @param int $amount Amount
	 *
	 * @return \ATDev\Viva\Request
	 */
	public function setAmount($amount) {

		$this->amount = $amount;

		return $this;
	}

	/**
	 * Gets amount
	 *
	 * @return int
	 */
	public function getAmount() {

		return $this->amount;
	}

	/**
	 * Sends request to api
	 *
	 * @return stdClass
	 */
	public function send() {

		$request = [
			"auth" => [$this->getMerchantId(), $this->getApiKey()],
			"timeout" => 60,
			"connect_timeout" => 60,
			"exceptions" => false
		];

		if ($this->method != 'DELETE') {
			$request["json"] = $this;
		}

		$client = new \GuzzleHttp\Client();
		$res = $client->request(
			$this->method,
			$this->getApiUrl(),
			$request
		);

		$code = $res->getStatusCode();
		$body = $res->getBody()->getContents();

		if ( ( $code < 200 ) || ($code >= 300) ) {

			$this->error = $body;
		} else {

			$this->error = null;
		}

		$result = json_decode($body);

		if ($result->ErrorCode != 0) {

			if ( (isset($result->ErrorText) ) && ( ! empty(trim($result->ErrorText))) ) {

				$this->error = trim($result->ErrorText);
			} else {

				$this->error = 'An error has occured';
			}
		} else {

			$this->error = null;
		}

		return $result;
	}

	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		return [];
	}

	/**
	 * Gets full api url for the request
	 *
	 * @return string
	 */
	protected function getApiUrl() {

		$url = (($this->testMode)?self::TEST_URL:self::LIVE_URL) . self::URL;

		if ( self::URL != static::URL) {
			$url = $url . static::URL;
		}

		return $url;
	}
}