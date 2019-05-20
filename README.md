# Viva Wallet Native Checkout REST API PHP SDK

This is SDK for Native Checkout REST API of Viva Wallet.
Only 4 credit card transaction types are supported now: (Charge, Auth, Capture, Cancel).

## How to use

This sdk is installed via [Composer](http://getcomposer.org/). To install, simply add it to your `composer.json` file:

```json
{
    "require": {
        "atdev/viva-php": "0.1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

Then, import the `autoload.php` from your `vendor` folder.

## Sample calls

### CHARGE

```php
$transaction = (new \ATDev\Viva\Charge("MERCHANT_ID")) // Provided by wallet
	->setApiKey("API_KEY") // Provided by wallet
	->setSourceCode("SOURCE_CODE") // Provided by wallet
	->setAmount("AMOUNT") // The amount requested in cents
	->setCardToken("CARD_TOKEN"); // Card token received from wallet, see https://developer.vivawallet.com/online-checkouts/native-checkout-v1/

$result = $transaction->send();

if (!empty($transaction->getError())) {

	// Log the error message
	// $error = $transaction->getError();
} else {

	// Save order id and transaction id
	// $orderId = $transaction->getOrderCode();
	// $transactionId = $result->TransactionId;
}
```

### AUTHORIZATION

```php
$transaction = (new \ATDev\Viva\Authorization("MERCHANT_ID")) // Provided by wallet
	->setApiKey("API_KEY") // Provided by wallet
	->setSourceCode("SOURCE_CODE") // Provided by wallet
	->setAmount("AMOUNT") // The amount requested in cents
	->setCardToken("CARD_TOKEN"); // Card token received from wallet, see https://developer.vivawallet.com/online-checkouts/native-checkout-v1/

$result = $transaction->send();

if (!empty($transaction->getError())) {

	// Log the error message
	// $error = $transaction->getError();
} else {

	// Save order id and transaction id
	// $orderId = $transaction->getOrderCode();
	// $transactionId = $result->TransactionId;
}
```

### CAPTURE

Make sure you have recurring payments enabled in your account.

```php
$transaction = (new \ATDev\Viva\Capture("MERCHANT_ID")) // Provided by wallet
	->setApiKey("API_KEY") // Provided by wallet
	->setTransactionId("TRANSACTION_ID") // Transaction id obtained from authorization transaction
	->setAmount("AMOUNT"); // The amount to capture in cents

$result = $transaction->send();

if (!empty($transaction->getError())) {

	// Log the error message
	// $error = $transaction->getError();
} else {

	// Save transaction id
	// $transactionId = $result->TransactionId;
}
```

### CANCEL

Make sure you have refunds enabled in your account.

```php
$transaction = (new \ATDev\Viva\Cancel("MERCHANT_ID")) // Provided by wallet
	->setApiKey("API_KEY") // Provided by wallet
	->setTransactionId("TRANSACTION_ID") // Transaction id obtained from charge, authorization, capture transactions
	->setAmount("AMOUNT"); // The amount to capture in cents

$result = $transaction->send();

if (!empty($transaction->getError())) {

	// Log the error message
	// $error = $transaction->getError();
}
```

## Test mode

Just call `setTestMode(true)` method before calling `send()` for any transaction.

## Installments

Just call `setInstallments(INSTALLMENTS_NUMBER)` method before calling `send()` for charge, authorization, capture transactions.

## Order

Charge and authorization transaction will create order for you automatically, but of you already have order id you can set it by calling `setOrderCode("ORDER_CODE")` method before calling `send()`.