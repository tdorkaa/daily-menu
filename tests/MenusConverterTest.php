<?php

namespace Tests;

use DailyMenu\MenusConverter;
use PHPUnit\Framework\TestCase;

class MenusConverterTest extends TestCase
{

    /**
     * @var MenusConverter
     */
    private $converter;

    protected function setUp()
    {
        $this->converter = new MenusConverter();    }

    /**
     * @test
     */
    public function convert_GivenMenusDao_ReturnsConvertedArray()
    {
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
        $actual = $this->converter->convert($menuDao);
        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     */
    public function convert_GivenMenusDaoWithMultipleRestaurants_ReturnsConvertedArray()
    {
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
            ],
            [
                'restaurant_id' => '2',
                'restaurant' => 'Fiction Stars2',
                'menus' => [
                    [
                        'date' => '2018-09-22',
                        'menu' => 'Leves, Fozelek4'
                    ],
                    [
                        'date' => '2018-09-12',
                        'menu' => 'Leves, Fozelek5'
                    ],
                    [
                        'date' => '2018-09-11',
                        'menu' => 'Leves, Fozelek6'
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
            ],
            [
                'id' => '4',
                'restaurant_id' => '2',
                'restaurant' => 'Fiction Stars2',
                'menu' => 'Leves, Fozelek4',
                'date' => '2018-09-22'
            ],
            [
                'id' => '5',
                'restaurant_id' => '2',
                'restaurant' => 'Fiction Stars2',
                'menu' => 'Leves, Fozelek5',
                'date' => '2018-09-12'
            ],
            [
                'id' => '6',
                'restaurant_id' => '2',
                'restaurant' => 'Fiction Stars2',
                'menu' => 'Leves, Fozelek6',
                'date' => '2018-09-11'
            ]
        ];
        $actual = $this->converter->convert($menuDao);
        $this->assertEquals($expected, $actual);
    }
}