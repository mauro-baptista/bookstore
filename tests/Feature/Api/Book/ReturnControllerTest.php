<?php

namespace Tests\Feature\Api\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ReturnControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_return_book(): void
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

        $response = $this->getJson('/api/books/' . $book->id . '/return');
        $response->assertStatus(204);

        $this->assertTrue($book->users->isEmpty());
    }

    /** @test */
    public function cannot_return_non_borrowed_book(): void
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

        $response = $this->getJson('/api/books/' . $book->id . '/return');
        $response->assertStatus(422);
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'not_borrowed')
                ->etc()
        );

        $this->assertTrue($book->users->isEmpty());
    }

    /** @test */
    public function cannot_return_book_borrowed_by_other_user(): void
    {
        $user = User::factory()->create();
        $anotherUser = User::factory()->create();

        $this->actingAs($user);

        $book = Book::factory()->create([
            'title' => 'Rendezvous with Rama',
            'description' => 'Rendezvous with Rama description',
            'publisher' => 'RosettaBooks',
            'author' => 'Arthur C. Clarke',
            'cover_photo' => 'https://sample.com/rendezvous_with_rama.jpg',
            'price' => 1850,
        ]);

        $anotherUser->books()->attach($book);

        $response = $this->getJson('/api/books/' . $book->id . '/return');
        $response->assertStatus(422);
        $response->assertJson(fn (AssertableJson $json) =>
        $json->where('message', 'not_borrowed')
            ->etc()
        );
        $this->assertTrue($book->users->isNotEmpty());
    }

    /** @test */
    public function book_not_found()
    {
        $this->actingAs(User::factory()->create());

        $response = $this->getJson('/api/books/999/return');
        $response->assertStatus(404);
    }
}
