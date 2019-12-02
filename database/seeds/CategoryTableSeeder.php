<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            ['cname'=>'租房','pid'=>0,'create_time'=>time()],
            ['cname'=>'看房找房','pid'=>1,'create_time'=>time()],
            ['cname'=>'签约付款','pid'=>1,'create_time'=>time()],
            ['cname'=>'物业交付','pid'=>1,'create_time'=>time()],
            ['cname'=>'租房纠纷','pid'=>1,'create_time'=>time()],
        ]);
    }
}
