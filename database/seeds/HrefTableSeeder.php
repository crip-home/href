<?php use Illuminate\Database\Seeder;

/**
 * Class HrefTableSeeder
 */
class HrefTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Href::class, 100)->create([
            'category_id' => rand(1, 20)
        ]);
    }
}
