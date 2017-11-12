<?php

namespace pxgamer\CryptoCheck;

use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    const VALID_BTC_ADDRESS = '3MZmTtzaxPKba7V5fffsuE6dFuztqdxKoE';
    const VALID_ETH_ADDRESS = '0x738a4a2bCdD9Eec0dCF4cc919D183Cd1d23492Fa';

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
     * Test that the validate() method throws an exception on an invalid address.
     * @throws \Exception
     */
    public function testThrowExceptionOnInvalidBitcoinAddress()
    {
        $this->expectException(Exceptions\InvalidAddressFormatException::class);
        Wallet::validate('3MZmTtzaxPKb2a7V5fffsuE6dFr21rqdxKoE', Wallet::BITCOIN);
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
}
