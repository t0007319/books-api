<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test index method.
     *
     * @return void
     */
    public function testIndex(): void
    {
        // Create some sample books in the database
        Book::factory()->count(5)->create();

        // Send a GET request to the /api/books endpoint
        $response = $this->get('/api/books');

        // Assert that the response has a 200 (OK) status code
        $response->assertStatus(200);

        // Assert that the response contains the book titles
        $books = Book::all();
        foreach ($books as $book) {
            $response->assertSee($book->title);
        }
    }


    /**
     * Test show method.
     *
     * @return void
     */
    public function testShow(): void
    {
        // Create a sample book in the database
        $book = Book::factory()->create();

        // Send a GET request to the /api/books/{id} endpoint
        $response = $this->get('/api/books/' . $book->id);

        // Assert that the response has a 200 (OK) status code
        $response->assertStatus(200);

        // Assert that the response contains the book title
        $response->assertSee($book->title);
    }
}
