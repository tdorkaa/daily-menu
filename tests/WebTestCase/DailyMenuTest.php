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
        $this->insertRestaurants([$this->aRestaurant()]);
        $this->insertMenus([$this->aMenu(1,1, date('Y-m-d'))]);
        $response = $this->processRequest('GET', '/dailymenus' );
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Fiction Stars1', (string)$response->getBody());
        $this->assertContains('Leves, Fozelek1', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function getMenusByDate_GivenDbContainsOneRestaurantAndNotAllMenusAreInTheDateRange_Returns200AndDailyMenus()
    {
        $this->insertRestaurants([$this->aRestaurant()]);
        $this->insertMenus([$this->aMenu(1,1), $this->aMenu(2,1, '2018-09-23'),
                            $this->aMenu(3,1, '2018-09-24')]);
        $response = $this->processRequest('GET', '/menus?date1=2018-09-20&date2=2018-09-23');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertContains('Fiction Stars1', (string)$response->getBody());
        $this->assertContains('Leves, Fozelek1', (string)$response->getBody());
        $this->assertContains('Leves, Fozelek2', (string)$response->getBody());
    }

    /**
     * @test
     */
    public function getMenusByDate_GivenDbContainsTwoDifferentRestaurants_ReturnsDailyMenus()
    {
        $this->insertRestaurants([$this->aRestaurant(), $this->aRestaurant(2)]);
        $this->insertMenus([$this->aMenu(1,1), $this->aMenu(2,1, '2018-09-23'),
            $this->aMenu(3,2, '2018-09-21')]);
        $response = $this->processRequest('GET', '/menus?date1=2018-09-20&date2=2018-09-23');
        $this->assertContains('Fiction Stars1', (string)$response->getBody());
        $this->assertContains('Fiction Stars2', (string)$response->getBody());
        $this->assertContains('Leves, Fozelek1', (string)$response->getBody());
        $this->assertContains('Leves, Fozelek2', (string)$response->getBody());
        $this->assertContains('Leves, Fozelek3', (string)$response->getBody());
    }
}