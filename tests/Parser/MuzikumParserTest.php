<?php

namespace Tests\Parser;

use DailyMenu\Parser\MuzikumParser;
use DailyMenu\Parser\ParserHelper;
use PHPUnit\Framework\TestCase;
use Tests\MockHtmlParser;

class MuzikumParserTest extends TestCase
{
    use MockHtmlParser;

    /**
     * @test
     */
    public function getDailyMenu_GivenLoadedSourceCode_ReturnsDailyMenu()
    {
        $mockParser = $this->getMockHtmlParser();
        $mockParser
            ->expects($this->once())
            ->method('load')
            ->with('http://muzikum.hu/heti-menu/', ['preserveLineBreaks' => true]);

        $mockParser->loadStr(
            file_get_contents(__DIR__ . '/HtmlContent/Muzikum.html'),
            ['preserveLineBreaks' => true]
        );
        $muzikumParser = new MuzikumParser($mockParser);
        $dailyMenu = $muzikumParser->getDailyMenu(new ParserHelper(), '2018-09-24');
        $this->assertEquals(['Francia hagymaleves diós veknivel',
            'Csirkemell sajttal, sonkával sütve, petrezselymes burgonyával'], $dailyMenu);
    }

    /**
     * @test
     */
    public function getDailyMenu_GivenDateIsTuesDay_ReturnsDailyMenu()
    {
        $mockParser = $this->getMockHtmlParser();
        $mockParser
            ->expects($this->once())
            ->method('load')
            ->with('http://muzikum.hu/heti-menu/', ['preserveLineBreaks' => true]);

        $mockParser->loadStr(
            file_get_contents(__DIR__ . '/HtmlContent/Muzikum.html'),
            ['preserveLineBreaks' => true]
        );
        $muzikumParser = new MuzikumParser($mockParser);
        $dailyMenu = $muzikumParser->getDailyMenu(new ParserHelper(), '2018-09-25');
        $this->assertEquals(['Burgonyás kelleves kéksajtos tejföllel',
            'Háromborsos sertésborda tejfölös jalapeno-val, jázmin rizzsel'], $dailyMenu);
    }
}