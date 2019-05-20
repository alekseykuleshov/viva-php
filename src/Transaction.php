<?php namespace ATDev\Viva;

/**
 * An abstract class which handles requests to transaction api
 */
abstract class Transaction extends Request {

	/** @const string Url to required api */
	const URL = '/transactions';

	/** @var the order code to attach transaction to */
	protected $orderCode;
	/** @var the token of the card to be charged */
	protected $cardToken;
	/** @var maximum installments */
	protected $installments = 0;

	/**
	 * Sets order code
	 *
	 * @param string $orderCode Order Code
	 *
	 * @return \ATDev\Viva\Transaction
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
	 * Sets card token
	 *
	 * @param string $cardToken Order Code
	 *
	 * @return \ATDev\Viva\Transaction
	 */
	public function setCardToken($cardToken) {

		$this->cardToken = $cardToken;

		return $this;
	}

	/**
	 * Gets card token
	 *
	 * @return string
	 */
	public function getCardToken() {

		return $this->cardToken;
	}

	/**
	 * Sets maximum installments
	 *
	 * @param int $installments Maximum installments
	 *
	 * @return \ATDev\Viva\Transaction
	 */
	public function setInstallments($installments) {

		$this->installments = $installments;

		return $this;
	}

	/**
	 * Gets maximum installments
	 *
	 * @return int
	 */
	public function getInstallments() {

		return $this->installments;
	}

	/**
	 * Sends request to api
	 *
	 * @return stdClass
	 */
	public function send() {

		if (empty($this->getOrderCode())) { // Create new order if it's not specified

			$order = (new Order($this->merchantId))
				->setApiKey($this->apiKey)
				->setSourceCode($this->sourceCode)
				->setInstallments($this->installments)
				->setIsPreAuth(static::PAYMENT_METHOD_ID == 1)
				->setTestMode($this->getTestMode())
				->setAmount($this->amount);

			$result = $order->send();

			if (empty($order->getError())) {
				$this->setOrderCode($order->getOrderCode());
			} else {
				$this->error = $order->getError();
				return $result;
			}
		}

		// Transaction response example
		// stdClass Object (
		//	[Emv] => 910A1FEE5D2612BF809E3030
		//	[Amount] => 30
		//	[StatusId] => F
		//	[CurrencyCode] => 826
		//	[TransactionId] => 8e211cf1-05d0-491b-81a7-761ed329061a
		//	[ReferenceNumber] => 78732
		//	[AuthorizationId] => 078732
		//	[RetrievalReferenceNumber] => 909812078732
		//	[ErrorCode] => 0
		//	[ErrorText] =>
		//	[TimeStamp] => 2019-04-08T15:55:27.4550725+03:00
		//	[CorrelationId] =>
		//	[EventId] => 0
		//	[Success] => 1
		// )
		return parent::send();
	}

	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		$result = [
			"Amount" => $this->getAmount(),
			"OrderCode" => $this->getOrderCode(),
			"SourceCode" => $this->getSourceCode(),
			"CreditCard" => ["Token" => $this->getCardToken()],
			"Installments" => $this->getInstallments()
		];

		if (static::PAYMENT_METHOD_ID == 1) {
			$result["PaymentMethodId"] = static::PAYMENT_METHOD_ID;
		}

		return $result;
	}
}