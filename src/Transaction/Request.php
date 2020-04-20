<?php namespace ATDev\Viva\Transaction;

use \ATDev\Viva\Account\Authorization as AccountAuthorization;

/**
 * An abstract class which handles all requests to transactions api
 */
abstract class Request implements \JsonSerializable {

	use \ATDev\Viva\Request;

	const URI = "/nativecheckout/v2/transactions";

	/** @const string Request method, should be overridden in child classes */
	const METHOD = "";

	/** @var string Source code, provided by wallet */
	private $sourceCode;

	/** @var int The amount to auth, charge, capture, refund */
	private $amount;

	/** @var string Access token to interact with transactions api */
	private $accessToken;

	/**
	 * Set source code
	 *
	 * @param string $sourceCode
	 *
	 * @return \ATDev\Viva\Transaction\Request
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
	 * Sets amount
	 *
	 * @param int $amount Amount
	 *
	 * @return \ATDev\Viva\Transaction\Request
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
	 * Sets access token
	 *
	 * @param int $accessToken Access Token
	 *
	 * @return \ATDev\Viva\Transaction\Request
	 */
	public function setAccessToken($accessToken) {

		$this->accessToken = $accessToken;

		return $this;
	}

	/**
	 * Gets access token
	 *
	 * @return string
	 */
	public function getAccessToken() {

		if (empty($this->accessToken)) {

			$this->setAccessToken((new AccountAuthorization())
				->setClientId($this->getClientId())
				->setClientSecret($this->getClientSecret())
				->setTestMode($this->getTestMode())
				->getAccessToken());
		}

		return $this->accessToken;
	}

	/**
	 * Sends request to api
	 *
	 * @return stdClass
	 */
	public function send() {

		$headers = [
			"Authorization" => "Bearer " . $this->getAccessToken(),
			"Accept" => "application/json"
		];

		$request = [
			"timeout" => 60,
			"connect_timeout" => 60,
			"exceptions" => false,
			'headers' => $headers
		];

		if (static::METHOD != 'DELETE') {
			$request["json"] = $this;
		}

		$client = new \GuzzleHttp\Client();
		$res = $client->request(
			static::METHOD,
			$this->getApiUrl(),
			$request
		);

		$code = $res->getStatusCode();
		$body = $res->getBody()->getContents();

		$result = @json_decode($body);

		if (($code < 200) || ($code >= 300)) {

			$this->setError($body);

			if ((isset($result->message)) && (!empty(trim($result->message))) ) {

				$this->setError($result->message);
			}
		} else {

			$this->setError(null);
		}

		if (!empty($this->getError())) {

			return null;
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
	 * Gets api url for the request
	 *
	 * @return string
	 */
	protected function getApiUrl() {

		return Url::getUrl($this->getTestMode()) . self::URI;
	}
}