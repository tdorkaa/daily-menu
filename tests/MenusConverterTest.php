<?php

namespace Tests;

use DailyMenu\MenusConverter;
use PHPUnit\Framework\TestCase;

class MenusConverterTest extends TestCase
{
    /**
     * @test
     */
    public function convert_GivenMenusDao_ReturnsConvertedArray()
    {
        $converter = new MenusConverter();
        $expected = [
            [
                'restaurant_id' => '1',
                'restaurant' => 'Fiction Stars1',
                'menus' => [
                    [
                        'date' => '2018-09-22',
                        'menu' => 'Leves, Fozelek1'
                    ],
                    [
                        'date' => '2018-09-12',
                        'menu' => 'Leves, Fozelek3'
                    ],
                    [
                        'date' => '2018-09-11',
                        'menu' => 'Leves, Fozelek2'
                    ]
                ]
            ]
        ];
        $menuDao = [
            [
                'id' => '1',
                'restaurant_id' => '1',
                'restaurant' => 'Fiction Stars1',
                'menu' => 'Leves, Fozelek1',
                'date' => '2018-09-22'
            ],
            [
                'id' => '3',
                'restaurant_id' => '1',
                'restaurant' => 'Fiction Stars1',
                'menu' => 'Leves, Fozelek3',
                'date' => '2018-09-12'
            ],
            [
                'id' => '2',
                'restaurant_id' => '1',
                'restaurant' => 'Fiction Stars1',
                'menu' => 'Leves, Fozelek2',
                'date' => '2018-09-11'
            ]
        ];
        $actual = $converter->convert($menuDao);
        $this->assertEquals($expected, $actual);
    }
}