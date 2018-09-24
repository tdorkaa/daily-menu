<?php

namespace Tests\Parser;

use DailyMenu\Parser\VendiakParser;
use PHPHtmlParser\Dom;
use PHPUnit\Framework\TestCase;
use Tests\MockHtmlParser;

class VendiakParserTest extends TestCase
{
    use MockHtmlParser;

    /**
     * @test
     */
    public function getDailyMenu_GivenLoadedHtmlSource_returnsDailyMenu()
    {
        $mockParser = $this->getMockHtmlParser();
        $mockParser
            ->expects($this->once())
            ->method('load')
            ->with('http://www.vendiaketterem.hu/', ['preserveLineBreaks' => true]);

        $mockParser->loadStr(
            file_get_contents(__DIR__ . '/HtmlContent/Vendiak.html'),
            ['preserveLineBreaks' => true]
        );
        $vediakParser = new VendiakParser($mockParser);
        $dailyMenu = $vediakParser->getDailyMenu();
        $this->assertEquals(['Házi tea', 'Zöldségkrémleves',
            'Milánói sertésborda'], $dailyMenu);
    }
}