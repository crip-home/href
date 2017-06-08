<?php use Illuminate\Database\Seeder;

/**
 * Class HrefTagsTableSeeder
 */
class HrefTagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Href::all(['id'])
            ->each(function (\App\Href $href) {
                $tagIds = \App\Tag::inRandomOrder()->limit(2)->get(['id'])
                    ->pluck('id')->toArray();;
                $href->tags()->sync($tagIds);
            });
    }
}
