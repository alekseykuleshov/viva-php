# Viva Wallet Native Checkout V2 API PHP Wrapper Library

This is a wrapper for Native Checkout V2 API of Viva Wallet.
Only 4 credit card transaction types are supported now: (Charge, Auth, Capture, Cancel).

## How to use

This library is installed via [Composer](http://getcomposer.org/). You will need to require `atdev/viva-php`:

```
composer require atdev/viva-php:1.0.0
```

## Prerequisites

Complete prerequisite steps from https://developer.vivawallet.com/online-checkouts/native-checkout-v2/ and obtain your `Client ID` and `Client Secret`.
You'll need to set up a payment source with Native Checkout V2  as the integration method and get a `Source Code`.

## Get card charge token

Create payment form and `Charge Token` at front end as described here: https://developer.vivawallet.com/online-checkouts/native-checkout-v2/
You'll need to have `Access Token` and `Base URL` at front end and you can get them as follows:

```php
$baseUrl = \ATDev\Viva\Transaction\Url::getUrl("[Test Mode]"); // Test mode, default is false

$accessToken = (new \ATDev\Viva\Transaction\Authorization())
	->setClientId("[Client ID]") // Client ID, Provided by wallet
	->setClientSecret("[Client Secret]") // Client Secret, Provided by wallet
	->setTestMode("[Test Mode]") // Test mode, default is false, can be skipped
	->getAccessToken();
```

Now, when you have `Charge Token` you can make actual transactions.

## Transactions

### CHARGE

```php
$customer = (new \ATDev\Viva\Transaction\Customer())
	->setEmail("[Customer Email]")
	->setPhone("[Customer Phone]")
	->setFullName("[Customer Full Name]");

$transaction = (new ATDev\Viva\Transaction\Charge())
	->setClientId("[Client ID]") // Client ID, Provided by wallet
	->setClientSecret("[Client Secret]") // Client Secret, Provided by wallet
	->setTestMode("[Test Mode]") // Test mode, default is false, can be skipped
	->setSourceCode("[Source Code]") // Source code, provided by wallet
	->setAmount("[Amount]") // The amount to charge in currency's smallest denomination (e.g amount in pounds x 100)
	->setChargeToken("[Charge Token]") // Charge token obtained at front end
	->setCustomer($customer);

$result = $transaction->send();

if (!empty($transaction->getError())) {

	// Log the error message
	// $error = $transaction->getError();

} else {

	// Save transaction id
	// $transactionId = $result->transactionId;
}
```

### AUTHORIZATION

```php
$customer = (new \ATDev\Viva\Transaction\Customer())
	->setEmail("[Customer Email]")
	->setPhone("[Customer Phone]")
	->setFullName("[Customer Full Name]");

$transaction = (new ATDev\Viva\Transaction\Authorization())
	->setClientId("[Client ID]") // Client ID, Provided by wallet
	->setClientSecret("[Client Secret]") // Client Secret, Provided by wallet
	->setTestMode("[Test Mode]") // Test mode, default is false, can be skipped
	->setSourceCode("[Source Code]") // Source code, provided by wallet
	->setAmount("[Amount]") // The amount to pre-auth in currency's smallest denomination (e.g amount in pounds x 100)
	->setChargeToken("[Charge Token]") // Charge token obtained at front end
	->setCustomer($customer);

$result = $transaction->send();

if (!empty($transaction->getError())) {

	// Log the error message
	// $error = $transaction->getError();

} else {

	// Save transaction id
	// $transactionId = $result->transactionId;
}
```

### CAPTURE

Make sure you have recurring payments enabled in your account.

```php
$transaction = (new \ATDev\Viva\Transaction\Capture())
	->setClientId("[Client ID]") // Client ID, Provided by wallet
	->setClientSecret("[Client Secret]") // Client Secret, Provided by wallet
	->setTestMode("[Test Mode]") // Test mode, default is false, can be skipped
	->setTransactionId("[Transaction ID]") // Transaction id of authorization transaction
	->setAmount("[Amount]"); // The amount to capture in currency's smallest denomination (e.g amount in pounds x 100)

$result = $transaction->send();

if (!empty($transaction->getError())) {

	// Log the error message
	// $error = $transaction->getError();
} else {

	// Save transaction id
	// $transactionId = $result->transactionId;
}
```

### CANCEL

Make sure you have refunds enabled in your account.

```php
$transaction = (new \ATDev\Viva\Transaction\Cancel())
	->setClientId("[Client ID]") // Client ID, Provided by wallet
	->setClientSecret("[Client Secret]") // Client Secret, Provided by wallet
	->setTestMode("[Test Mode]") // Test mode, default is false, can be skipped
	->setSourceCode("[Source Code]") // Source code, provided by wallet
	->setTransactionId("[Transaction ID]") // Transaction id of charge, authorization or capture transaction
	->setAmount("[Amount]"); // The amount to refund in currency's smallest denomination (e.g amount in pounds x 100)

$result = $transaction->send();

if (!empty($transaction->getError())) {

	// Log the error message
	// $error = $transaction->getError();
} else {

	// Save transaction id
	// $transactionId = $result->transactionId;
}
```

## Unit tests

Tests are run by `./vendor/bin/phpunit tests`. Although the library code is designed to be compatible with `php 5.6`, testing
requires `php 7.3` as minimum because of `phpunit` version `9`.