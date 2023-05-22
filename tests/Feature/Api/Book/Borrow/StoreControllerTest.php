<?php

namespace Tests\Feature\Api\Book\Borrow;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class StoreControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_borrow_book(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $book = Book::factory()->create([
            'title' => 'Rendezvous with Rama',
            'description' => 'Rendezvous with Rama description',
            'publisher' => 'RosettaBooks',
            'author' => 'Arthur C. Clarke',
            'cover_photo' => 'https://sample.com/rendezvous_with_rama.jpg',
            'price' => 1850,
        ]);

        $response = $this->postJson('/api/books/' . $book->id . '/borrow');
        $response->assertStatus(201);

        $this->assertEquals($book->id, $user->books->first()->id);
    }

    /** @test */
    public function cannot_borrow_unavailable_book(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $book = Book::factory()->create([
            'title' => 'Rendezvous with Rama',
            'description' => 'Rendezvous with Rama description',
            'publisher' => 'RosettaBooks',
            'author' => 'Arthur C. Clarke',
            'cover_photo' => 'https://sample.com/rendezvous_with_rama.jpg',
            'price' => 1850,
        ]);

        $user->books()->attach($book);

        $response = $this->postJson('/api/books/' . $book->id . '/borrow');
        $response->assertStatus(422);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'already_borrowed')
                ->etc()
        );
    }

    /** @test */
    public function book_not_found()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->postJson('/api/books/999/borrow');
        $response->assertStatus(404);
    }
}
