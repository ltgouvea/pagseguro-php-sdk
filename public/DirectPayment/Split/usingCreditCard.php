<?php

require_once "../../../vendor/autoload.php";

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

//Instantiate a new direct payment request, using Credit Card
$creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();

/**
 * @todo Change the receiver Email
 */
$creditCard->setReceiverEmail('vendedor@lojamodelo.com.br');

// Set a reference code for this payment request. It is useful to identify this payment
// in future notifications.
$creditCard->setReference("LIBPHP000001");

// Set the currency
$creditCard->setCurrency("BRL");

// Add an item for this payment request
$creditCard->addItems()->withParameters(
    '0001',
    'Notebook prata',
    2,
    10.00
);

// Add an item for this payment request
$creditCard->addItems()->withParameters(
    '0002',
    'Notebook preto',
    2,
    5.00
);

// Set your customer information.
// If you using SANDBOX you must use an email @sandbox.pagseguro.com.br
$creditCard->setSender()->setName('João Comprador');
$creditCard->setSender()->setEmail('email@comprador.com.br');

$creditCard->setSender()->setPhone()->withParameters(
    11,
    56273440
);

$creditCard->setSender()->setDocument()->withParameters(
    'CPF',
    '156.009.442-76'
);

$creditCard->setSender()->setHash('d94d002b6998ca9cd69092746518e50aded5a54aef64c4877ccea02573694986');

$creditCard->setSender()->setIp('127.0.0.0');

// Set shipping information for this payment request
$creditCard->setShipping()->setAddress()->withParameters(
    'Av. Brig. Faria Lima',
    '1384',
    'Jardim Paulistano',
    '01452002',
    'São Paulo',
    'SP',
    'BRA',
    'apto. 114'
);

//Set billing information for credit card
$creditCard->setBilling()->setAddress()->withParameters(
    'Av. Brig. Faria Lima',
    '1384',
    'Jardim Paulistano',
    '01452002',
    'São Paulo',
    'SP',
    'BRA',
    'apto. 114'
);

// Set credit card token
$creditCard->setToken('1fcb2333ca7c46e38089dd9f2cac525c');

// Set the installment quantity and value (could be obtained using the Installments 
// service, that have an example here in \public\getInstallments.php)
$creditCard->setInstallment()->withParameters(1, '30.00');

// Set the credit card holder information
$creditCard->setHolder()->setBirthdate('01/10/1979');
$creditCard->setHolder()->setName('João Comprador'); // Equals in Credit Card

$creditCard->setHolder()->setPhone()->withParameters(
    11,
    56273440
);

$creditCard->setHolder()->setDocument()->withParameters(
    'CPF',
    '156.009.442-76'
);

// Set the Payment Mode for this payment request
$creditCard->setMode('DEFAULT');

// Add a primary receiver for split this payment request
$creditCard->setSplit()->setPrimaryReceiver("PUBBD8F184FEE144EADA6DA746D61FAA688");

// Add an receiver for split this payment request
$creditCard->setSplit()->addReceiver()->withParameters(
    'PUBF0944ADDDD844957ABA278D8645A52C3',
    20.00,
    20,
    0
);

try {
    //Get the crendentials and register the boleto payment
    $result = $creditCard->register(
        \PagSeguro\Configuration\Configure::getApplicationCredentials()
    );
    echo "<pre>";
    print_r($result);
} catch (Exception $e) {
    echo "</br> <strong>";
    die($e->getMessage());
}
