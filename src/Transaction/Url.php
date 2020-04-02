<?php namespace ATDev\Viva\Transaction;

use \ATDev\Viva\BaseUrl;

/**
 * An url enumeration class
 */
class Url extends BaseUrl {

	/** @const Live api url */
	const LIVE_URL = 'https://api.vivapayments.com';
	/** @const Test api url */
	const TEST_URL = 'https://demo-api.vivapayments.com';
}