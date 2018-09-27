<?php

namespace Tests\Job;

class FakeVendiakParser
{
    public function getDailyMenu()
    {
        return ['Házi tea', 'Zöldségkrémleves', 'Milánói sertésborda'];
    }
}