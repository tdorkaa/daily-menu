<?php

namespace DailyMenu\Parser;

abstract class Parser
{
    public function getDailyMenu($date): array
    {
        $dayOfTheWeek = date('w', strtotime($date));
        $isOnWorkDay = $dayOfTheWeek < 6;
        if ($isOnWorkDay) {
            return $this->parseDailyMenu($dayOfTheWeek);
        }
    }

    abstract protected function parseDailyMenu($dayOfTheWeek);
}