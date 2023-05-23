<?php

namespace Tests\Feature\Api\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class UpdateControllerTest extends TestCase
{
    use RefreshDatabase;

    private Book $book;

    public function setUp(): void
    {
        parent::setUp();

        $this->book = Book::factory()->create([
            'title' => 'Dune Old',
            'description' => 'Dune description  Old',
            'publisher' => 'Ace  Old',
            'author' => 'Frank Herbert  Old',
            'cover_photo' => 'https://sample.com/dune_old.jpg',
            'price' => 0,
        ]);
    }

    /** @test */
    public function fail_to_update_book_if_not_manager(): void
    {
        $this->actingAs(User::factory()->create());

        $response = $this->putJson('/api/books/' . $this->book->id, [
            //
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function can_store_book(): void
    {
        $this->actingAsManager();

        $response = $this->putJson('/api/books/' . $this->book->id, [
            'title' => 'Dune',
            'description' => 'Dune description',
            'publisher' => 'Ace',
            'author' => 'Frank Herbert',
            'cover_photo' => 'https://sample.com/dune.jpg',
            'price' => 2436,
        ]);

        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->where('id', $this->book->id)
            ->where('title', 'Dune')
            ->where('description', 'Dune description')
            ->where('publisher', 'Ace')
            ->where('author', 'Frank Herbert')
            ->where('cover_photo', 'https://sample.com/dune.jpg')
            ->where('price', 2436)
            ->etc()
        );
    }
}
