<?php

namespace Tests\Parser;

use DailyMenu\Parser\CafeIntensoParser;
use PHPUnit\Framework\TestCase;
use Tests\MockHtmlParser;

class CafeIntensoParserTest extends TestCase
{
    use MockHtmlParser;

    private $mockParser;

    protected function setUp()
    {
        $this->mockParser = $this->getMockHtmlParser();
        $this->mockParser
            ->expects($this->once())
            ->method('load')
            ->with('http://cafeintenzo.hu/', ['preserveLineBreaks' => true]);

        $this->mockParser->loadStr(
            file_get_contents(__DIR__ . '/HtmlContent/CafeIntenso.html'),
            ['preserveLineBreaks' => true]
        );
    }

    /**
     * @test
     */
    public function getDailyMenu_GivenDateIsFriday_ReturnsDailyMenu()
    {
        $cafeIntensoParser = new CafeIntensoParser($this->mockParser);
        $dailyMenu = $cafeIntensoParser->getDailyMenu('2018-09-28');
        $this->assertEquals(['Bableves császárszalonna kockákkal',
            'Csirkepaprikás, házi galuska', '+ meglepetés'], $dailyMenu);

    }

    /**
     * @test
     */
    public function getDailyMenu_GivenDateIsMonday_ReturnsDailyMenu()
    {
        $cafeIntensoParser = new CafeIntensoParser($this->mockParser);
        $dailyMenu = $cafeIntensoParser->getDailyMenu('2018-09-24');
        $this->assertEquals(['Magyaros zöldborsóleves', 'Sokmagvas bundában sült csirkemell, zöldséges rizs', '+ meglepetés'], $dailyMenu);
    }

}