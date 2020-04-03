<?php namespace ATDev\Viva\Transaction;

/**
 * An class which represents customer
 */
class Customer implements \JsonSerializable {

	/** @var string Customer email */
	private $email;

	/** @var string Customer phone */
	private $phone;

	/** @var string Customer full name */
	private $fullName;

	/** @var string Customer request language */
	private $requestLang;

	/** @var string Customer country code */
	private $countryCode;

	/**
	 * Sets email
	 *
	 * @param string $email
	 *
	 * @return \ATDev\Viva\Transaction\Customer
	 */
	public function setEmail($email) {

		$this->email = $email;

		return $this;
	}

	/**
	 * Gets email
	 *
	 * @return string
	 */
	public function getEmail() {

		return $this->email;
	}

	/**
	 * Sets phone
	 *
	 * @param string $phone
	 *
	 * @return \ATDev\Viva\Transaction\Customer
	 */
	public function setPhone($phone) {

		$this->phone = $phone;

		return $this;
	}

	/**
	 * Gets phone
	 *
	 * @return string
	 */
	public function getPhone() {

		return $this->phone;
	}

	/**
	 * Sets full name
	 *
	 * @param string $fullName
	 *
	 * @return \ATDev\Viva\Transaction\Customer
	 */
	public function setFullName($fullName) {

		$this->fullName = $fullName;

		return $this;
	}

	/**
	 * Gets full name
	 *
	 * @return string
	 */
	public function getFullName() {

		return $this->fullName;
	}

	/**
	 * Sets request language
	 *
	 * @param string $requestLang
	 *
	 * @return \ATDev\Viva\Transaction\Customer
	 */
	public function setRequestLang($requestLang) {

		$this->requestLang = $requestLang;

		return $this;
	}

	/**
	 * Gets request language
	 *
	 * @return string
	 */
	public function getRequestLang() {

		return $this->requestLang;
	}

	/**
	 * Sets country code
	 *
	 * @param string $countryCode
	 *
	 * @return \ATDev\Viva\Transaction\Customer
	 */
	public function setCountryCode($countryCode) {

		$this->countryCode = $countryCode;

		return $this;
	}

	/**
	 * Gets country code
	 *
	 * @return string
	 */
	public function getCountryCode() {

		return $this->countryCode;
	}

	/**
	 * Specifies what has to be returned on serialization to json
	 *
	 * @return array Data to serialize
	 */
	public function jsonSerialize() {

		$result = [];

		if (!empty($this->getEmail())) {
			$result['email'] = $this->getEmail();
		}

		if (!empty($this->getPhone())) {
			$result['phone'] = $this->getPhone();
		}

		if (!empty($this->getFullName())) {
			$result['fullname'] = $this->getFullName();
		}

		if (!empty($this->getRequestLang())) {
			$result['requestLang'] = $this->getRequestLang();
		}

		if (!empty($this->getCountryCode())) {
			$result['countryCode'] = $this->getCountryCode();
		}

		return $result;
	}
}