<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        if(config('database.default') !== 'sqlite'){
            DB::statement('set foreign_key_checks=0');
        }

        App\User::truncate();
        $this->call(UsersTableSeeder::class);

        App\Article::truncate();
        $this->call(ArticlesTableSeeder::class);

        if(config('database.default') !== 'sqlite'){
            DB::statement('set foreign_key_checks=1');
        }
    }
}
