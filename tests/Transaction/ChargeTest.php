<?php namespace ATDev\Viva\Tests\Transaction;

use \PHPUnit\Framework\TestCase;
use \AspectMock\Test as test;

use \ATDev\Viva\Transaction\Charge;
use \ATDev\Viva\Transaction\Customer;
use \ATDev\Viva\Tests\Fixture;

class ChargeTest extends TestCase {

	public function testClientId() {

		$charge = new Charge();

		$result = $charge->setClientId(123);
		$this->assertFalse($result);

		$result = $charge->setClientId("asd");
		$this->assertInstanceOf(Charge::class, $result);
		$this->assertSame("asd", $result->getClientId());

		return $result;
	}

	/**
	 * @depends testClientId
	 */
	public function testClientSecret($charge) {

		$result = $charge->setClientSecret(123);
		$this->assertFalse($result);

		$result = $charge->setClientSecret("zxc");
		$this->assertInstanceOf(Charge::class, $result);
		$this->assertSame("zxc", $result->getClientSecret());

		return $result;
	}

	/**
	 * @depends testClientSecret
	 */
	public function testTestMode($charge) {

		$result = $charge->setTestMode(123);
		$this->assertFalse($result);

		$result = $charge->setTestMode(true);
		$this->assertInstanceOf(Charge::class, $result);
		$this->assertTrue($result->getTestMode());

		return $result;
	}

	/**
	 * @depends testTestMode
	 */
	public function testSourceCode($charge) {

		// Is not int or string
		$result = $charge->setSourceCode(new \stdClass());
		$this->assertFalse($result);

		// String
		$result = $charge->setSourceCode("1234");
		$this->assertInstanceOf(Charge::class, $result);
		$this->assertSame("1234", $result->getSourceCode());

		// Int
		$result = $charge->setSourceCode(4321);
		$this->assertInstanceOf(Charge::class, $result);
		$this->assertSame("4321", $result->getSourceCode());

		return $result;
	}

	/**
	 * @depends testSourceCode
	 */
	public function testAmount($charge) {

		$result = $charge->setAmount("1230");
		$this->assertFalse($result);

		$result = $charge->setAmount(1230);
		$this->assertInstanceOf(Charge::class, $result);
		$this->assertSame(1230, $result->getAmount());

		return $result;
	}

	/**
	 * @depends testAmount
	 */
	public function testCustomer($charge) {

		$result = $charge->setCustomer("1230");
		$this->assertFalse($result);

		$customer = new Customer();
		$result = $charge->setCustomer($customer);
		$this->assertInstanceOf(Charge::class, $result);
		$this->assertSame($customer, $result->getcustomer());

		return $result;
	}

	/**
	 * @depends testCustomer
	 */
	public function testChargeToken($charge) {

		$result = $charge->setChargeToken(1230);
		$this->assertFalse($result);

		$result = $charge->setChargeToken("1230");
		$this->assertInstanceOf(Charge::class, $result);
		$this->assertSame("1230", $result->getChargeToken());

		return $result;
	}

	/**
	 * @depends testChargeToken
	 */
	public function testInstallments($charge) {

		$result = $charge->setInstallments("5");
		$this->assertFalse($result);

		$result = $charge->setInstallments(5);
		$this->assertInstanceOf(Charge::class, $result);
		$this->assertSame(5, $result->getInstallments());

		return $result;
	}

	/**
	 * @depends testInstallments
	 */
	public function testMerchantTrns($charge) {

		$result = $charge->setMerchantTrns(1230);
		$this->assertFalse($result);

		$result = $charge->setMerchantTrns("1230");
		$this->assertInstanceOf(Charge::class, $result);
		$this->assertSame("1230", $result->getMerchantTrns());

		return $result;
	}

	/**
	 * @depends testMerchantTrns
	 */
	public function testCustomerTrns($charge) {

		$result = $charge->setCustomerTrns(1230);
		$this->assertFalse($result);

		$result = $charge->setCustomerTrns("1230");
		$this->assertInstanceOf(Charge::class, $result);
		$this->assertSame("1230", $result->getCustomerTrns());

		return $result;
	}

	protected function tearDown(): void {

		test::clean(); // remove all registered test doubles
	}
}