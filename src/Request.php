<?php namespace ATDev\Viva;

/**
 * Basic functionality to set/get data to make a requests
 */
trait Request {

	/** @var string Client id, provided by wallet */
	private $clientId;

	/** @var string Client secret, provided by wallet */
	private $clientSecret;

	/** @var bool Test mode */
	private $testMode = false;

	/** @var string|null Error message, empty if no error, some text if any */
	private $error;

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
}