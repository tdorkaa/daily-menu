<?php

namespace Tests\Job;

class FakeMuzikumParser
{
    public function getDailyMenu($date)
    {
        return ['Francia hagymaleves diós veknivel', 'Csirkemell sajttal, sonkával sütve, petrezselymes burgonyával'];
    }
}