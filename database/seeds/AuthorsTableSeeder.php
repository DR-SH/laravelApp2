<?php

use Illuminate\Database\Seeder;
use App\Author;
class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Author::class, 10)->create();
    }
}
