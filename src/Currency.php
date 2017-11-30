<?php

namespace pxgamer\CryptoCheck;

use GuzzleHttp\Client;
use pxgamer\CryptoCheck\Exceptions\InvalidCurrencyException;

/**
 * Class Currency
 */
class Currency
{
    /**
     * A list of the valid currency short codes for CoinMarketCap.
     */
    const VALID_CURRENCIES = [
        "aud",
        "brl",
        "cad",
        "chf",
        "clp",
        "cny",
        "czk",
        "dkk",
        "eur",
        "gbp",
        "hkd",
        "huf",
        "idr",
        "ils",
        "inr",
        "jpy",
        "krw",
        "mxn",
        "myr",
        "nok",
        "nzd",
        "php",
        "pkr",
        "pln",
        "rub",
        "sek",
        "sgd",
        "thb",
        "try",
        "twd",
        "usd",
        "zar",
    ];
    /**
     * The base API endpoint for the ticker.
     */
    const BASE_URI = 'https://api.coinmarketcap.com/v1/ticker/';
    /**
     * The path to store currency JSON files in.
     */
    const CURRENCY_DIR = __DIR__.'/../currencies/';

    /**
     * Fetch currency details for the specified currency.
     *
     * @param string $shortCode
     * @param int    $limit
     *
     * @return mixed
     *
     * @throws \Exception
     */
    public static function fetch(string $shortCode, int $limit = 100)
    {
        $shortCode = strtolower($shortCode);
        if (!in_array($shortCode, Currency::VALID_CURRENCIES)) {
            throw new InvalidCurrencyException();
        }

        $currencyFile = self::CURRENCY_DIR.$shortCode.'.json';

        if (file_exists($currencyFile) && (time() - filemtime($currencyFile)) < 300) {
            return json_decode(
                file_get_contents($currencyFile),
                true
            );
        }

        $client = new Client([
            'base_uri' => Currency::BASE_URI,
        ]);

        $options = [
            'query' => [
                'limit'   => $limit,
                'convert' => $shortCode,
            ],
        ];

        $response = \GuzzleHttp\json_decode(
            $client->get('', $options)
                   ->getBody()
                   ->getContents()
        );

        $currencies = [];

        foreach ($response as $currency) {
            $currencies[$currency->symbol] = (double)$currency->{'price_'.$shortCode};
        }

        if (!is_dir(Currency::CURRENCY_DIR)) {
            mkdir(Currency::CURRENCY_DIR);
        }

        file_put_contents($currencyFile, \GuzzleHttp\json_encode($currencies));

        return $currencies;
    }
}
