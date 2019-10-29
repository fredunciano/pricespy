<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class ComparisonTest extends TestCase
{
    /** @test */
    public function it_shows_comparison()
    {
        /*$this->actingAs(User::first())
            ->visit('comparison')
            ->seeStatusCode(200);*/
    }
}
