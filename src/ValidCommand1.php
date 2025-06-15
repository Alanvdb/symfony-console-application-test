<?php declare(strict_types=1);

namespace AlanVdb\Test;

use Symfony\Component\Console\Command\SignalableCommandInterface as CommandInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ValidCommand1 extends Command implements CommandInterface
{
    protected static $defaultName = 'valid:command1';
    
    protected function configure(): void
    {
        $this->setName('valid:command1');
    }
    
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return Command::SUCCESS;
    }
}