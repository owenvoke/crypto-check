<?php

namespace pxgamer\CryptoCheck;

/**
 * Class Wallet
 */
class Wallet
{
    const WALLET_CONFIG = __DIR__.'/../config/wallets.json';

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
