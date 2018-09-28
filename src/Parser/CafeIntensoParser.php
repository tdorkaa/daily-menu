<?php

namespace DailyMenu\Parser;

use PHPHtmlParser\Dom;

class CafeIntensoParser extends Parser
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
        $this->dom->load('http://cafeintenzo.hu/', [
            'preserveLineBreaks' => true,
        ]);
        $extraTag = $this->dom->find('.zn_text_box p', 14);
        $extraTag->delete();
        return $this->findDailyMenuForDayOfTheWeek($dayOfTheWeek);
    }

    private function findDailyMenuForDayOfTheWeek($dayOfTheWeek)
    {
        $dayOfTheWeek--;
        $parsedMenu = [];
        for ($i = 5 + ($dayOfTheWeek * 3); $i <  5 + (($dayOfTheWeek + 1) * 3); $i++) {
            array_push($parsedMenu, trim($this->dom->find('.zn_text_box p', $i)->text));
        }
        return $parsedMenu;
    }
}