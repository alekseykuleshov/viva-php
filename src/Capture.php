<?php namespace ATDev\Viva;

/**
 * A class which creates capture request
 */
class Capture extends Request {

	/** @const string Url to required api */
	const URL = '/transactions';

	/** @var transaction id to capture */
	protected $transactionId;
	/** @var maximum installments */
	protected $installments = 0;

	/**
	 * Sets transaction id to capture
	 *
	 * @param string $transactionId Transaction id to capture
	 *
	 * @return \ATDev\Viva\Capture
	 */
	public function setTransactionId($transactionId) {

		$this->transactionId = $transactionId;

		return $this;
	}

	/**
	 * Gets transaction id to capture
	 *
	 * @return string
	 */
	public function getTransactionId() {

		return $this->transactionId;
	}

	/**
	 * Sets maximum installments
	 *
	 * @param string $installments Maximum installments
	 *
	 * @return \ATDev\Viva\Capture
	 */
	public function setInstallments($installments) {

		$this->installments = $installments;

		return $this;
	}

	/**
	 * Gets maximum installments
	 *
	 * @return string
	 */
	public function getInstallments() {

		return $this->installments;
	}

	/**
	 * Gets full api url for the request
	 *
	 * @return string
	 */
	protected function getApiUrl() {

		$url = parent::getApiUrl();

		$url = $url . "/" . $this->getTransactionId();

		return $url;
	}

	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		$result = [
			"Amount" => $this->amount,
			"Installments" => $this->installments
		];

		return $result;
	}
}