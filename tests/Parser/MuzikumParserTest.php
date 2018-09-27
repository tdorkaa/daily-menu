<?php

namespace Tests\Parser;

use DailyMenu\Parser\Exception\MuzikumParserException;
use DailyMenu\Parser\MuzikumParser;
use DailyMenu\Parser\ParserHelper;
use PHPUnit\Framework\TestCase;
use Tests\MockHtmlParser;

class MuzikumParserTest extends TestCase
{
    use MockHtmlParser;
    
    private $mockParser;
    /**
     * @var MuzikumParser
     */
    private $muzikumParser;
    
    protected function setUp()
    {
        $this->mockParser = $this->getMockHtmlParser();
        $this->mockParser
            ->expects($this->once())
            ->method('load')
            ->with('http://muzikum.hu/heti-menu/', ['preserveLineBreaks' => true]);

        $this->mockParser->loadStr(
            file_get_contents(__DIR__ . '/HtmlContent/Muzikum.html'),
            ['preserveLineBreaks' => true]
        );
        $this->muzikumParser = new MuzikumParser($this->mockParser);    }

    /**
     * @test
     */
    public function getDailyMenu_GivenLoadedSourceCode_ReturnsDailyMenu()
    {
        $dailyMenu = $this->muzikumParser->getDailyMenu(new ParserHelper(), '2018-09-24');
        $this->assertEquals(['Francia hagymaleves diós veknivel',
            'Csirkemell sajttal, sonkával sütve, petrezselymes burgonyával'], $dailyMenu);
    }

    /**
     * @test
     */
    public function getDailyMenu_GivenDateIsTuesDay_ReturnsDailyMenu()
    {
        $this->expectException(MuzikumParserException::class);
        $this->muzikumParser->getDailyMenu(new ParserHelper(), '2018-09-29');
    }
}