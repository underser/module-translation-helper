<?php

declare(strict_types=1);

namespace Underser\TranslationHelper\Test\Unit\Service\Filter;

use Magento\Framework\TranslateInterface;
use PHPUnit\Framework\TestCase;
use Underser\TranslationHelper\Service\Filter\FilterInterface;
use Underser\TranslationHelper\Service\Filter\TranslatedPhrasesFilter;

/**
 * Class TranslatedPhrasesFilterTest.
 *
 * @package Underser\TranslationHelper\Test\Unit\Service\Filter
 */
class TranslatedPhrasesFilterTest extends TestCase
{
    /**
     * @var TranslatedPhrasesFilter
     */
    protected $filter;

    /**
     * Set up test dependencies.
     */
    protected function setUp()
    {
        $translationMock = $this->getMockForAbstractClass(TranslateInterface::class);
        $translationMock->expects($this->any())
            ->method('loadData')
            ->willReturnSelf();
        $translationMock->expects($this->any())
            ->method('getData')
            ->willReturn([
                'String to translate' => 'Translated string'
            ]);
        $this->filter = new TranslatedPhrasesFilter($translationMock);
    }

    /**
     * Filter instance test.
     */
    public function testFilterInstance()
    {
        $this->assertInstanceOf(FilterInterface::class, $this->filter);
    }

    /**
     * Test method with no filters argument.
     */
    public function testApplyWithNoFilters(): void
    {
        $phrases = ['String to translate' => 'String to translate'];

        $filters1 = [];
        $result1 = $this->filter->apply($phrases, $filters1);

        $filters2 = ['locale' => null];
        $result2 = $this->filter->apply($phrases, $filters2);

        $this->assertEquals($phrases, $result1);
        $this->assertEquals($phrases, $result2);
    }

    /**
     * Test that filter exclude translated phrases.
     */
    public function testFilterExcludePhrases()
    {
        $phrases = [
            'String to translate' => 'String to translate',
            'Not translated string' => 'Not translated string'
        ];
        $filters = ['locale' => ''];
        $result = $this->filter->apply($phrases, $filters);

        $this->assertEquals(['Not translated string' => 'Not translated string'], $result);
    }
}
