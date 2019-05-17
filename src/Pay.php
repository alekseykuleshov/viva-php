<?php namespace ATDev\Viva;

/**
 * A class which creates authorize request
 */
class Pay extends Transaction {

	/** @const identifies transaction as pre-auth one */
	const PAYMENT_METHOD_ID = 0;
}