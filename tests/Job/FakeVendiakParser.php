<?php

namespace Tests\Job;

use DailyMenu\Parser\Exception\VendiakParserException;
use DailyMenu\Parser\ParserHelper;

class FakeVendiakParser
{
    public function getDailyMenu(ParserHelper $parserHelper, $date)
    {
        $dayOfTheWeek = date('w', strtotime($date));
        $isOnWorkDay = $dayOfTheWeek < 6;
        if ($isOnWorkDay) {
            return ['Házi tea', 'Zöldségkrémleves', 'Milánói sertésborda'];
        } else {
            throw new VendiakParserException('Date is invalid');
        }
    }
}