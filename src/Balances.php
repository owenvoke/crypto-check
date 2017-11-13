<?php

namespace pxgamer\CryptoCheck;

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\AddressClient;
use BlockCypher\Rest\ApiContext;
use pxgamer\CryptoCheck\Exceptions\InvalidWalletTypeException;
use pxgamer\CryptoCheck\Exceptions\WalletNotFoundException;

/**
 * Class Balances
 */
class Balances
{
    /**
     * @param string $type
     * @param string $address
     * @return array
     * @throws \Exception
     */
    public static function fetch($type = null, $address = null)
    {
        $config = Wallet::read();

        if ($address && $type) {
            if (key_exists($type, $config) && key_exists($address, $config[$type])) {
                return Balances::getAddressBalances($type, [$address => null]);
            }

            throw new WalletNotFoundException();
        }

        if ($type) {
            if (key_exists($type, $config)) {
                return Balances::getAddressBalances($type, $config[$type]);
            }

            throw new InvalidWalletTypeException();
        }

        $data = [];

        foreach ($config as $walletType => $addresses) {
            $data = array_merge(
                $data,
                Balances::getAddressBalances($walletType, $addresses)
            );
        }

        return $data;
    }

    /**
     * @param string $type
     * @param array  $addresses
     * @return array
     * @throws \Exception
     */
    public static function getAddressBalances($type, $addresses)
    {
        $balances = [];
        $addressKeys = array_keys($addresses);

        $config = [
            'log.LogEnabled' => false,
        ];
        $simpleTokenCredential = new SimpleTokenCredential(getenv('BLOCKCYPHER_KEY'));

        foreach ($addressKeys as $address) {
            if (key_exists($type, Wallet::WALLET_AVAILABLE)) {
                $apiContext = ApiContext::create(
                    'main',
                    strtolower(Wallet::WALLET_AVAILABLE[$type]['symbol']),
                    'v1',
                    $simpleTokenCredential,
                    $config
                );

                $addressClient = new AddressClient($apiContext);
                $data = $addressClient->get($address);
                $balances[$type][$address] = self::convertToSimpleString(
                    $data->getBalance(),
                    $type
                );
            }
        }

        return $balances;
    }

    /**
     * @param int    $balanceToken
     * @param string $type
     * @return string
     * @throws \Exception
     */
    public static function convertToSimpleString($balanceToken, $type = 'ethereum')
    {
        if (isset(Wallet::WALLET_AVAILABLE[$type])) {
            return ($balanceToken / Wallet::WALLET_AVAILABLE[$type]['divider']).' '.
                   Wallet::WALLET_AVAILABLE[$type]['symbol'];
        }

        throw new InvalidWalletTypeException();
    }
}
