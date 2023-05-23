<?php

namespace Tests\Feature\Api\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ShowControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_book_details(): void
    {
        $this->actingAs(User::factory()->create());

        $book = Book::factory()->create([
            'title' => 'Rendezvous with Rama',
            'description' => 'Rendezvous with Rama description',
            'publisher' => 'RosettaBooks',
            'author' => 'Arthur C. Clarke',
            'cover_photo' => 'https://sample.com/rendezvous_with_rama.jpg',
            'price' => 1850,
        ]);

        $response = $this->getJson('/api/books/' . $book->id);
        $response->assertStatus(200);

        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('id', $book->id)
                ->where('title', 'Rendezvous with Rama')
                ->where('description', 'Rendezvous with Rama description')
                ->where('publisher', 'RosettaBooks')
                ->where('author', 'Arthur C. Clarke')
                ->where('cover_photo', 'https://sample.com/rendezvous_with_rama.jpg')
                ->where('price', 1850)
                ->where('is_available', true)
                ->etc()
            );
    }

    /** @test */
    public function book_not_found()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson('/api/books/999');
        $response->assertStatus(404);
    }
}
