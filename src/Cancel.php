<?php namespace ATDev\Viva;

/**
 * A class which creates cancel request
 */
class Cancel extends Request {

	/** @const string Url to required api */
	const URL = '/transactions';

	/** @var string Request method */
	protected $method = 'DELETE';

	/** @var transaction id to cancel */
	protected $transactionId;

	/**
	 * Sets transaction id to cancel
	 *
	 * @param string $transactionId Transaction id to cancel
	 *
	 * @return \ATDev\Viva\Cancel
	 */
	public function setTransactionId($transactionId) {

		$this->transactionId = $transactionId;

		return $this;
	}

	/**
	 * Gets transaction id to cancel
	 *
	 * @return string
	 */
	public function getTransactionId() {

		return $this->transactionId;
	}

	/**
	 * Gets full api url for the request
	 *
	 * @return string
	 */
	protected function getApiUrl() {

		$url = parent::getApiUrl();

		$url = $url . "/" . $this->getTransactionId();

		$url = $url . "?amount=" . $this->getAmount();

		return $url;
	}
}