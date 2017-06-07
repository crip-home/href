<?php namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

/**
 * Class ExampleTest
 * @package Tests\Unit
 */
class ExampleTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }
}
