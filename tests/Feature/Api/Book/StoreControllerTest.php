<?php

namespace Tests\Feature\Api\Book;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function fail_to_store_book_if_not_manager(): void
    {
        $this->actingAsUser();

        $response = $this->postJson('/api/books', [
            //
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function can_store_book(): void
    {
        $this->actingAsManager();

        $response = $this->postJson('/api/books', [
            'title' => 'Dune',
            'description' => 'Dune description',
            'publisher' => 'Ace',
            'author' => 'Frank Herbert',
            'cover_photo' => 'https://sample.com/dune.jpg',
            'price' => 2436,
        ]);

        $response->assertCreated();
        $response->assertJson(fn (AssertableJson $json) =>
        $json->where('title', 'Dune')
            ->where('description', 'Dune description')
            ->where('publisher', 'Ace')
            ->where('author', 'Frank Herbert')
            ->where('cover_photo', 'https://sample.com/dune.jpg')
            ->where('price', 2436)
            ->where('is_available', true)
            ->etc()
        );
    }
}
