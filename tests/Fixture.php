<?php namespace ATDev\Viva\Tests;

use \Psr\Http\Message\ResponseInterface;

/**
 * Fixture class to stub methods of classes returned from libraries
 */
class Fixture implements ResponseInterface {

	private $statusCode;
	private $contents;

	public function getStatusCode() {

		return $this->statusCode;
	}

	public function setStatusCode($statusCode) {

		$this->statusCode = $statusCode;
	}

	public function getContents() {

		return $this->contents;
	}

	public function setContents($contents) {

		$this->contents = $contents;
	}

	public function getBody() {

		return $this;
	}

	// Just fake all these
	public function getProtocolVersion() {}

	public function withProtocolVersion($version) {}

	public function getHeaders() {}

	public function hasHeader($name) {}

	public function getHeader($name) {}

	public function getHeaderLine($name) {}

	public function withHeader($name, $value) {}

	public function withAddedHeader($name, $value) {}

	public function withoutHeader($name) {}

	public function withBody($body) {}

	public function withStatus($code, $reasonPhrase = '') {}

	public function getReasonPhrase() {}
}