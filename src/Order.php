<?php namespace ATDev\Viva;

/**
 * A class which creates order
 */
class Order extends Request {

	/** @const string Url to required api */
	const URL = '/orders';

	/** @var identifies order as pre-auth */
	protected $isPreAuth = false;
	/** @var maximum installments */
	protected $maxInstallments = 0;
	/** @var the order code */
	protected $orderCode;

	/**
	 * Sets pre-auth
	 *
	 * @param boolean $isPreAuth pre-auth
	 *
	 * @return \ATDev\Viva\Request
	 */
	public function setIsPreAuth($isPreAuth) {

		$this->isPreAuth = $isPreAuth;

		return $this;
	}

	/**
	 * Gets pre-auth
	 *
	 * @return string
	 */
	public function getIsPreAuth() {

		return $this->isPreAuth;
	}

	/**
	 * Sets maximum installments
	 *
	 * @param string $maxInstallments Maximum installments
	 *
	 * @return \ATDev\Viva\Request
	 */
	public function setInstallments($maxInstallments) {

		$this->maxInstallments = $maxInstallments;

		return $this;
	}

	/**
	 * Gets maximum installments
	 *
	 * @return string
	 */
	public function getInstallments() {

		return $this->maxInstallments;
	}

	/**
	 * Sets order code
	 *
	 * @param string $orderCode Order Code
	 *
	 * @return \ATDev\Viva\Order
	 */
	public function setOrderCode($orderCode) {

		$this->orderCode = $orderCode;

		return $this;
	}

	/**
	 * Gets order code
	 *
	 * @return string
	 */
	public function getOrderCode() {

		return $this->orderCode;
	}

	/**
	 * Sends request to api
	 *
	 * @return stdClass
	 */
	public function send() {

		// Order response example
		// stdClass Object (
		//	[OrderCode] => 2533572670508884
		//	[ErrorCode] => 0
		//	[ErrorText] =>
		//	[TimeStamp] => 2019-04-08T15:55:26.7050888+03:00
		//	[CorrelationId] =>
		//	[EventId] => 0
		//	[Success] => 1
		// )
		$result = parent::send();

		if (empty($this->getError())) {
			$this->setOrderCode($result->OrderCode);
		}

		return $result;
	}

	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		$result = [
			"Amount" => $this->amount,
			"SourceCode" => $this->sourceCode,
			"MaxInstallments" => $this->maxInstallments
		];

		if ($this->isPreAuth) {
			$result["IsPreAuth"] = $this->isPreAuth;
		}

		return $result;
	}
}