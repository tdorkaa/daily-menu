<?php

namespace Tests\Parser;

use DailyMenu\Parser\CafeIntensoParser;
use DailyMenu\Parser\MuzikumParser;
use DailyMenu\Parser\ParserMapper;
use DailyMenu\Parser\VendiakParser;
use PHPUnit\Framework\TestCase;

class ParserMapperTest extends TestCase
{
    /**
     * @test
     */
    public function getParserMap_ReturnsMap()
    {
        $expected = [
            'Véndiák Cafe Lounge' => VendiakParser::class,
            'Muzikum Klub & Bistro' => MuzikumParser::class,
            'Cafe Intenso' => CafeIntensoParser::class
        ];
        $actual = ParserMapper::getParserMap();
        $this->assertEquals($expected, $actual);
    }
}