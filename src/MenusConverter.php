<?php

namespace DailyMenu;

class MenusConverter
{

    public function convert(array $menuDao)
    {
        $convertedDao = [
            [
                'restaurant_id' => $menuDao[0]['id'],
                'restaurant' => $menuDao[0]['restaurant'],
                'menus' => $this->makeListOfDateAndMenu($menuDao)
            ]
        ];
        return $convertedDao;
    }

    private function makeListOfDateAndMenu($menuDao): array
    {
        $menus = [];
        foreach ($menuDao as $index => $menu) {
            $menus[$index]['date'] = $menu['date'];
            $menus[$index]['menu'] = $menu['menu'];
        }
        return $menus;
    }
}