<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TrmControllerTest extends TestCase
{
    /**
     * @test
     */
    public function 利用規約ページにアクセスしたら表示する()
    {
        $url = route('trm');

        $response = $this->get($url);

        $response->assertStatus(200);
    }
}
