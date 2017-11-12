<?php

namespace pxgamer\CryptoCheck\Commands;

use pxgamer\CryptoCheck\Wallet;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class WalletList
 */
class WalletList extends Command
{
    public function configure()
    {
        $this->setName('wallet:list')
            ->setDescription('List wallets in your config.')
            ->addOption(
                'type',
                't',
                InputOption::VALUE_REQUIRED,
                'The wallet type. (Defaults to Ethereum.)'
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

        $wallets = Wallet::list($type);

        foreach ($wallets as $type => $addresses) {
            $this->output->writeln('<comment> '.$type.'</comment>');
            foreach ($addresses as $address => $description) {
                $this->output->writeLn(
                    ' '.$address.
                    ($description ? ' ('.$description.')' : '')
                );
            }
        }
    }
}
