<?php namespace ATDev\Viva\Tests\Account;

use \PHPUnit\Framework\TestCase;
use \ATDev\Viva\Account\Authorization;

class AuthorizationTest extends TestCase {

	public function testClientId() {

		$auth = new Authorization();

		$result = $auth->setClientId(123);
		$this->assertFalse($result);

		$result = $auth->setClientId("asd");
		$this->assertInstanceOf(Authorization::class, $result);
		$this->assertSame("asd", $result->getClientId());

		return $result;
	}

    /**
     * @depends testClientId
     */
	public function testClientSecret($auth) {

		$result = $auth->setClientSecret(123);
		$this->assertFalse($result);

		$result = $auth->setClientSecret("zxc");
		$this->assertInstanceOf(Authorization::class, $result);
		$this->assertSame("zxc", $result->getClientSecret());

		return $result;
	}

    /**
     * @depends testClientSecret
     */
	public function testTestMode($auth) {

		$result = $auth->setTestMode(123);
		$this->assertFalse($result);

		$result = $auth->setTestMode(true);
		$this->assertInstanceOf(Authorization::class, $result);
		$this->assertTrue($result->getTestMode());

		return $result;
	}
}