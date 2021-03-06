<?php use Illuminate\Database\Seeder;

/**
 * Class DatabaseSeeder
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(HrefTableSeeder::class);
        $this->call(TagsTableSeeder::class);
        $this->call(HrefTagsTableSeeder::class);
    }
}
