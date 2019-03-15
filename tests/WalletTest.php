<?php

namespace pxgamer\CryptoCheck;

use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    const VALID_BTC_ADDRESS = '3MZmTtzaxPKba7V5fffsuE6dFuztqdxKoE';
    const VALID_ETH_ADDRESS = '0x738a4a2bCdD9Eec0dCF4cc919D183Cd1d23492Fa';
    const VALID_DASH_ADDRESS = 'XxiPH764eZfJR3dt4XjApdHoUEptrqcn8k';
    const VALID_LITECOIN_ADDRESS = 'LPJmhoT2c4YG79Jd2zqAe4ze9m966qv2B9';
    const VALID_DOGECOIN_ADDRESS = 'D596vyvpytFZRpVQpHwQ2gzy7J8CV6nMJv';
    const INVALID_ADDRESS = '3MZmTtzap1JLPKb2a7V5fffsuE6dFr21rqdxKoE';

    /**
     * @test
     * @throws \Exception
     */
    public function itCanCreateAFileOnRead(): void
    {
        Wallet::read();
        $this->assertFileExists(Wallet::WALLET_CONFIG);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidCoinType(): void
    {
        $this->expectException(Exceptions\InvalidWalletTypeException::class);
        Wallet::validate(self::VALID_BTC_ADDRESS, 'Botchain');
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidBitcoinAddress(): void
    {
        $this->expectException(Exceptions\InvalidAddressFormatException::class);
        Wallet::validate(self::INVALID_ADDRESS, Wallet::BITCOIN);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidEthereumAddress(): void
    {
        $this->expectException(Exceptions\InvalidAddressFormatException::class);
        Wallet::validate(self::INVALID_ADDRESS, Wallet::ETHEREUM);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidDashAddress(): void
    {
        $this->expectException(Exceptions\InvalidAddressFormatException::class);
        Wallet::validate(self::INVALID_ADDRESS, Wallet::DASH);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidLitecoinAddress(): void
    {
        $this->expectException(Exceptions\InvalidAddressFormatException::class);
        Wallet::validate(self::INVALID_ADDRESS, Wallet::LITECOIN);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itThrowsAnExceptionOnInvalidDogecoinAddress(): void
    {
        $this->expectException(Exceptions\InvalidAddressFormatException::class);
        Wallet::validate(self::INVALID_ADDRESS, Wallet::DOGECOIN);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itWillReturnTrueOnValidBitcoinAddress(): void
    {
        $result = Wallet::validate(self::VALID_BTC_ADDRESS, Wallet::BITCOIN);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itWillReturnTrueOnValidEthereumAddress(): void
    {
        $result = Wallet::validate(self::VALID_ETH_ADDRESS, Wallet::ETHEREUM);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itWillReturnTrueOnValidDashAddress(): void
    {
        $result = Wallet::validate(self::VALID_DASH_ADDRESS, Wallet::DASH);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itWillReturnTrueOnValidLitecoinAddress(): void
    {
        $result = Wallet::validate(self::VALID_LITECOIN_ADDRESS, Wallet::LITECOIN);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itWillReturnTrueOnValidDogecoinAddress(): void
    {
        $result = Wallet::validate(self::VALID_DOGECOIN_ADDRESS, Wallet::DOGECOIN);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itCanAddABitcoinAddress(): void
    {
        $result = Wallet::add(self::VALID_BTC_ADDRESS, Wallet::BITCOIN);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itCanRemoveABitcoinAddress(): void
    {
        $result = Wallet::remove(self::VALID_BTC_ADDRESS, Wallet::BITCOIN);

        $this->assertTrue($result);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itCanRemoveANonExistentBitcoinAddress(): void
    {
        $this->expectException(Exceptions\WalletNotFoundException::class);
        Wallet::remove(self::INVALID_ADDRESS, Wallet::BITCOIN);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function itCanListAllWalletAddresses(): void
    {
        $result = Wallet::list(Wallet::BITCOIN);
        $this->assertIsArray($result);

        $result = Wallet::list();
        $this->assertIsArray($result);
    }
}
