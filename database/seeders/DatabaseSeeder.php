<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ユーザーのダミーデータを100件作成するシーダーを呼び出す
        $this->call(UsersTableSeeder::class);
    }
}

