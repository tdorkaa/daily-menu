<?php

namespace DailyMenu\Parser;

use DailyMenu\Parser\Exception\VendiakParserException;
use PHPHtmlParser\Dom;

class VendiakParser extends Parser
{
    private $dom;

    public function __construct(Dom $dom)
    {
        $this->dom = $dom;
    }

    protected function parseDailyMenu($dayOfTheWeek)
    {
        $this->dom->load('http://www.vendiaketterem.hu/', [
            'preserveLineBreaks' => true,
        ]);
        $parsedMenu = trim($this->dom->find('.offer-item', 0)->text);

        $dailyMenuWithExtraSpaces = array_slice(preg_split("/\n/", $parsedMenu), 0, 3);
        return array_map('trim', $dailyMenuWithExtraSpaces);
    }
}