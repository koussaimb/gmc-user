<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->call('GET', '/');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function routeApiUserTest()
    {
        $response = $this->call('GET', '/api/users/');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function routeApiTasksTest()
    {
        $response = $this->call('POST', '/api/tasks/');

        $response->assertStatus(200);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function routeApiAddUserTest()
    {
        $json = '
            {
                "name" : "koussay",
                "first_name" : "mb",
                "email" : "mb@gmail.Com"
            }';

        $response = $this->call('POST', '/api/users/', array(), array(), array(), array(), $json);

        $response->assertStatus(200);
    }
}
