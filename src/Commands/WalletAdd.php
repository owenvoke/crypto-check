<?php

namespace pxgamer\CryptoCheck\Commands;

use pxgamer\CryptoCheck\Config;
use pxgamer\CryptoCheck\Wallet;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class WalletAdd extends Command
{
    public function configure()
    {
        $this->setName('wallet:add')
            ->setDescription('Add a new wallet to your config.')
            ->addOption(
                'type',
                't',
                InputOption::VALUE_REQUIRED,
                'The wallet type. (Defaults to Ethereum.)'
            )
            ->addOption(
                'name',
                null,
                InputOption::VALUE_REQUIRED,
                'A custom wallet name.'
            )
            ->addOption(
                'skip-validation',
                null,
                InputOption::VALUE_NONE,
                'Skips the address validation process.'
            )
            ->addArgument(
                'address',
                InputArgument::REQUIRED,
                'The wallet address to be added.'
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

        $address = $input->getArgument('address');
        $type = $input->getOption('type') ?? 'ethereum';
        $customName = $input->getOption('name');

        if (!$input->getOption('skip-validation')) {
            Wallet::validate($address, $type);
        }

        if (Wallet::add($address, $type, $customName)) {
            $this->output->success('Wallet added successfully.');
        } else {
            $this->output->error('Failed to add wallet.');
        }
    }
}
