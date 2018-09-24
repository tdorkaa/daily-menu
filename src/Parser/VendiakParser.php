<?php

namespace DailyMenu\Parser;

use PHPHtmlParser\Dom;

class VendiakParser
{
    private $dom;

    public function __construct(Dom $dom)
    {
        $this->dom = $dom;
    }

    public function getDailyMenu(ParserHelper $parserHelper): array
    {
        $this->dom->load('http://www.vendiaketterem.hu/', [
            'preserveLineBreaks' => true,
        ]);
        $parsedMenu = trim($this->dom->find('.offer-item', 0)->text);

        $dailyMenuWithExtraSpaces = array_slice(preg_split("/\n/", $parsedMenu), 0, 3);
        return $parserHelper->trimArray($dailyMenuWithExtraSpaces);
    }
}