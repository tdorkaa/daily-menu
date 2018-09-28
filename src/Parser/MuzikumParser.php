<?php

namespace DailyMenu\Parser;

use PHPHtmlParser\Dom;

class MuzikumParser extends Parser
{
    /**
     * @var Dom
     */
    private $dom;

    public function __construct(Dom $dom)
    {
        $this->dom = $dom;
    }

    protected function parseDailyMenu($dayOfTheWeek)
    {
        $this->dom->load('http://muzikum.hu/heti-menu/', [
            'preserveLineBreaks' => true,
        ]);
        $parsedMenu = $this->dom->find('.content-right div p', ($dayOfTheWeek - 1) * 2)->text;
        $parsedMenuAsAnArrayWithExtraSpaces = preg_split("/\n/", $parsedMenu);
        return array_map('trim', $parsedMenuAsAnArrayWithExtraSpaces);
    }
}