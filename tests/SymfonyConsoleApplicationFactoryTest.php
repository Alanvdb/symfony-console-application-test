<?php declare(strict_types=1);

namespace AlanVdb\Console\Factory\Tests;

use AlanVdb\Console\Factory\SymfonyConsoleApplicationFactory;
use AlanVdb\Console\Definition\ConsoleApplicationInterface;
use AlanVdb\Console\SymfonyConsoleApplication;
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
        $commands = ['command:one', 'command:two'];
        
        $application = $factory->createConsoleApplication($name, $version, ...$commands);
        
        $this->assertSame($name, $application->getName());
        $this->assertSame($version, $application->getVersion());
        $this->assertSame($commands, $application->getCommands());
    }
}