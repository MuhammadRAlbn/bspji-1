<?php

namespace Tests\Feature\Filament\Pengujian;

use App\Filament\Clusters\Pengujian\Resources\KomoditiResource;
use App\Filament\Clusters\Pengujian\Resources\KomoditiResource\Pages\CreateKomoditi;
use App\Filament\Clusters\Pengujian\Resources\KomoditiResource\Pages\ListKomoditis;
use App\Models\Komoditi;
use App\Models\Lab;
use App\Models\Parameter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class KomoditiResourceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_can_render_list_page(): void
    {
        $this->get(KomoditiResource::getUrl('index'))
            ->assertOk();
    }

    public function test_can_list_komoditis(): void
    {
        $lab = Lab::factory()->create();
        $komoditi = Komoditi::factory()->for($lab)->create();

        Livewire::test(ListKomoditis::class)
            ->assertCanSeeTableRecords([$komoditi]);
    }

    public function test_can_create_komoditi(): void
    {
        $lab = Lab::factory()->create();

        Livewire::test(CreateKomoditi::class)
            ->fillForm([
                'nama' => 'Kopi Arabika',
                'lab_id' => $lab->id,
                'peraturan' => 'Peraturan uji kopi',
                'keterangan' => 'Komoditi pangan',
            ])
            ->call('create')
            ->assertHasNoFormErrors();

        $this->assertDatabaseHas('komoditis', [
            'nama' => 'Kopi Arabika',
            'lab_id' => $lab->id,
        ]);
    }

    public function test_can_validate_required_fields(): void
    {
        Livewire::test(CreateKomoditi::class)
            ->fillForm([
                'nama' => null,
                'lab_id' => null,
            ])
            ->call('create')
            ->assertHasFormErrors(['nama' => 'required', 'lab_id' => 'required']);
    }

    public function test_delete_komoditi_cascades_parameters(): void
    {
        $lab = Lab::factory()->create();
        $komoditi = Komoditi::factory()->for($lab)->create();
        $parameter = Parameter::factory()->for($lab)->for($komoditi)->create();

        $komoditi->delete();

        $this->assertModelMissing($komoditi);
        $this->assertModelMissing($parameter);
    }
}
