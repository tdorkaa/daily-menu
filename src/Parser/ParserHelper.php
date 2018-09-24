<?php

namespace DailyMenu\Parser;

class ParserHelper
{

    public function trimArray(array $arrayToTrim): array
    {
        foreach ($arrayToTrim as $index => $item) {
            $arrayToTrim[$index] = trim($item);
        }
        return $arrayToTrim;
    }
}