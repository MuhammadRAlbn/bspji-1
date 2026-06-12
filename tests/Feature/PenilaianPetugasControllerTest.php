<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PenilaianPetugasControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_petugas_successfully(): void
    {
        $response = $this->postJson('/api/penilaian-petugas/store', [
            'petugas_upp' => 'Irham',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => 'success',
                'message' => 'Data petugas berhasil disimpan',
            ]);

        $this->assertDatabaseHas('pelayanan', [
            'petugas_upp' => 'Irham',
        ]);
    }

    public function test_store_petugas_fails_when_petugas_upp_is_missing(): void
    {
        $response = $this->postJson('/api/penilaian-petugas/store', []);

        $response->assertStatus(422)
            ->assertJson([
                'status' => 'error',
                'message' => 'Validasi gagal',
            ])
            ->assertJsonValidationErrors('petugas_upp');

        $this->assertDatabaseCount('pelayanan', 0);
    }

    public function test_store_petugas_fails_when_petugas_upp_exceeds_max_length(): void
    {
        $response = $this->postJson('/api/penilaian-petugas/store', [
            'petugas_upp' => str_repeat('a', 101),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('petugas_upp');

        $this->assertDatabaseCount('pelayanan', 0);
    }
}
