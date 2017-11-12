<?php

namespace pxgamer\CryptoCheck\Commands;

use pxgamer\CryptoCheck\Wallet;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class WalletRemove
 */
class WalletRemove extends Command
{
    public function configure()
    {
        $this->setName('wallet:remove')
            ->setDescription('Removed a wallet from your config.')
            ->addOption(
                'skip-validation',
                null,
                InputOption::VALUE_NONE,
                'Skips the address validation process.'
            )
            ->addArgument(
                'type',
                InputArgument::REQUIRED,
                'The wallet type to be removed.'
            )
            ->addArgument(
                'address',
                InputArgument::REQUIRED,
                'The wallet address to be removed.'
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
        $type = $input->getArgument('type');

        if (Wallet::remove($address, $type)) {
            $this->output->success('Wallet removed successfully.');
        } else {
            $this->output->error('Failed to remove wallet.');
        }
    }
}
