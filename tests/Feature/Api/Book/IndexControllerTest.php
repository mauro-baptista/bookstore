<?php

namespace Tests\Feature\Api\Book;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
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
            $json->where('1.id', $book2->id)
                ->where('1.title', 'Rendezvous with Rama')
                ->where('1.description', 'Rendezvous with Rama description')
                ->where('1.publisher', 'RosettaBooks')
                ->where('1.author', 'Arthur C. Clarke')
                ->where('1.cover_photo', 'https://sample.com/rendezvous_with_rama.jpg')
                ->where('1.price', 1850)
                ->etc()
        );
    }
}
