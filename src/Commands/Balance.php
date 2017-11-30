<?php

namespace pxgamer\CryptoCheck\Commands;

use pxgamer\CryptoCheck\Balances;
use pxgamer\CryptoCheck\Currency;
use pxgamer\CryptoCheck\Wallet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Balance
 */
class Balance extends Command
{
    public function configure()
    {
        $this->setName('balance')
             ->setDescription('List the balance for wallets in your config.')
             ->addOption(
                 'type',
                 't',
                 InputOption::VALUE_REQUIRED,
                 'The wallet type. (Defaults to Ethereum.)'
             )
             ->addOption(
                 'address',
                 'a',
                 InputOption::VALUE_REQUIRED,
                 'The wallet address.'
             )
             ->addOption(
                 'currency',
                 'c',
                 InputOption::VALUE_REQUIRED,
                 'The specified currency.'
             );
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|null|void
     * @throws \Exception
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $type = $input->getOption('type');
        $address = $input->getOption('address');
        $currency = $input->getOption('currency');

        if ($currency) {
            $values = Currency::fetch($currency);
        }

        $balances = Balances::fetch($type, $address);

        foreach ($balances as $balanceType => $balance) {
            $this->output->writeln('<comment> '.$balanceType.'</comment>');
            $walletSymbol = Wallet::WALLET_AVAILABLE[$balanceType]['symbol'];
            foreach ($balance as $addressName => $addressBalance) {
                $walletValue = '';
                if (isset($values) && isset($values[$walletSymbol])) {
                    $walletValue = ', '.($values[$walletSymbol] * $addressBalance).' '.strtoupper($currency);
                }
                $this->output->writeln(' '.$addressName.' ('.$addressBalance.' '.$walletSymbol.$walletValue.')');
            }
        }
    }
}
