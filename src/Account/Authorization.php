<?php namespace ATDev\Viva\Account;

/**
 * Authorization class
 */
class Authorization {

	/** @const string Uri to required api */
	const URI = '/connect/token';

	/** @var string Client id, provided by wallet */
	protected $clientId;
	/** @var string Client secret, provided by wallet */
	protected $clientSecret;

	/** @var bool Test mode */
	private $testMode = false;

	/** @var string|null Error message, empty if no error, some text if any */
	private $error;

	/** @var string Request method */
	private $method = 'POST';

	public function getAccessToken() {

		$headers = [
			"Authorization" => "Basic " . $this->getAuthToken(),
			"Accept" => "application/json",
			"Content-Type" => "application/x-www-form-urlencoded",
		];

		$request = [
			"form_params" => ["grant_type" => "client_credentials"],
			"timeout" => 60,
			"connect_timeout" => 60,
			"exceptions" => false,
			'headers' => $headers
		];

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

		$result = json_decode($body); // handle non-parsable string 

		if ( (isset($result->error) ) && ( ! empty(trim($result->error))) ) {

			$this->error = trim($result->error);
		}

		if (!empty($this->error)) {

			return null;
		}

		if (empty($result->access_token)) {

			$this->error = "Access token is absent in response";
		}

		if (!empty($this->error)) {

			return null;
		}

		return $result->access_token;
	}

	/**
	 * Set client id
	 *
	 * @param string $clientId
	 *
	 * @return \ATDev\Viva\Transaction\Authorization
	 */
	public function setClientId($clientId) {

		$this->clientId = $clientId;

		return $this;
	}

	/**
	 * Gets client id
	 *
	 * @return string
	 */
	public function getClientId() {

		return $this->clientId;
	}

	/**
	 * Set client secret
	 *
	 * @param string $clientSecret
	 *
	 * @return \ATDev\Viva\Transaction\Authorization
	 */
	public function setClientSecret($clientSecret) {

		$this->clientSecret = $clientSecret;

		return $this;
	}

	/**
	 * Gets client secret
	 *
	 * @return string
	 */
	public function getClientSecret() {

		return $this->clientSecret;
	}

	/**
	 * Sets test mode
	 *
	 * @param bool $testMode
	 *
	 * @return \ATDev\Viva\Transaction\Authorization
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
	 * Sets error
	 *
	 * @param string $error
	 *
	 * @return \ATDev\Viva\Transaction\Authorization
	 */
	private function setError($error) {

		$this->error = $error;

		return $this;
	}

	/**
	 * Creates the token to obtain access token
	 *
	 * @return string type
	 */
	private function getAuthToken() {

		return base64_encode($this->clientId . ":" . $this->clientSecret);
	}

	/**
	 * Gets full api url for the request
	 *
	 * @return string
	 */
	private function getApiUrl() {

		return Url::getUrl($this->testMode) . self::URI;
	}
}