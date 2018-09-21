<?php

namespace Tests\WebTestCase;

use PHPUnit\Framework\TestCase;
use Tests\DbHelper;

class DailyMenuTest extends TestCase
{
    use Webtestcase;
    use DbHelper;

    protected function setUp()
    {
        $this->setUpPdo();
        $this->truncate('restaurants');
        $this->truncate('menus');
    }

    /**
     * @test
     */
    public function getDailyMenus_DbContainsDailyMenus_Returns200AndDailyMenus()
    {
        $menu = $this->aMenu(1,1, date('Y-m-d'));
        $this->insertRestaurants([$this->aRestaurant()]);
        $this->insertMenus([$menu]);
        $response = $this->processRequest('GET', '/dailymenus' );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Fiction Stars1', (string)$response->getBody());
        $this->assertContains('Leves, Fozelek1', (string)$response->getBody());
    }
}