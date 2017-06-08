<?php namespace Tests\Services;

use App\Href;
use App\Services\HrefService;
use App\Tag;
use App\User;
use Tests\TestCase;

/**
 * Class HrefServiceTest
 * @package Tests\Services
 */
class HrefServiceTest extends TestCase
{
    /**
     * @var HrefService
     */
    private $hrefService;

    /**
     * Setup the test environment.
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->hrefService = $this->app->make(HrefService::class);
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

        $tagsCount = $this->hrefService->getMostUsedTags()->count();

        $this->assertEquals(
            1, $tagsCount, 'Should find one tag where has five relations with hrefs table'
        );
    }
}