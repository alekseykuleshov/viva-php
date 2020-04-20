<?php namespace ATDev\Viva\Transaction;

/**
 * An abstract class which handles requests to
 */
abstract class Transaction extends Request {

	/** @const If the transaction is pre-auth */
	const PRE_AUTH = null;

	/** @const string Request method */
	const METHOD = "POST";

	/** @var \ATDev\Viva\Transaction\Customer Customer data */
	private $customer;

	/** @var string The token of the card to be charged */
	private $chargeToken;

	/** @var int Maximum installments */
	private $installments = 0;

	/** @var string Merchant transaction reference */
	private $merchantTrns;

	/** @var string Description that the customer sees */
	private $customerTrns;

	/**
	 * Sets customer
	 *
	 * @param \ATDev\Viva\Transaction\Customer $customer Customer
	 *
	 * @return \ATDev\Viva\Transaction\Transaction
	 */
	public function setCustomer($customer) {

		$this->customer = $customer;

		return $this;
	}

	/**
	 * Gets customer
	 *
	 * @return string
	 */
	public function getCustomer() {

		return $this->customer;
	}

	/**
	 * Sets charge token
	 *
	 * @param string $chargeToken Charge Token
	 *
	 * @return \ATDev\Viva\Transaction\Transaction
	 */
	public function setChargeToken($chargeToken) {

		$this->chargeToken = $chargeToken;

		return $this;
	}

	/**
	 * Gets charge token
	 *
	 * @return string
	 */
	public function getChargeToken() {

		return $this->chargeToken;
	}

	/**
	 * Sets maximum installments
	 *
	 * @param int $installments Maximum installments
	 *
	 * @return \ATDev\Viva\Transaction\Transaction
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
	 * Sets merchant transaction reference
	 *
	 * @param string $merchantTrns Merchant transaction reference
	 *
	 * @return \ATDev\Viva\Transaction\Transaction
	 */
	public function setMerchantTrns($merchantTrns) {

		$this->merchantTrns = $merchantTrns;

		return $this;
	}

	/**
	 * Gets merchant transaction reference
	 *
	 * @return string
	 */
	public function getMerchantTrns() {

		return $this->merchantTrns;
	}

	/**
	 * Sets description that the customer sees
	 *
	 * @param string $customerTrns Description that the customer sees
	 *
	 * @return \ATDev\Viva\Transaction\Transaction
	 */
	public function setCustomerTrns($customerTrns) {

		$this->customerTrns = $customerTrns;

		return $this;
	}

	/**
	 * Gets description that the customer sees
	 *
	 * @return string
	 */
	public function getCustomerTrns() {

		return $this->customerTrns;
	}

	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		$result = [
			"amount" => $this->getAmount(),
			"preauth" => static::PRE_AUTH,
			"sourceCode" => $this->getSourceCode(),
			"chargeToken" => $this->getChargeToken(),
		];

		if (!empty($this->getInstallments())) {
			$result['installments'] = $this->getInstallments();
		}

		if (!empty($this->getMerchantTrns())) {
			$result['merchantTrns'] = $this->getMerchantTrns();
		}

		if (!empty($this->getCustomerTrns())) {
			$result['customerTrns'] = $this->getCustomerTrns();
		}

		$customer = $this->getCustomer();
		if ((!empty($customer)) && (!empty($customer->getEmail()))) {
			$result['customer'] = $customer;
		}

		return $result;
	}
}