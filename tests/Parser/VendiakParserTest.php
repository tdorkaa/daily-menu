<?php

namespace Tests\Parser;

use DailyMenu\Parser\VendiakParser;
use PHPHtmlParser\Dom;
use PHPUnit\Framework\TestCase;

class VendiakParserTest extends TestCase
{

    /**
     * @test
     */
    public function parser_GivenLoadedHtmlSource_returnsDailyMenu()
    {
        $mockHTMLParser = $this->getMockBuilder(Dom::class)
            ->setMethods(['load'])
            ->getMock();

        $mockHTMLParser
            ->expects($this->once())
            ->method('load')
            ->with('http://www.vendiaketterem.hu/', ['preserveLineBreaks' => true]);

        $mockHTMLParser->loadStr(
            file_get_contents(__DIR__ . '/HtmlContent/Vendiak.html'),
            ['preserveLineBreaks' => true]
        );


        $vediakParser = new VendiakParser($mockHTMLParser);
        $dailyMenu = $vediakParser->getDailyMenu();
        $this->assertEquals(['Házi tea', 'Zöldségkrémleves',
            'Milánói sertésborda'], $dailyMenu);
    }
}