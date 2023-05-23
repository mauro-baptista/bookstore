<?php

namespace Tests\Feature\Api\Book;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ValidationTest extends TestCase
{
    use RefreshDatabase;

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
    public function validation(string $field, mixed $value): void
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
}
