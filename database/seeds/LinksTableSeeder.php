<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'link_name' => '幻牛',
                'link_title' => '幻牛科技',
                'link_url' => 'www.baidu.com',
            ],
            [
                'link_name' => '上海分公司',
                'link_title' => '杭州幻牛科技网络公司上海分公司',
                'link_url' => 'www.huanniu.com',
            ],
        ];
        DB::table('links')->insert($data);
    }
}
