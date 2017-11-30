<?php

namespace pxgamer\CryptoCheck\Exceptions;

/**
 * Class InvalidCurrencyException
 */
class InvalidCurrencyException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'Invalid currency shortcode specified.';
}
