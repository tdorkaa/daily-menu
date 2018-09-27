<?php

namespace DailyMenu\Parser;

class ParserMapper
{
    public static function getParserMap()
    {
        return [
            'Véndiák Cafe Lounge' => VendiakParser::class,
            'Muzikum Klub & Bistro' => MuzikumParser::class
        ];
    }
}