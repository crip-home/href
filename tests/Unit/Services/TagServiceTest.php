<?php namespace Tests\Services;

use App\Href;
use App\Services\TagService;
use App\Tag;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * Class TagServiceTest
 * @package Tests\Services
 */
class TagServiceTest extends TestCase
{
    /**
     * @var TagService
     */
    private $tagService;

    /**
     * Setup the test environment.
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->tagService = $this->app->make(TagService::class);
    }

    /**
     * Test service can create method.
     * @return void
     */
    public function testCanCreateTag()
    {
        $tag = factory(Tag::class)->make(['tag' => 'Hello']);

        $this->tagService->create($tag->toArray());

        $this->assertDatabaseHas('tags', [
            'tag' => 'Hello'
        ]);
    }

    /**
     * Test service can retrieve most used tags with default parameters.
     * @return void
     */
    public function testCanGetOnlyMostUsedTagsRelatedToHref()
    {
        $user = factory(User::class)->create();

        // tag with 5 relations
        $tag = factory(Tag::class)->create(['tag' => 'Hello']);
        factory(Href::class, 5)
            ->create(['user_id' => $user->id, 'visible' => true])
            ->each(function (Href $href) use ($tag) {
                $href->tags()->sync([$tag->id]);
            });

        // tag with 4 relations (should not be included in results)
        $tag = factory(Tag::class)->create(['tag' => 'Hello 2']);
        factory(Href::class, 4)
            ->create(['user_id' => $user->id, 'visible' => true])
            ->each(function (Href $href) use ($tag) {
                $href->tags()->sync([$tag->id]);
            });

        $tagsCount = $this->tagService->getMostUsed()->count();

        $this->assertEquals(
            1, $tagsCount, 'Should find one tag where has five relations with hrefs table'
        );
    }
}