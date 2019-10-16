<?php

declare(strict_types=1);

namespace Underser\TranslationHelper\Service\I18n\Parser;

use Magento\Setup\Module\I18n;
use Magento\Setup\Module\I18n\Parser\Parser as CoreParser;
use Magento\Setup\Module\I18n\Parser\AdapterInterface;

/**
 * Class Parser.
 *
 * @package Underser\TranslationHelper\Service\I18n\Parser
 */
class Parser extends CoreParser
{
    /**
     * Adapters
     *
     * @var AdapterInterface[]
     */
    protected $_adapters;

    /**
     * Parser constructor.
     *
     * @param I18n\FilesCollector $filesCollector
     * @param I18n\Factory $factory
     * @param array $adapters
     */
    public function __construct(
        I18n\FilesCollector $filesCollector,
        I18n\Factory $factory,
        array $adapters = []
    ) {
        parent::__construct($filesCollector, $factory);
        $this->_adapters = $adapters;
    }
}
