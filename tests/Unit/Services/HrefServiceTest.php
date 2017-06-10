<?php namespace Tests\Services;

use App\Category;
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

    /**
     * Test service can retrieve most active users created hrefs.
     * @return void
     */
    public function testCanGetOnlyActiveUsers()
    {
        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();

        factory(Href::class, 9)->create([
            'user_id' => $user1->id,
            'visible' => true
        ]);
        factory(Href::class)->create([
            'user_id' => $user1->id,
            'visible' => false
        ]);

        factory(Href::class, 15)->create([
            'user_id' => $user2->id,
            'visible' => true
        ]);

        $usersCount = $this->hrefService->getMostActiveAuthors(2, 15)->count();

        $this->assertEquals(
            1, $usersCount, 'Should find one user where has ten visible hrefs'
        );
    }

    /**
     * Test service can retrieve most used categories for hrefs.
     * @return void
     */
    public function testCanGetOnlyMostUsedCategories()
    {
        factory(User::class)->create();

        $cat1 = factory(Category::class)->create();
        $cat2 = factory(Category::class)->create();

        factory(Href::class, 9)->create([
            'category_id' => $cat1->id,
            'visible' => true
        ]);
        factory(Href::class)->create([
            'category_id' => $cat1->id,
            'visible' => false
        ]);

        factory(Href::class, 10)->create([
            'category_id' => $cat2->id,
            'visible' => true
        ]);

        $categoryCount = $this->hrefService
            ->getMostUsedCategories(2, 10)->count();

        $this->assertEquals(
            1, $categoryCount, 'Should find one category where has ten visible hrefs'
        );
    }

    /**
     * Test service can retrieve paginated hrefs ordered bay date.
     * @return void
     */
    public function testCanGetHrefsPaginated()
    {
        factory(User::class)->create();

        factory(Href::class, 15)->create([
            'visible' => true,
            'date_added' => '2017-06-10'
        ]);
        factory(Href::class, 10)->create([
            'visible' => true,
            'date_added' => '2017-06-09'
        ]);
        factory(Href::class, 10)->create([
            'visible' => false,
            'date_added' => '2017-06-08'
        ]);

        $paginated = $this->hrefService
            ->paginateFiltered([], [], [], []);

        $this->assertEquals(
            25, $paginated->total(), 'Should find all visible hrefs'
        );

        $this->assertEquals(
            15, count($paginated->items()), 'Should have 15 records in results'
        );

        collect($paginated->items())->each(function($item) {
            $this->assertEquals(
                '2017-06-10', $item->date_added->toDateString(),
                'All dates should be only latest in first page'
            );
        });
    }

    /**
     * Test service can group paginated hrefs ordered bay date.
     * @return void
     */
    public function testCanGroupPaginatedResultsByDate()
    {
        factory(User::class)->create();

        factory(Href::class, 5)->create([
            'visible' => true,
            'date_added' => '2017-06-10'
        ]);
        factory(Href::class, 5)->create([
            'visible' => true,
            'date_added' => '2017-06-09'
        ]);
        factory(Href::class, 5)->create([
            'visible' => true,
            'date_added' => '2017-06-08'
        ]);

        $paginated = $this->hrefService
            ->paginateFiltered([], [], [], []);

        $grouped = $this->hrefService->groupByDays($paginated);

        $this->assertEquals(
            3, count($grouped), 'Should create 3 groupf of hrefs'
        );

        $this->assertEquals(
            true, array_key_exists('2017-06-10', $grouped)
        );

        $this->assertEquals(
            true, array_key_exists('2017-06-09', $grouped)
        );

        $this->assertEquals(
            true, array_key_exists('2017-06-08', $grouped)
        );
    }
}