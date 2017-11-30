<?php

namespace pxgamer\CryptoCheck;

use PHPUnit\Framework\TestCase;
use pxgamer\CryptoCheck\Exceptions\InvalidCurrencyException;

/**
 * Class CurrencyTest
 */
class CurrencyTest extends TestCase
{
    /**
     * Test that the fetch() method throws an exception on an invalid currency short code.
     * @throws \Exception
     */
    public function testThrowExceptionOnInvalidShortCode()
    {
        $this->expectException(InvalidCurrencyException::class);

        Currency::fetch('INVALID');
    }

    /**
     * Test that the fetch() method  returns a correctly formatted stdClass for the USD currency.
     * @throws \Exception
     */
    public function testCanRetrieveUnitedStatesDollarValues()
    {
        $result = Currency::fetch('USD');

        $this->assertInternalType('array', $result);
    }

    /**
     * Test that the fetch() method  returns a correctly formatted stdClass for non-USD currencies.
     * @throws \Exception
     */
    public function testCanRetrieveGreatBritishPoundValues()
    {
        $result = Currency::fetch('GBP');

        $this->assertInternalType('array', $result);
    }
}
