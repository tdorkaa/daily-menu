<?php

namespace DailyMenu;

class MenusConverter
{

    public function convert(array $menuDao)
    {
        $twoDimensionalArrayByRestaurantID = $this->makeTwoDimensionalArrayByRestaurantId($menuDao);
        return $this->convertMenus($twoDimensionalArrayByRestaurantID);
    }

    private function makeTwoDimensionalArrayByRestaurantId($menuDao)
    {
        $menus = [];
        $indexOfOuterArray = 0;
        foreach ($menuDao as $menu) {
            if ($indexOfOuterArray !== $menu['restaurant_id'] - 1) {
                $indexOfOuterArray++;
                $menus[$indexOfOuterArray][] = $menu;
            } else {
                $menus[$indexOfOuterArray][] = $menu;
            }
        }
        return $menus;
    }

    private function convertMenus($menuDao)
    {
        $menus = [];
        foreach ($menuDao as $index => $menu) {
            $menus[$index]['restaurant_id'] = $menu[0]['restaurant_id'];
            $menus[$index]['restaurant'] = $menu[0]['restaurant'];
            $menus[$index]['menus'] = $this->makeListOfDateAndMenuByRestaurant($menu);
        }
        return $menus;
    }

    private function makeListOfDateAndMenuByRestaurant($menuDao): array
    {
        $menus = [];
        foreach ($menuDao as $index => $menu) {
            $menus[$index]['date'] = $menu['date'];
            $menus[$index]['menu'] = $menu['menu'];
        }
        return $menus;
    }
}