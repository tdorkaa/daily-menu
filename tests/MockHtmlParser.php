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

        $mockHTMLParser
            ->expects($this->once())
            ->method('load')
            ->with('http://www.vendiaketterem.hu/', ['preserveLineBreaks' => true]);

        $mockHTMLParser->loadStr(
            file_get_contents(__DIR__ . '/Parser/HtmlContent/Vendiak.html'),
            ['preserveLineBreaks' => true]
        );

        return $mockHTMLParser;
    }

}