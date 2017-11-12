<?php

namespace pxgamer\CryptoCheck;

use EtherScan\EtherScan;
use EtherScan\Modules\Account;
use EtherScan\Resources\ApiConnector;
use pxgamer\CryptoCheck\Exceptions\InvalidWalletTypeException;
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

        throw new InvalidWalletTypeException();
    }

    /**
     * @param string $type
     * @param array  $addresses
     * @return array
     */
    public static function getAddressBalances($type, $addresses)
    {
        $balances = [];
        $addressesSwitched = array_keys($addresses);

        foreach (array_chunk($addressesSwitched, 20) as $addressChunk) {
            switch ($type) {
                case 'ethereum':
                    $apiConnector = new ApiConnector(getenv('ETHERSCAN_API_KEY'));
                    $account = new Account($apiConnector, EtherScan::PREFIX_API);

                    $result = json_decode($account->getBalances($addressChunk), true);
                    $balances = array_merge($balances, $result['result']);
                    break;
                default:
            }
        }

        return $balances;
    }
}
