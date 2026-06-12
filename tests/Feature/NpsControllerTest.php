<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NpsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_nps_successfully(): void
    {
        $response = $this->postJson('/api/nps/store', [
            'nps' => 8,
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Skor NPS berhasil disimpan',
            ]);

        $this->assertDatabaseHas('tbl_nps', [
            'nps' => 8,
        ]);
    }

    public function test_store_nps_fails_when_nps_is_missing(): void
    {
        $response = $this->postJson('/api/nps/store', []);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validasi gagal',
            ])
            ->assertJsonValidationErrors('nps');

        $this->assertDatabaseCount('tbl_nps', 0);
    }

    public function test_store_nps_fails_when_nps_exceeds_max_value(): void
    {
        $response = $this->postJson('/api/nps/store', [
            'nps' => 11,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('nps');

        $this->assertDatabaseCount('tbl_nps', 0);
    }

    public function test_store_nps_fails_when_nps_is_below_min_value(): void
    {
        $response = $this->postJson('/api/nps/store', [
            'nps' => -1,
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('nps');

        $this->assertDatabaseCount('tbl_nps', 0);
    }

    public function test_store_nps_fails_when_nps_is_not_integer(): void
    {
        $response = $this->postJson('/api/nps/store', [
            'nps' => 'bukan-angka',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('nps');

        $this->assertDatabaseCount('tbl_nps', 0);
    }
}
