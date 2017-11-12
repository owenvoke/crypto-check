<?php

namespace pxgamer\CryptoCheck\Commands;

use pxgamer\CryptoCheck\Balances;
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

        $balances = Balances::fetch($type, $address);

        $this->output->writeln('<comment> '.$type.'</comment>');
        $this->output->table(['Address', 'Balance'], $balances);
    }
}
