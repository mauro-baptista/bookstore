<?php

namespace Tests\Feature\Api\Book;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ValidationTest extends TestCase
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

    public static function rules(): array
    {
        return [
            'missing title' => ['title', null],
            'short title' => ['title', 'a'],
            'long title' => ['title', str('a')->repeat(257)->toString()],
            'short description' => ['description', 'a'],
            'long description' => ['description', str('a')->repeat(2049)->toString()],
            'short publisher' => ['publisher', 'a'],
            'long publisher' => ['publisher', str('a')->repeat(257)->toString()],
            'short author' => ['author', 'a'],
            'long author' => ['author', str('a')->repeat(257)->toString()],
            'invalid cover_photo' => ['cover_photo', 'invalid-url'],
            'missing price' => ['price', null],
            'negative price' => ['price', -1],
            'too high price' => ['price', 1000000],
        ];
    }

    /**
     * @dataProvider rules
     * @test
     */
    public function store_validation(string $field, mixed $value): void
    {
        $this->actingAsManager();

        $response = $this->postJson('/api/books', array_merge([
            'title' => 'Dune',
            'description' => 'Dune description',
            'publisher' => 'Ace',
            'author' => 'Frank Herbert',
            'cover_photo' => 'https://sample.com/dune.jpg',
            'price' => 2436,
        ], [
            $field => $value,
        ]));

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([$field]);
    }

    /**
     * @dataProvider rules
     * @test
     */
    public function update_validation(string $field, mixed $value): void
    {
        $this->actingAsManager();

        $response = $this->putJson('/api/books/' . $this->book->id, array_merge([
            'title' => 'Dune',
            'description' => 'Dune description',
            'publisher' => 'Ace',
            'author' => 'Frank Herbert',
            'cover_photo' => 'https://sample.com/dune.jpg',
            'price' => 2436,
        ], [
            $field => $value,
        ]));

        $this->assertDatabaseHas('books', [
            'id' => $this->book->id,
            'title' => 'Dune Old',
            'description' => 'Dune description  Old',
            'publisher' => 'Ace  Old',
            'author' => 'Frank Herbert  Old',
            'cover_photo' => 'https://sample.com/dune_old.jpg',
            'price' => 0,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([$field]);
    }
}
