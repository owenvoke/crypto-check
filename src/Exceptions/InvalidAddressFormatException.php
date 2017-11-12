<?php

namespace pxgamer\CryptoCheck\Exceptions;

/**
 * Class InvalidAddressFormatException
 */
class InvalidAddressFormatException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'Invalid address format specified.';
}
