<?php

declare(strict_types=1);

namespace Underser\TranslationHelper\Service\I18n\Parser;

use Magento\Setup\Module\I18n;
use Magento\Setup\Module\I18n\Parser\AdapterInterface;
use Magento\Setup\Module\I18n\Parser\Contextual as CoreContextual;

/**
 * Class Contextual.
 *
 * @package Underser\TranslationHelper\Service\I18n\Parser
 */
class Contextual extends CoreContextual
{
    /**
     * Adapters
     *
     * @var AdapterInterface[]
     */
    protected $_adapters;

    /**
     * Contextual constructor.
     *
     * @param I18n\FilesCollector $filesCollector
     * @param I18n\Factory $factory
     * @param I18n\Context $context
     * @param array $adapters
     */
    public function __construct(
        I18n\FilesCollector $filesCollector,
        I18n\Factory $factory,
        I18n\Context $context,
        array $adapters = []
    ) {
        parent::__construct($filesCollector, $factory, $context);
        $this->_adapters = $adapters;
    }
}
