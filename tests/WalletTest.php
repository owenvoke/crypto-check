<?php

namespace pxgamer\CryptoCheck;

use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    const VALID_BTC_ADDRESS = '3MZmTtzaxPKba7V5fffsuE6dFuztqdxKoE';
    const VALID_ETH_ADDRESS = '0x738a4a2bCdD9Eec0dCF4cc919D183Cd1d23492Fa';
    const VALID_DASH_ADDRESS = 'XxiPH764eZfJR3dt4XjApdHoUEptrqcn8k';

    /**
     * Test that the validate() method throws an exception on an invalid coin type.
     * @throws \Exception
     */
    public function testThrowExceptionOnInvalidCoinType()
    {
        $this->expectException(Exceptions\InvalidWalletTypeException::class);
        Wallet::validate(self::VALID_BTC_ADDRESS, 'Botchain');
    }

    /**
     * Test that the validate() method throws an exception on an invalid Bitcoin address.
     * @throws \Exception
     */
    public function testThrowExceptionOnInvalidBitcoinAddress()
    {
        $this->expectException(Exceptions\InvalidAddressFormatException::class);
        Wallet::validate('3MZmTtzaxPKb2a7V5fffsuE6dFr21rqdxKoE', Wallet::BITCOIN);
    }

    /**
     * Test that the validate() method throws an exception on an invalid Ethereum address.
     * @throws \Exception
     */
    public function testThrowExceptionOnInvalidEthereumAddress()
    {
        $this->expectException(Exceptions\InvalidAddressFormatException::class);
        Wallet::validate('3MZmTtzaxPKb2a7V5fffsuE6dFr21rqdxKoE', Wallet::ETHEREUM);
    }

    /**
     * Test that the validate() method throws an exception on an invalid Dash address.
     * @throws \Exception
     */
    public function testThrowExceptionOnInvalidDashAddress()
    {
        $this->expectException(Exceptions\InvalidAddressFormatException::class);
        Wallet::validate('3MZmTtzaxPKb2a7V5fffsuE6dFr21rqdxKoE', Wallet::DASH);
    }

    /**
     * Test that the validate() method throws an exception on a valid Bitcoin address.
     * @throws \Exception
     */
    public function testReturnTrueOnValidBitcoinAddress()
    {
        $result = Wallet::validate(self::VALID_BTC_ADDRESS, Wallet::BITCOIN);

        $this->assertTrue($result);
    }

    /**
     * Test that the validate() method throws an exception on a valid Ethereum address.
     * @throws \Exception
     */
    public function testReturnTrueOnValidEthereumAddress()
    {
        $result = Wallet::validate(self::VALID_ETH_ADDRESS, Wallet::ETHEREUM);

        $this->assertTrue($result);
    }

    /**
     * Test that the validate() method throws an exception on a valid Dash address.
     * @throws \Exception
     */
    public function testReturnTrueOnValidDashAddress()
    {
        $result = Wallet::validate(self::VALID_DASH_ADDRESS, Wallet::DASH);

        $this->assertTrue($result);
    }
}
