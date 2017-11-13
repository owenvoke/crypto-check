<?php

namespace pxgamer\CryptoCheck;

/**
 * Class Wallet
 */
class Wallet
{
    /**
     * Wallet config path
     */
    const WALLET_CONFIG = __DIR__.'/../config/wallets.json';

    // Wallet types
    const ETHEREUM = 'ethereum';
    const BITCOIN = 'bitcoin';
    const DASH = 'dash';
    const LITECOIN = 'litecoin';
    const DOGECOIN = 'dogecoin';

    /**
     * Available wallet data
     */
    const WALLET_AVAILABLE = [
        Wallet::ETHEREUM => [
            'address_format' => '/^0x[\w]{40}$/',
            'symbol' => 'ETH',
            'divider' => 1000000000000000000,
        ],
        Wallet::BITCOIN => [
            'address_format' => '/^[13][a-km-zA-HJ-NP-Z1-9]{25,34}$/',
            'symbol' => 'BTC',
            'divider' => 100000000,
        ],
        Wallet::DASH => [
            'address_format' => '/^X[1-9A-HJ-NP-Za-km-z]{33}$/',
            'symbol' => 'DASH',
            'divider' => 100000000,
        ],
        Wallet::LITECOIN => [
            'address_format' => '/^[1-9A-HJ-NP-Za-km-z]{34}$/',
            'symbol' => 'LTC',
            'divider' => 100000000,
        ],
        Wallet::DOGECOIN => [
            'address_format' => '/^D[1-9A-HJ-NP-Za-km-z]{33}$/',
            'symbol' => 'DOGE',
            'divider' => 100000000,
        ],
    ];

    /**
     * @param string $address
     * @param string $type
     * @return bool
     * @throws \Exception
     */
    public static function validate(string $address, string $type)
    {
        if (!key_exists($type, self::WALLET_AVAILABLE)) {
            throw new Exceptions\InvalidWalletTypeException();
        }

        if (!preg_match(self::WALLET_AVAILABLE[$type]['address_format'], $address)) {
            throw new Exceptions\InvalidAddressFormatException();
        }

        return true;
    }

    /**
     * @param string $address
     * @param string $type
     * @param null   $customName
     * @return bool
     */
    public static function add($address, $type, $customName = null)
    {
        $config = Wallet::read();

        $config[$type][$address] = $customName;

        return Wallet::write($config);
    }

    /**
     * @param string $address
     * @param string $type
     * @return bool
     * @throws \Exception
     */
    public static function remove($address, $type)
    {
        $config = Wallet::read();

        if (key_exists($address, $config[$type])) {
            unset($config[$type][$address]);

            return Wallet::write($config);
        }

        throw new Exceptions\WalletNotFoundException();
    }

    /**
     * @param string $type
     * @return array
     */
    public static function list($type = null)
    {
        $config = Wallet::read();

        if ($type) {
            return [$type => $config[$type]] ?? [];
        }

        return $config;
    }

    /**
     * @return array
     */
    public static function read()
    {
        if (!file_exists(self::WALLET_CONFIG)) {
            file_put_contents(self::WALLET_CONFIG, '{}');
        }

        $data = file_get_contents(self::WALLET_CONFIG);
        return json_decode($data, true);
    }

    /**
     * @param array $data
     * @return bool
     */
    public static function write(array $data)
    {
        $json = json_encode($data);
        return (bool)file_put_contents(self::WALLET_CONFIG, $json);
    }
}
