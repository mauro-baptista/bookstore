<?php

namespace Tests\Feature\Api\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DeleteControllerTest extends TestCase
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
    public function fail_to_delete_book_if_not_manager(): void
    {
        $this->actingAsUser();

        $response = $this->deleteJson('/api/books/' . $this->book->id, [
            //
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function can_delete_book(): void
    {
        $this->actingAsManager();

        $response = $this->deleteJson('/api/books/' . $this->book->id);

        $response->assertNoContent();
        $this->assertModelMissing($this->book);
    }
}
