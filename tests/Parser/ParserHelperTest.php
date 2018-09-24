<?php

namespace Tests\Parser;

use DailyMenu\Parser\ParserHelper;
use PHPUnit\Framework\TestCase;

class ParserHelperTest extends TestCase
{
    /**
     * @test
     */
    public function trimArray_GivenArrayWithExtraSpaces_ReturnsAllTheItemsTrimmed()
    {
        $arrayToTrim = [
            'Francia hagymaleves diós veknivel     ',
            '    Csirkemell sajttal, sonkával sütve, petrezselymes burgonyával'
        ];
        $expected = [
            'Francia hagymaleves diós veknivel',
            'Csirkemell sajttal, sonkával sütve, petrezselymes burgonyával'
        ];
        $parserHelper = new ParserHelper();
        $actual = $parserHelper->trimArray($arrayToTrim);
        $this->assertEquals($expected, $actual);

    }

}