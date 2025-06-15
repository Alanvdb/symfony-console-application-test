<?php declare(strict_types=1);

namespace AlanVdb\Test;

//use Symfony\Component\Console\Command\SignalableCommandInterface as CommandInterface;
//use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class InvalidCommandDoesNotImplementInterface
{
    protected static $defaultName = 'invalid:command';
    
    public function getName(): string
    {
        return 'invalid:command';
    }
    
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return Command::SUCCESS;
    }
}