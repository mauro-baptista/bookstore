<?php

namespace Tests\Feature\Api\Book\Borrow;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class DeleteControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_return_book(): void
    {
        $user = $this->actingAsUser();

        $book = Book::factory()->create([
            'title' => 'Rendezvous with Rama',
            'description' => 'Rendezvous with Rama description',
            'publisher' => 'RosettaBooks',
            'author' => 'Arthur C. Clarke',
            'cover_photo' => 'https://sample.com/rendezvous_with_rama.jpg',
            'price' => 1850,
        ]);

        $user->books()->attach($book);

        $response = $this->deleteJson('/api/books/' . $book->id . '/borrow');
        $response->assertNoContent();

        $this->assertTrue($book->users->isEmpty());
    }

    /** @test */
    public function cannot_return_non_borrowed_book(): void
    {
        $this->actingAsUser();

        $book = Book::factory()->create([
            'title' => 'Rendezvous with Rama',
            'description' => 'Rendezvous with Rama description',
            'publisher' => 'RosettaBooks',
            'author' => 'Arthur C. Clarke',
            'cover_photo' => 'https://sample.com/rendezvous_with_rama.jpg',
            'price' => 1850,
        ]);

        $response = $this->deleteJson('/api/books/' . $book->id . '/borrow');
        $response->assertUnprocessable();
        $response->assertJson(fn (AssertableJson $json) =>
            $json->where('message', 'not_borrowed')
                ->etc()
        );

        $this->assertTrue($book->users->isEmpty());
    }

    /** @test */
    public function cannot_return_book_borrowed_by_other_user(): void
    {
        $this->actingAsUser();
        $anotherUser = User::factory()->create();

        $book = Book::factory()->create([
            'title' => 'Rendezvous with Rama',
            'description' => 'Rendezvous with Rama description',
            'publisher' => 'RosettaBooks',
            'author' => 'Arthur C. Clarke',
            'cover_photo' => 'https://sample.com/rendezvous_with_rama.jpg',
            'price' => 1850,
        ]);

        $anotherUser->books()->attach($book);

        $response = $this->deleteJson('/api/books/' . $book->id . '/borrow');
        $response->assertUnprocessable();
        $response->assertJson(fn (AssertableJson $json) =>
        $json->where('message', 'not_borrowed')
            ->etc()
        );
        $this->assertTrue($book->users->isNotEmpty());
    }

    /** @test */
    public function book_not_found()
    {
        $this->actingAsUser();

        $response = $this->deleteJson('/api/books/999/borrow');
        $response->assertNotFound();
    }
}
