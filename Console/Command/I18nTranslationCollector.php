<?php

declare(strict_types=1);

namespace Underser\TranslationHelper\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Setup\Module\I18n\Dictionary\Generator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class I18nTranslationCollector.
 *
 * @package Underser\TranslationHelper\Console\Command
 */
class I18nTranslationCollector extends Command
{
    /**
     * @var Generator
     */
    protected $directoryGenerator;

    public function __construct(
        Generator $directoryGenerator,
        string $name = null
    ) {
        $this->directoryGenerator = $directoryGenerator;
        parent::__construct($name);
    }


    /**#@+
     * Keys and shortcuts for input arguments and options
     */
    protected const INPUT_KEY_DIRECTORY = 'directory';
    protected const INPUT_KEY_OUTPUT = 'output';
    protected const SHORTCUT_KEY_OUTPUT = 'o';
    protected const INPUT_KEY_ALL = 'all';
    protected const SHORTCUT_KEY_ALL = 'a';
    /**#@- */

    /**
     * Configure command.
     */
    protected function configure(): void
    {
        $this->setName('i18n:translation-helper');
        $this->setDescription('Allow grab translation files with the ability to exclude already translated ones.');
        $this->setDefinition([
            new InputArgument(
                self::INPUT_KEY_DIRECTORY,
                InputArgument::OPTIONAL,
                'Directory path to parse. Not needed if --all flag is set',
                BP
            ),
            new InputOption(
                self::INPUT_KEY_OUTPUT,
                self::SHORTCUT_KEY_OUTPUT,
                InputOption::VALUE_REQUIRED,
                'Path (including filename) to an output file. With no file specified, defaults to stdout.'
            ),
            new InputOption(
                self::INPUT_KEY_ALL,
                self::SHORTCUT_KEY_ALL,
                InputOption::VALUE_NONE,
                'Use the --all parameter to parse the current Magento codebase.' .
                ' Omit the parameter if a directory is specified.'
            ),
        ]);
    }

    /**
     * Command entry point.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $directory = $input->getOption(self::INPUT_KEY_ALL) ? BP : $input->getArgument(self::INPUT_KEY_DIRECTORY);

        $this->directoryGenerator->generate(
            $directory,
            $input->getOption(self::INPUT_KEY_OUTPUT)
        );

        $output->writeln('<info>Dictionary successfully processed.</info>');

        return Cli::RETURN_SUCCESS;
    }
}
