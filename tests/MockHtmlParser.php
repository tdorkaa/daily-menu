<?php

namespace Tests;

use PHPHtmlParser\Dom;

trait MockHtmlParser
{
    private function getMockHtmlParser()
    {
        $mockHTMLParser = $this->getMockBuilder(Dom::class)
            ->setMethods(['load'])
            ->getMock();

        return $mockHTMLParser;
    }

}