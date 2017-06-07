<?php namespace Tests\Services;

use App\Href;
use App\Services\TagsService;
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
    use DatabaseMigrations;

    /**
     * @var TagsService
     */
    private $tagService;

    /**
     * Setup the test environment.
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->tagService = $this->app->make(TagsService::class);
    }

    /**
     * Test service can create method.
     * @return void
     */
    public function testCanCreateTag()
    {
        $tag = factory(Tag::class)->make(['tag' => 'Hello']);

        $this->tagService->create($tag);

        $this->assertDatabaseHas('tags', [
            'tag' => 'Hello'
        ]);
    }

    /**
     * Test service can retrieve most used tags with default parameters.
     * @return void
     */
    public function testCanGetTagsRelatedToHref()
    {
        $tag = factory(Tag::class)->create(['tag' => 'Hello']);
        $user = factory(User::class)->create();
        factory(Href::class, 5)
            ->create(['user_id' => $user->id, 'visible' => true])
            ->each(function (Href $href) use ($tag) {
                $href->tags()->sync([$tag->id]);
            });

        $tags = $this->tagService->getMostUsed();

        $hrefs = Href::whereVisible(true)->select(['id']);
        $allTags = Tag::all(['id']);

        $this->assertEquals(
            5, $hrefs->count(), 'Should create five visible hrefs'
        );

        $this->assertEquals(
            1, $allTags->count(), 'Should create one tag'
        );

        $this->assertEquals(
            1, $tags->count(), 'Should find one tag where has five relations with hrefs table'
        );
    }
}