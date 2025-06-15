<?php declare(strict_types=1);

namespace AlanVdb\Console\Factory\Tests;

use AlanVdb\Console\Factory\SymfonyConsoleApplicationFactory;
use AlanVdb\Console\Definition\ConsoleApplicationInterface;
use AlanVdb\Console\Definition\CommandInterface;
use AlanVdb\Console\SymfonyConsoleApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use PHPUnit\Framework\TestCase;

class SymfonyConsoleApplicationFactoryTest extends TestCase
{
    public function testCreateConsoleApplicationReturnsCorrectInstance(): void
    {
        $factory = new SymfonyConsoleApplicationFactory();
        $application = $factory->createConsoleApplication('TestApp', '1.0.0');
        
        $this->assertInstanceOf(ConsoleApplicationInterface::class, $application);
        $this->assertInstanceOf(SymfonyConsoleApplication::class, $application);
    }

    public function testConstructorArgumentsArePassedCorrectly(): void
    {
        $factory = new SymfonyConsoleApplicationFactory();
        
        $name = 'MyApp';
        $version = '3.2.1';
        $commands = [ValidCommand1::class, ValidCommand2::class];
        
        $application = $factory->createConsoleApplication($name, $version, ...$commands);
        
        $this->assertSame($name, $application->getName());
        $this->assertSame($version, $application->getVersion());
        
        $this->assertTrue($application->has('valid:command1'));
        $this->assertTrue($application->has('valid:command2'));
    }

    public function testInvalidCommandThrowsException(): void
    {
        $factory = new SymfonyConsoleApplicationFactory();
        
        $this->expectException(\AlanVdb\Console\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('Provided class does not exists : "InvalidCommand".');
        
        $factory->createConsoleApplication('App', '1.0', 'InvalidCommand');
    }

    public function testCommandNotImplementingInterfaceThrowsException(): void
    {
        $factory = new SymfonyConsoleApplicationFactory();
        
        $this->expectException(\AlanVdb\Console\Exception\InvalidArgumentException::class);
        $this->expectExceptionMessage('Provided class does not implements');
        $this->expectExceptionMessage('InvalidCommandImpl');
        
        $factory->createConsoleApplication('App', '1.0', InvalidCommandImpl::class);
    }
}

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

class InvalidCommandImpl extends Command
{
    protected static $defaultName = 'invalid:command';
    
    protected function configure(): void
    {
        $this->setName('invalid:command');
    }
    
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        return Command::SUCCESS;
    }
}