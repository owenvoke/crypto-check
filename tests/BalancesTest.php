<?php

namespace pxgamer\CryptoCheck;

use PHPUnit\Framework\TestCase;
use pxgamer\CryptoCheck\Exceptions;

class BalancesTest extends TestCase
{
    /**
     * @test
     * @throws \Exception
     */
    public function testCanFetchBalances(): void
    {
        $balances = Balances::fetch();

        $this->assertInternalType('array', $balances);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidCoinType(): void
    {
        $this->expectException(Exceptions\InvalidWalletTypeException::class);
        Balances::fetch('Botchain');
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidBitcoinAddress(): void
    {
        $this->expectException(Exceptions\WalletNotFoundException::class);
        Balances::fetch(Wallet::BITCOIN, WalletTest::INVALID_ADDRESS);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidEthereumAddress(): void
    {
        $this->expectException(Exceptions\WalletNotFoundException::class);
        Balances::fetch(Wallet::ETHEREUM, WalletTest::INVALID_ADDRESS);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidDashAddress(): void
    {
        $this->expectException(Exceptions\WalletNotFoundException::class);
        Balances::fetch(Wallet::DASH, WalletTest::INVALID_ADDRESS);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidLitecoinAddress(): void
    {
        $this->expectException(Exceptions\WalletNotFoundException::class);
        Balances::fetch(Wallet::LITECOIN, WalletTest::INVALID_ADDRESS);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidDogecoinAddress(): void
    {
        $this->expectException(Exceptions\WalletNotFoundException::class);
        Balances::fetch(Wallet::DOGECOIN, WalletTest::INVALID_ADDRESS);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itCanRetreiveASimpleStringForEthereum(): void
    {
        $result = Balances::convertToSimpleString(
            2502490472000000000,
            Wallet::ETHEREUM
        );

        $this->assertEquals('2.502490472 ETH', $result);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidWalletConversion(): void
    {
        $this->expectException(Exceptions\InvalidWalletTypeException::class);
        Balances::convertToSimpleString(2502490472000000000, 'invalid');
    }
}
