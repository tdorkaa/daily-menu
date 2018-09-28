<?php

namespace Tests\Parser;

use DailyMenu\Parser\Exception\VendiakParserException;
use DailyMenu\Parser\ParserHelper;
use DailyMenu\Parser\VendiakParser;
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
        $dailyMenu = $vediakParser->getDailyMenu(date('2018-09-27'));
        $this->assertEquals(['Házi tea', 'Zöldségkrémleves',
            'Milánói sertésborda'], $dailyMenu);
    }

    /**
     * @test
     */
    public function getDailyMenu_GivenDateIsOnWeekend_ThrowsVendiakParserException()
    {
        $mockParser = $this->getMockHtmlParser();
        $mockParser
            ->expects($this->never())
            ->method('load')
            ->with('http://www.vendiaketterem.hu/', ['preserveLineBreaks' => true]);
        $this->expectException(VendiakParserException::class);
        $vediakParser = new VendiakParser($mockParser);
        $vediakParser->getDailyMenu(date('2018-09-29'));
    }
}