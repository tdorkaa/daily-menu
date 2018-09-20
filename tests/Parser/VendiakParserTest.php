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
    public function parser_GivenLoadedHtmlSource_returnsDailyMenu()
    {
        $vediakParser = new VendiakParser($this->getMockHtmlParser());
        $dailyMenu = $vediakParser->getDailyMenu();
        $this->assertEquals(['Házi tea', 'Zöldségkrémleves',
            'Milánói sertésborda'], $dailyMenu);
    }
}