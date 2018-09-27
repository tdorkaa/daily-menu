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

    protected function parseDailyMenu(ParserHelper $parserHelper, $dayOfTheWeek)
    {
        $this->dom->load('http://www.vendiaketterem.hu/', [
            'preserveLineBreaks' => true,
        ]);
        $parsedMenu = trim($this->dom->find('.offer-item', 0)->text);

        $dailyMenuWithExtraSpaces = array_slice(preg_split("/\n/", $parsedMenu), 0, 3);
        return $parserHelper->trimArray($dailyMenuWithExtraSpaces);
    }

    protected function throwParserException()
    {
        throw new VendiakParserException('Vendiak does not have menu during the weekend.');
    }
}