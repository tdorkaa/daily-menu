<?php

namespace DailyMenu\Parser;


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
        $date = date('w', strtotime($date));
        return $this->dom->find('.content-right div p', ($date - 1) * 2)->text;
    }
}