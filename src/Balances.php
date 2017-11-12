<?php

namespace pxgamer\CryptoCheck;

use BlockCypher\Auth\SimpleTokenCredential;
use BlockCypher\Client\AddressClient;
use BlockCypher\Rest\ApiContext;
use pxgamer\CryptoCheck\Exceptions\WalletNotFoundException;

/**
 * Class Balances
 */
class Balances
{
    /**
     * @param $type
     * @param $address
     * @return array
     * @throws \Exception
     */
    public static function fetch($type, $address)
    {
        $config = Wallet::read();

        if ($address && $type) {
            if (key_exists($address, $config[$type])) {
                return Balances::getAddressBalances($type, [$address => null]);
            }

            throw new WalletNotFoundException();
        }

        if ($type) {
            if (key_exists($type, $config)) {
                return Balances::getAddressBalances($type, $config[$type]);
            }
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

        foreach ($addressKeys as $address) {
            switch ($type) {
                case 'ethereum':
                    $apiContext = ApiContext::create(
                        'main', 'eth', 'v1',
                        new SimpleTokenCredential(getenv('BLOCKCYPHER_KEY')),
                        $config
                    );

                    $addressClient = new AddressClient($apiContext);
                    $data = $addressClient->get($address);
                    $balances['ethereum'][$address] = self::convertToSimpleString($data->getBalance(), 'ethereum');
                    break;
                case 'bitcoin':
                    $apiContext = ApiContext::create(
                        'main', 'btc', 'v1',
                        new SimpleTokenCredential(getenv('BLOCKCYPHER_KEY')),
                        $config
                    );

                    $addressClient = new AddressClient($apiContext);
                    $data = $addressClient->get($address);
                    $balances['bitcoin'][$address] = self::convertToSimpleString($data->getBalance(), 'bitcoin');
                    break;
                default:
            }
        }

        return $balances;
    }

    /**
     * @param int    $balanceToken
     * @param string $type
     * @return string
     */
    public static function convertToSimpleString($balanceToken, $type = 'ethereum')
    {
        return ($balanceToken / Wallet::WALLET_AVAILABLE[$type]['divider']).' '.
            Wallet::WALLET_AVAILABLE[$type]['symbol'];
    }
}
