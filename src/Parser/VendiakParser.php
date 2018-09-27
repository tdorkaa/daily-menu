<?php

namespace DailyMenu\Parser;

use DailyMenu\Parser\Exception\VendiakParserException;
use PHPHtmlParser\Dom;

class VendiakParser
{
    private $dom;

    public function __construct(Dom $dom)
    {
        $this->dom = $dom;
    }

    public function getDailyMenu(ParserHelper $parserHelper, $date): array
    {
        $dayOfTheWeek = date('w', strtotime($date));
        $isOnWorkDay = $dayOfTheWeek < 6;
        if ($isOnWorkDay) {
        $this->dom->load('http://www.vendiaketterem.hu/', [
            'preserveLineBreaks' => true,
        ]);
        $parsedMenu = trim($this->dom->find('.offer-item', 0)->text);

        $dailyMenuWithExtraSpaces = array_slice(preg_split("/\n/", $parsedMenu), 0, 3);
        return $parserHelper->trimArray($dailyMenuWithExtraSpaces);
        } else {
            throw new VendiakParserException('Vendiak does not have menu during the weekend.');
        }
    }
}