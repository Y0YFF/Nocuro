<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PvyControllerTest extends TestCase
{
    /**
     * @test
     */
    public function プライバシーポリシーページにアクセスしたら表示する()
    {
        $url = route('pvy');

        $response = $this->get($url);

        $response->assertStatus(200);
    }
}
