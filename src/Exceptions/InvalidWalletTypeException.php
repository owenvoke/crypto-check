<?php

namespace pxgamer\CryptoCheck\Exceptions;

/**
 * Class InvalidWalletTypeException
 */
class InvalidWalletTypeException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'Invalid wallet type specified.';
}
