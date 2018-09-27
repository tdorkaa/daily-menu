<?php

namespace Tests\Job;

use DailyMenu\Parser\ParserHelper;

class FakeMuzikumParser
{
    public function getDailyMenu(ParserHelper $parserHelper, $date)
    {
        return ['Francia hagymaleves diós veknivel', 'Csirkemell sajttal, sonkával sütve, petrezselymes burgonyával'];
    }
}