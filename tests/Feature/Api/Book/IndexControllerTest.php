<?php

namespace Tests\Feature\Api\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_books_list(): void
    {
        $this->actingAs(User::factory()->create());

        $book1 = Book::factory()->create([
            'title' => 'I, Robot',
            'description' => 'I, Robot description',
            'publisher' => 'Spectra',
            'author' => 'Isaac Asimov',
            'cover_photo' => 'https://sample.com/i_robot.jpg',
            'price' => 2999,
        ]);

        $book2 = Book::factory()->create([
            'title' => 'Rendezvous with Rama',
            'description' => 'Rendezvous with Rama description',
            'publisher' => 'RosettaBooks',
            'author' => 'Arthur C. Clarke',
            'cover_photo' => 'https://sample.com/rendezvous_with_rama.jpg',
            'price' => 1850,
        ]);

        $response = $this->getJson('/api/books');
        $response->assertStatus(200);

        $content = $response->json();

        $this->assertEquals([
            'id' => $book1->id,
            'title' => 'I, Robot',
            'description' => 'I, Robot description',
            'publisher' => 'Spectra',
            'author' => 'Isaac Asimov',
            'cover_photo' => 'https://sample.com/i_robot.jpg',
            'price' => 2999,
        ], $content[0]);

        $this->assertEquals([
            'id' => $book2->id,
            'title' => 'Rendezvous with Rama',
            'description' => 'Rendezvous with Rama description',
            'publisher' => 'RosettaBooks',
            'author' => 'Arthur C. Clarke',
            'cover_photo' => 'https://sample.com/rendezvous_with_rama.jpg',
            'price' => 1850,
        ], $content[1]);
    }
}
