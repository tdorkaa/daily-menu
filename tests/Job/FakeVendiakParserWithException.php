<?php

namespace Tests\Job;

class FakeVendiakParserWithException
{
    public function getDailyMenu()
    {
        throw new \InvalidArgumentException('Parse failed.');
    }

}