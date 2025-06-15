<?php declare(strict_types=1);

namespace AlanVdb\Console\Tests;

use AlanVdb\Console\Definition\ConsoleApplicationInterface;
use PHPUnit\Framework\TestCase;
use AlanVdb\Console\SymfonyConsoleApplication;
use AlanVdb\Test\ValidCommand1;
use AlanVdb\Test\ValidCommand2;
use AlanVdb\Test\InvalidCommandDoesNotImplementInterface;
use AlanVdb\Console\Exception\InvalidArgumentException;

class SymfonyConsoleApplicationTest extends TestCase
{

    public function testConstructorArgumentsArePassedCorrectly(): void
    {
        $name = 'MyApp';
        $version = '3.2.1';
        $commands = [ValidCommand1::class, ValidCommand2::class];
        
        $application = new SymfonyConsoleApplication($name, $version, ...$commands);
        
        $this->assertSame($name, $application->getName());
        $this->assertSame($version, $application->getVersion());
        
        $this->assertTrue($application->has('valid:command1'));
        $this->assertTrue($application->has('valid:command2'));
    }

    public function testImplementsConsoleApplicationInterface(): void
    {
        $name = 'MyApp';
        $version = '3.2.1';
        $commands = [ValidCommand1::class, ValidCommand2::class];
        
        $application = new SymfonyConsoleApplication($name, $version, ...$commands);
        
        $this->assertInstanceOf(ConsoleApplicationInterface::class, $application);
    }

    public function testInvalidCommandThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new SymfonyConsoleApplication('App', '1.0', 'InvalidCommand');
    }

    public function testCommandNotImplementingInterfaceThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new SymfonyConsoleApplication('App', '1.0', InvalidCommandDoesNotImplementInterface::class);
    }
}