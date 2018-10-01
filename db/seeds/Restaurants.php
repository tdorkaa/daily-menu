<?php


use Phinx\Seed\AbstractSeed;

class Restaurants extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            [
                'name' => 'Véndiák Cafe Lounge',
            ],
            [
                'name' => 'Muzikum Klub & Bistro',
            ],
            [
                'name' => 'Cafe Intenso',
            ]
        ];

        $posts = $this->table('restaurants');
        $posts->truncate();
        $posts
            ->insert($data)
            ->save();
    }
}
