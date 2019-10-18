<?php

declare(strict_types=1);

namespace Underser\TranslationHelper\Test\Unit\Console\Command;

use Magento\Framework\App\State;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Tester\CommandTester;
use Underser\TranslationHelper\Console\Command\I18nTranslationCollector;
use Underser\TranslationHelper\Service\Generator\FilterableGenerator;

if (!defined('BP')) {
    define('BP', '');
}

/**
 * Class CommandTest.
 *
 * @package Underser\TranslationHelper\Test\Unit
 */
class CommandTest extends TestCase
{
    /**
     * @var I18nTranslationCollector
     */
    protected $command;

    /**
     * @var State
     */
    protected $state;

    /**
     * @var CommandTester
     */
    protected $commandTester;

    /**
     * @var MockObject|FilterableGenerator
     */
    protected $directoryGeneratorMock;

    /**
     * @var MockObject|State
     */
    protected $stateMock;

    /**
     * Set up test dependencies.
     */
    protected function setUp(): void
    {
        $this->directoryGeneratorMock = $this->createMock(FilterableGenerator::class);
        $this->stateMock = $this->createMock(State::class);

        $this->command = new I18nTranslationCollector(
            $this->directoryGeneratorMock,
            $this->stateMock
        );

        $this->commandTester = new CommandTester($this->command);
    }

    /**
     * Command instance test.
     */
    public function testCommandInstance(): void
    {
        $this->assertInstanceOf(Command::class, $this->command);
    }

    /**
     * Execute test.
     */
    public function testExecute(): void
    {
        $this->stateMock->expects($this->once())->method('setAreaCode');
        $this->directoryGeneratorMock->expects($this->once())->method('generate');
        $this->commandTester->execute([]);
    }
}
