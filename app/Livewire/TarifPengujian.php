<?php

namespace App\Livewire;

use App\Models\Komoditi;
use App\Models\Parameter;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

class TarifPengujian extends Component
{
    use WithPagination;

    public ?int $komoditiId = null;

    private const PARAMETERS_PER_PAGE = 10;

    public function selectKomoditi(int $komoditiId): void
    {
        if ($this->komoditiId === $komoditiId) {
            return;
        }

        $selectedKomoditiId = Komoditi::query()
            ->whereKey($komoditiId)
            ->value('id');

        $this->komoditiId = $selectedKomoditiId ? (int) $selectedKomoditiId : null;

        $this->resetPage();

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
    public function parameters(): LengthAwarePaginator
    {
        return Parameter::query()
            ->where('komoditi_id', $this->komoditiId)
            ->select(['id', 'nama', 'metode_uji', 'harga'])
            ->orderBy('nama')
            ->paginate(self::PARAMETERS_PER_PAGE);
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
