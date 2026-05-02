<?php

namespace App\Livewire;

use App\Models\Komoditi;
use App\Models\Parameter;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;

class TarifPengujian extends Component
{
    public ?int $komoditiId = null;

    public function selectKomoditi(int $komoditiId): void
    {
        if ($this->komoditiId === $komoditiId) {
            return;
        }

        $selectedKomoditiId = Komoditi::query()
            ->whereKey($komoditiId)
            ->value('id');

        $this->komoditiId = $selectedKomoditiId ? (int) $selectedKomoditiId : null;

        unset($this->parameters, $this->selectedKomoditi);
    }

    #[Computed]
    public function komoditis(): Collection
    {
        return Komoditi::query()
            ->select(['id', 'nama'])
            ->orderBy('nama')
            ->get();
    }

    #[Computed]
    public function parameters(): Collection
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

    #[Computed]
    public function selectedKomoditi(): ?Komoditi
    {
        return $this->komoditiId
            ? $this->komoditis->firstWhere('id', $this->komoditiId)
            : null;
    }

    public function render(): View
    {
        return view('livewire.tarif-pengujian');
    }
}
