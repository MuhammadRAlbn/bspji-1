<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PengujianPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengujian_page_loads_successfully(): void
    {
        $this->get(route('pengujian.index'))
            ->assertOk();
    }

    public function test_page_contains_livewire_component(): void
    {
        $this->get(route('pengujian.index'))
            ->assertOk()
            ->assertSeeLivewire('tarif-pengujian');
    }
}
