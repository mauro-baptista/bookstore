<?php

namespace Tests\Feature\Api\Book\Borrow;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class IndexControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_borrowed_books(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $book1 = Book::factory()->create([
            'title' => 'I, Robot',
            'description' => 'I, Robot description',
            'publisher' => 'Spectra',
            'author' => 'Isaac Asimov',
            'cover_photo' => 'https://sample.com/i_robot.jpg',
            'price' => 2999,
        ]);

        Book::factory()->create([
            'title' => 'Rendezvous with Rama',
            'description' => 'Rendezvous with Rama description',
            'publisher' => 'RosettaBooks',
            'author' => 'Arthur C. Clarke',
            'cover_photo' => 'https://sample.com/rendezvous_with_rama.jpg',
            'price' => 1850,
        ]);

        $user->books()->attach($book1);

        $response = $this->getJson('/api/books/borrow');
        $response->assertStatus(200);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('0.id', $book1->id)
                ->where('0.title', 'I, Robot')
                ->where('0.description', 'I, Robot description')
                ->where('0.publisher', 'Spectra')
                ->where('0.author', 'Isaac Asimov')
                ->where('0.cover_photo', 'https://sample.com/i_robot.jpg')
                ->where('0.price', 2999)
                ->etc()
        );

        $response->assertJson(fn (AssertableJson $json) =>
            $json->missing('1.id')
        );

        $this->assertCount(1, $response->json());
    }
}
