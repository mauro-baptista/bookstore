<?php

namespace Tests\Feature\Api\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $content = $response->json();

        $this->assertEquals([
            'id' => $book->id,
            'title' => 'Rendezvous with Rama',
            'description' => 'Rendezvous with Rama description',
            'publisher' => 'RosettaBooks',
            'author' => 'Arthur C. Clarke',
            'cover_photo' => 'https://sample.com/rendezvous_with_rama.jpg',
            'price' => 1850,
        ], $content);
    }
}
