<?php

namespace Tests\Parser;

use DailyMenu\Parser\MuzikumParser;
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
        $this->muzikumParser = new MuzikumParser($this->mockParser);    }

    /**
     * @test
     */
    public function getDailyMenu_GivenLoadedSourceCode_ReturnsDailyMenu()
    {
        $this->mockParser
            ->expects($this->once())
            ->method('load')
            ->with('http://muzikum.hu/heti-menu/', ['preserveLineBreaks' => true]);

        $this->mockParser->loadStr(
            file_get_contents(__DIR__ . '/HtmlContent/Muzikum.html'),
            ['preserveLineBreaks' => true]
        );
        $dailyMenu = $this->muzikumParser->getDailyMenu('2018-09-24');
        $this->assertEquals(['Francia hagymaleves diós veknivel',
            'Csirkemell sajttal, sonkával sütve, petrezselymes burgonyával'], $dailyMenu);
    }
}