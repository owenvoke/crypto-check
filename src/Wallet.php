<?php

namespace pxgamer\CryptoCheck;

/**
 * Class Wallet
 */
class Wallet
{
    const WALLET_CONFIG = __DIR__.'/../config/wallets.json';
    const WALLET_AVAILABLE = [
        'ethereum' => '/0x[\w]{40}/',
    ];

    /**
     * @param string $address
     * @param string $type
     * @throws \Exception
     */
    public static function validate(string $address, string $type)
    {
        if (!key_exists($type, self::WALLET_AVAILABLE)) {
            throw new Exceptions\InvalidWalletTypeException();
        }

        if (!preg_match(self::WALLET_AVAILABLE[$type], $address)) {
            throw new Exceptions\InvalidAddressFormatException();
        }
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
     * @return array
     */
    public static function read()
    {
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
        return file_put_contents(self::WALLET_CONFIG, $json);
    }
}
