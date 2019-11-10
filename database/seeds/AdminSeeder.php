<?php

use App\Model\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        factory(Admin::class,10)->create();
        Admin::where('id',mt_rand(1,10))->update(['username'=>'admin']);
    }
}
