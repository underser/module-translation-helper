<?php

declare(strict_types=1);

namespace Underser\TranslationHelper\Service\Filter;

use Magento\Framework\TranslateInterface;
use Magento\Framework\App\Area;

/**
 * Class TranslatedPhrasesFilter.
 *
 * @package Underser\TranslationHelper\Service\Filter
 */
class TranslatedPhrasesFilter implements FilterInterface
{
    /**
     * @var TranslateInterface
     */
    protected $translation;

    public function __construct(TranslateInterface $translation)
    {
        $this->translation = $translation;
    }

    /**
     * Apply locale filter.
     *
     * @param array $phrases
     * @param array $filters
     *
     * @return array
     */
    public function apply(array $phrases, array $filters): array
    {
        if (!isset($filters['locale'])) {
            return $phrases;
        }
        $this->translation->setLocale($filters['locale']);
        $translations = $this->translation->loadData(Area::AREA_FRONTEND)->getData();

        return array_diff_key($phrases, $translations);
    }
}
