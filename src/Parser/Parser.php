<?php

namespace DailyMenu\Parser;

abstract class Parser
{
    public function getDailyMenu(ParserHelper $parserHelper, $date): array
    {
        $dayOfTheWeek = date('w', strtotime($date));
        $isOnWorkDay = $dayOfTheWeek < 6;
        if ($isOnWorkDay) {
            return $this->parseDailyMenu($parserHelper, $dayOfTheWeek);
        } else {
            $this->throwParserException();
        }
    }

    abstract protected function parseDailyMenu(ParserHelper $parserHelper, $dayOfTheWeek);
    abstract protected function throwParserException();
}