<?php

namespace Tests\Feature\Filament\Pengujian;

use App\Filament\Clusters\Pengujian\Resources\KomoditiResource\Pages\EditKomoditi;
use App\Filament\Clusters\Pengujian\Resources\KomoditiResource\RelationManagers\ParameterRelationManager;
use App\Models\Komoditi;
use App\Models\Lab;
use App\Models\Parameter;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class ParameterRelationManagerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->actingAs(User::factory()->create());
    }

    public function test_can_render_relation_manager(): void
    {
        $lab = Lab::factory()->create();
        $komoditi = Komoditi::factory()->for($lab)->create();

        Livewire::test(ParameterRelationManager::class, [
            'ownerRecord' => $komoditi,
            'pageClass' => EditKomoditi::class,
        ])->assertOk();
    }

    public function test_can_list_parameters(): void
    {
        $lab = Lab::factory()->create();
        $komoditi = Komoditi::factory()->for($lab)->create();
        $parameter = Parameter::factory()->for($lab)->for($komoditi)->create();

        Livewire::test(ParameterRelationManager::class, [
            'ownerRecord' => $komoditi,
            'pageClass' => EditKomoditi::class,
        ])->assertCanSeeTableRecords([$parameter]);
    }
}
