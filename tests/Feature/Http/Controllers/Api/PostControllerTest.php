<?php

namespace Tests\Feature\Http\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;
    public function test_store()
    {
        //$this->withoutExceptionHandling();
        $response = $this->json('POST', '/api/posts', [
            'title' => 'El post de prueba'
        ]);

        $response->assertJsonStructure(['id', 'title', 'created_at', 'updated_at'])//validation of json fields
        ->assertJson(['title' => 'El post de prueba'])// what information is in title
        ->assertStatus(201) //OK, resource created
        ;

        $this->assertDatabaseHas('posts', ['title' => 'El post de prueba']);//table post has that title
    }

    public function test_validate_title()
    {
        //saving with empty title
        $response = $this->json('POST', '/api/posts', [
            'title' => ''
        ]);

        $response->assertStatus(422) //Received but not procesed
            ->assertJsonValidationErrors('title');
    }
}
