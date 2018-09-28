<?php

namespace Tests\Job;

use DailyMenu\Parser\Exception\VendiakParserException;

class FakeVendiakParser
{
    public function getDailyMenu($date)
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