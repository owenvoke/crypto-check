<?php

namespace pxgamer\CryptoCheck;

use PHPUnit\Framework\TestCase;
use pxgamer\CryptoCheck\Exceptions;

/**
 * Class BalancesTest
 */
class BalancesTest extends TestCase
{
    /**
     * Test that the balance can be fetched for wallets.
     * @throws \Exception
     */
    public function testCanFetchBalances()
    {
        $balances = Balances::fetch();

        $this->assertInternalType('array', $balances);
    }

    /**
     * Test that the fetch() method throws an exception on an invalid coin type.
     * @throws \Exception
     */
    public function testThrowExceptionOnInvalidCoinType()
    {
        $this->expectException(Exceptions\InvalidWalletTypeException::class);
        Balances::fetch('Botchain');
    }

    /**
     * Test that the fetch() method throws an exception on an invalid Bitcoin address.
     * @throws \Exception
     */
    public function testThrowExceptionOnInvalidBitcoinAddress()
    {
        $this->expectException(Exceptions\WalletNotFoundException::class);
        Balances::fetch(Wallet::BITCOIN, WalletTest::INVALID_ADDRESS);
    }

    /**
     * Test that the fetch() method throws an exception on an invalid Ethereum address.
     * @throws \Exception
     */
    public function testThrowExceptionOnInvalidEthereumAddress()
    {
        $this->expectException(Exceptions\WalletNotFoundException::class);
        Balances::fetch(Wallet::ETHEREUM, WalletTest::INVALID_ADDRESS);
    }

    /**
     * Test that the fetch() method throws an exception on an invalid Dash address.
     * @throws \Exception
     */
    public function testThrowExceptionOnInvalidDashAddress()
    {
        $this->expectException(Exceptions\WalletNotFoundException::class);
        Balances::fetch(Wallet::DASH, WalletTest::INVALID_ADDRESS);
    }

    /**
     * Test that the convertToSimpleString() method throws an exception on an invalid Dash address.
     * @throws \Exception
     */
    public function testCanRetreiveSimpleStringForEthereum()
    {
        $result = Balances::convertToSimpleString(
            2502490472000000000,
            Wallet::ETHEREUM
        );

        $this->assertEquals('2.502490472 ETH', $result);
    }

    /**
     * Test that the convertToSimpleString() method throws an exception on an invalid wallet type.
     * @throws \Exception
     */
    public function testThrowExceptionOnInvalidWalletConversion()
    {
        $this->expectException(Exceptions\InvalidWalletTypeException::class);
        Balances::convertToSimpleString(2502490472000000000, 'invalid');
    }
}
