<?php

namespace Tests\Feature\Livewire;

use App\Livewire\TarifPengujian;
use App\Models\Komoditi;
use App\Models\Lab;
use App\Models\Parameter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Number;
use Livewire\Livewire;
use Tests\TestCase;

class TarifPengujianTest extends TestCase
{
    use RefreshDatabase;

    public function test_component_can_render(): void
    {
        Livewire::test(TarifPengujian::class)
            ->assertOk();
    }

    public function test_displays_komoditi_list(): void
    {
        $lab = Lab::factory()->create();
        $komoditi = Komoditi::factory()->for($lab)->create(['nama' => 'Air Minum']);

        Livewire::test(TarifPengujian::class)
            ->assertSee($komoditi->nama);
    }

    public function test_shows_parameters_when_komoditi_selected(): void
    {
        $lab = Lab::factory()->create();
        $komoditi = Komoditi::factory()->for($lab)->create(['nama' => 'Air Minum']);
        $parameter = Parameter::factory()->for($lab)->for($komoditi)->create([
            'nama' => 'pH',
            'metode_uji' => 'SNI 6989',
            'satuan' => 'pH',
            'harga' => 50000,
        ]);

        Livewire::test(TarifPengujian::class)
            ->set('komoditiId', $komoditi->id)
            ->assertSee($parameter->nama)
            ->assertSee($parameter->metode_uji)
            ->assertSee(Number::currency($parameter->harga, 'IDR', 'id'));
    }

    public function test_only_shows_parameters_for_selected_komoditi(): void
    {
        $lab = Lab::factory()->create();
        $selectedKomoditi = Komoditi::factory()->for($lab)->create();
        $otherKomoditi = Komoditi::factory()->for($lab)->create();

        Parameter::factory()->for($lab)->for($selectedKomoditi)->create(['nama' => 'Parameter Terpilih']);
        Parameter::factory()->for($lab)->for($otherKomoditi)->create(['nama' => 'Parameter Lain']);

        Livewire::test(TarifPengujian::class)
            ->set('komoditiId', $selectedKomoditi->id)
            ->assertSee('Parameter Terpilih')
            ->assertDontSee('Parameter Lain');
    }
}
