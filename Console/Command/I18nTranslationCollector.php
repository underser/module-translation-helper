<?php

declare(strict_types=1);

namespace Underser\TranslationHelper\Console\Command;

use Magento\Framework\App\Area;
use Magento\Framework\App\State;
use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Underser\TranslationHelper\Service\Generator\FilterableGenerator;

/**
 * Class I18nTranslationCollector.
 *
 * @package Underser\TranslationHelper\Console\Command
 */
class I18nTranslationCollector extends Command
{
    /**
     * @var FilterableGenerator
     */
    protected $directoryGenerator;

    /**
     * @var State
     */
    protected $state;

    /**
     * @var InputArgument[]
     */
    protected $filters;

    /**
     * I18nTranslationCollector constructor.
     *
     * @param FilterableGenerator $directoryGenerator
     * @param State $state
     * @param string|null $name
     * @param array $filters
     */
    public function __construct(
        FilterableGenerator $directoryGenerator,
        State $state,
        string $name = null,
        array $filters = []
    ) {
        $this->directoryGenerator = $directoryGenerator;
        $this->state = $state;
        $this->filters = $filters;
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
        $this->setDefinition(array_merge([
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
                'Omit the parameter if a directory is specified.'
            ),
        ], $this->filters));
    }

    /**
     * Command entry point.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int
     * @throws LocalizedException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->state->setAreaCode(Area::AREA_FRONTEND);
        $directory = $input->getOption(self::INPUT_KEY_ALL) ? BP : $input->getArgument(self::INPUT_KEY_DIRECTORY);
        $filters = [];

        // Grab filters
        foreach ($this->filters as $filter) {
            $filterName = $filter->getName();
            $filters[$filterName] = $input->getOption($filterName);
        }

        $this->directoryGenerator->generate(
            $directory,
            $input->getOption(self::INPUT_KEY_OUTPUT),
            false,
            $filters
        );

        $output->writeln('<info>Dictionary successfully processed.</info>');

        return Cli::RETURN_SUCCESS;
    }
}
