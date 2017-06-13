<?php namespace Tests\Feature;

use App\Href;
use App\User;
use Tests\TestCase;

/**
 * Class HrefApiTest
 * @package Feature
 */
class HrefApiTest extends TestCase
{
    public function testCanGetListOfRootHrefs()
    {
        $user = factory(User::class)->create();
        $href = factory(Href::class)->create([
            'url' => 'testUrl',
            'user_id' => $user->id,
            'parent_id' => 0,
            'visible' => true
        ]);

        factory(Href::class, 2)->create([
            'parent_id' => $href->id,
            'user_id' => $user->id
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/api/href');

        $response->assertStatus(200);
        $response->assertJson([[
            "created_by" => 1,
            "id" => 1,
            "index" => 1,
            "parent_id" => 0,
            "tags" => [],
            "url" => "testUrl",
            "user" => ["id" => 1],
            "user_id" => 1,
            "visible" => true
        ]]);
    }

    public function testCanGetCollectionOfChildHrefs()
    {
        $user = factory(User::class)->create();
        $href = factory(Href::class)->create([
            'url' => '',
            'user_id' => $user->id,
            'parent_id' => 0,
        ]);

        factory(Href::class, 2)->create([
            'url' => 'testUrl',
            'parent_id' => $href->id,
            'user_id' => $user->id
        ]);

        $response = $this
            ->actingAs($user)
            ->get('/api/href/' . $href->id);

        $response->assertStatus(200);
        $response->assertJson([[
            "created_by" => 1,
            "parent_id" => $href->id,
            "url" => "testUrl",
            "user" => ["id" => 1]
        ], [
            "created_by" => 1,
            "parent_id" => $href->id,
            "url" => "testUrl",
            "user" => ["id" => 1]
        ]]);
    }
}