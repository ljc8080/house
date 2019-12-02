<?php

use App\Model\Article;
use Illuminate\Database\Seeder;

class ArtisanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Article::class,200)->create();
    }
}
