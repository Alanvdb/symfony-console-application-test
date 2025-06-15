<?php declare(strict_types=1);

namespace AlanVdb\Console\Tests;

use AlanVdb\Test\ValidCommand1;
use AlanVdb\Test\ValidCommand2;
use AlanVdb\Test\InvalidCommandDoesNotImplementInterface;
use AlanVdb\Console\Definition\ConsoleApplicationInterface;
use Symfony\Component\Console\Command\SignalableCommandInterface as CommandInterface;
use PHPUnit\Framework\TestCase;
use AlanVdb\Console\Factory\SymfonyConsoleApplicationFactory;
use AlanVdb\Console\SymfonyConsoleApplication;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use AlanVdb\Console\Exception\InvalidArgumentException;

class SymfonyConsoleApplicationFactoryTest extends TestCase
{
    public function testCreateConsoleApplicationReturnsCorrectInstance(): void
    {
        $factory = new SymfonyConsoleApplicationFactory();
        $application = $factory->createConsoleApplication('TestApp', '1.0.0');
        
        $this->assertInstanceOf(ConsoleApplicationInterface::class, $application);
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
        
        $this->expectException(InvalidArgumentException::class);
        
        $factory->createConsoleApplication('App', '1.0', 'InvalidCommand');
    }

    public function testCommandNotImplementingInterfaceThrowsException(): void
    {
        $factory = new SymfonyConsoleApplicationFactory();
        
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Provided class does not implements');
        $this->expectExceptionMessage('InvalidCommandDoesNotImplementInterface');
        
        $factory->createConsoleApplication('App', '1.0', InvalidCommandDoesNotImplementInterface::class);
    }
}