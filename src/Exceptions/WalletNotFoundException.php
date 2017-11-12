<?php

namespace pxgamer\CryptoCheck\Exceptions;

/**
 * Class WalletNotFoundException
 */
class WalletNotFoundException extends \Exception
{
    /**
     * @var string
     */
    protected $message = 'The specified wallet could not be found.';
}
