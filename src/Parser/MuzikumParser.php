<?php

namespace DailyMenu\Parser;


use DailyMenu\Parser\Exception\MuzikumParserException;
use PHPHtmlParser\Dom;

class MuzikumParser
{
    /**
     * @var Dom
     */
    private $dom;

    public function __construct(Dom $dom)
    {
        $this->dom = $dom;
    }

    public function getDailyMenu(ParserHelper $parserHelper, $date): array
    {
        $this->dom->load('http://muzikum.hu/heti-menu/', [
            'preserveLineBreaks' => true,
        ]);
        $parsedMenu = $this->findMenuForCurrentDay($date);
        $parsedMenuAsAnArrayWithExtraSpaces = preg_split("/\n/", $parsedMenu);
        return $parserHelper->trimArray($parsedMenuAsAnArrayWithExtraSpaces);
    }

    private function findMenuForCurrentDay($date)
    {
        $dayOfTheWeek = date('w', strtotime($date));
        $isOnWorkDay = $dayOfTheWeek < 6;
        if ($isOnWorkDay) {
            return $this->dom->find('.content-right div p', ($date - 1) * 2)->text;
        } else {
            throw new MuzikumParserException('Muzikum does not have menu during the weekend.');
        }
    }
}