<?php declare(strict_types=1);

namespace AlanVdb\Test;

use Symfony\Component\Console\Command\SignalableCommandInterface as CommandInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ValidCommand2 extends Command implements CommandInterface
{
    protected static $defaultName = 'valid:command2';
    
    protected function configure(): void
    {
        $this->setName('valid:command2');
    }
    
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return Command::SUCCESS;
    }
}