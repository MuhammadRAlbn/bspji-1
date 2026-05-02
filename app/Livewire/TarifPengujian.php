<?php

namespace App\Livewire;

use App\Models\Komoditi;
use App\Models\Parameter;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Component;

class TarifPengujian extends Component
{
    public ?int $komoditiId = null;

    public function selectKomoditi(int $komoditiId): void
    {
        $this->komoditiId = $komoditiId;
    }

    public function render(): View
    {
        $komoditis = Komoditi::query()
            ->select(['id', 'nama'])
            ->orderBy('nama')
            ->get();

        $parameters = $this->parameters();
        $selectedKomoditi = $this->komoditiId
            ? $komoditis->firstWhere('id', $this->komoditiId)
            : null;

        return view('livewire.tarif-pengujian', compact('komoditis', 'parameters', 'selectedKomoditi'));
    }

    private function parameters(): Collection
    {
        if (! $this->komoditiId) {
            return collect();
        }

        return Parameter::query()
            ->where('komoditi_id', $this->komoditiId)
            ->select(['id', 'nama', 'metode_uji', 'satuan', 'harga'])
            ->orderBy('nama')
            ->get();
    }
}
