<?php

namespace pxgamer\CryptoCheck\Commands;

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class Command
 */
class Command extends SymfonyCommand
{
    /**
     * @var SymfonyStyle
     */
    protected $output;

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = new SymfonyStyle($input, $output);
    }
}
