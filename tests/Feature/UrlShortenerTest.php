<?php

namespace Tests\Feature;

use App\Models\Url;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UrlShortenerTest extends TestCase
{
    use RefreshDatabase;

    public function test_short_url_is_generated()
    {
        $response = $this->post('/shorten', ['original_url' => 'https://bitsofdev.com']);

        $response->assertStatus(200);
        $this->assertDatabaseHas('urls', ['original_url' => 'https://bitsofdev.com']);
    }

    public function test_redirect_to_original_url()
    {
        $url = Url::create([
            'original_url' => 'https://bitsofdev.com',
            'short_url' => 'abc123',
        ]);

        $response = $this->get('/abc123');

        $response->assertRedirect('https://bitsofdev.com');
    }
}
