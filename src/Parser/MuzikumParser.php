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

    public function getDailyMenu($date): array
    {
        $this->dom->load('http://muzikum.hu/heti-menu/', [
            'preserveLineBreaks' => true,
        ]);
        $parsedMenu = $this->dom->find('.content-right div p', 0)->text;
        $parsedMenuAsAnArrayWithExtraSpaces = preg_split("/\n/", $parsedMenu);
        return $this->trimAnArray($parsedMenuAsAnArrayWithExtraSpaces);
    }

    private function trimAnArray($arrayToTrim)
    {
        foreach ($arrayToTrim as $index => $item) {
            $arrayToTrim[$index] = trim($item);
        }
        return $arrayToTrim;
    }
}