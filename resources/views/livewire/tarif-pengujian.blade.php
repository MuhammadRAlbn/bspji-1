<div class="space-y-6">
    <div
        x-data="{
            open: false,
            query: @js($this->selectedKomoditi?->nama ?? ''),
            hasMatch: true,
            filterItems() {
                const term = this.query.trim().toLowerCase();
                let visible = 0;

                this.$refs.options.querySelectorAll('[data-komoditi-option]').forEach((option) => {
                    const matches = ! term || option.dataset.nama.includes(term);

                    option.style.display = matches ? 'block' : 'none';

                    if (matches) {
                        visible++;
                    }
                });

                this.hasMatch = visible > 0;
            },
            choose(nama) {
                this.query = nama;
                this.open = false;
            },
        }"
        @click.outside="open = false"
        class="space-y-5 rounded-[24px] border border-black/20 bg-[#fbfbfd] p-5 sm:rounded-[30px] sm:p-8"
    >
        <label for="tarif-komoditi-search" class="block text-sm font-bold uppercase tracking-wider text-[#1d1d1f]">
            Cari berdasarkan komoditi/produk
        </label>

        <div class="relative">
            <input
                id="tarif-komoditi-search"
                x-model="query"
                @focus="open = true"
                @input="open = true; filterItems()"
                type="text"
                autocomplete="off"
                placeholder="Ketik nama komoditi atau produk"
                class="w-full rounded-2xl border border-black/20 bg-white px-5 py-4 pr-12 font-medium text-slate-700 transition-all placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-slate-200"
            >
            <button
                type="button"
                @click="open = ! open"
                class="absolute inset-y-0 right-4 flex items-center text-slate-500"
                aria-label="Buka daftar komoditi"
            >
                <svg class="h-4 w-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <div
                x-show="open"
                x-transition.opacity.duration.150ms
                x-ref="options"
                class="absolute z-30 mt-2 max-h-72 w-full overflow-y-auto rounded-2xl border border-black/10 bg-white py-2 shadow-xl"
                style="display: none;"
            >
                @foreach($this->komoditis as $komoditi)
                    <button
                        type="button"
                        wire:key="tarif-komoditi-{{ $komoditi->id }}"
                        wire:click="selectKomoditi({{ $komoditi->id }})"
                        @disabled($komoditiId === $komoditi->id)
                        aria-current="{{ $komoditiId === $komoditi->id ? 'true' : 'false' }}"
                        data-komoditi-option
                        data-nama="{{ str($komoditi->nama)->lower() }}"
                        @click="choose(@js($komoditi->nama))"
                        class="block w-full px-5 py-3 text-left text-sm font-semibold text-slate-700 transition-colors hover:bg-slate-50 disabled:cursor-default disabled:bg-slate-100 disabled:text-slate-900"
                    >
                        {{ $komoditi->nama }}
                    </button>
                @endforeach

                <template x-if="! hasMatch">
                    <p class="px-5 py-6 text-center text-sm font-medium text-slate-400">
                        Komoditi tidak ditemukan.
                    </p>
                </template>
            </div>
        </div>

        @if($this->selectedKomoditi)
            <p class="text-sm font-medium text-slate-500">
                Menampilkan parameter untuk <span class="font-bold text-slate-800">{{ $this->selectedKomoditi->nama }}</span>.
            </p>
        @endif
    </div>

    <div wire:loading wire:target="selectKomoditi" class="w-full">
        <div class="flex items-center justify-center space-x-3 rounded-[24px] border-2 border-dashed border-black/5 py-10 sm:rounded-[30px]">
            <svg class="h-6 w-6 animate-spin text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="font-medium text-slate-500">Sedang memuat data parameter...</p>
        </div>
    </div>

    <div wire:loading.remove wire:target="selectKomoditi">
        @if($komoditiId && $this->parameters->isNotEmpty())
            <div class="overflow-hidden rounded-2xl border border-black/20 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse text-left">
                    <thead>
                        <tr class="border-b border-black/20 bg-slate-50">
                            <th class="px-4 py-4 text-xs font-bold uppercase tracking-wider text-[#1d1d1f] sm:px-6 sm:text-sm">No</th>
                            <th class="px-4 py-4 text-xs font-bold uppercase tracking-wider text-[#1d1d1f] sm:px-6 sm:text-sm">Parameter</th>
                            <th class="px-4 py-4 text-xs font-bold uppercase tracking-wider text-[#1d1d1f] sm:px-6 sm:text-sm">Metode Uji</th>
                            <th class="px-4 py-4 text-xs font-bold uppercase tracking-wider text-[#1d1d1f] sm:px-6 sm:text-sm">Satuan</th>
                            <th class="px-4 py-4 text-right text-xs font-bold uppercase tracking-wider text-[#1d1d1f] sm:px-6 sm:text-sm">Harga</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-black/10">
                        @foreach($this->parameters as $parameter)
                            <tr wire:key="parameter-{{ $parameter->id }}" class="transition-colors hover:bg-slate-50/50">
                                <td class="px-4 py-4 text-sm text-[#86868b] sm:px-6">{{ $loop->iteration }}</td>
                                <td class="px-4 py-4 text-sm font-semibold text-[#1d1d1f] sm:px-6">{{ $parameter->nama }}</td>
                                <td class="px-4 py-4 text-sm text-[#86868b] sm:px-6">{{ $parameter->metode_uji ?: '-' }}</td>
                                <td class="px-4 py-4 text-sm text-[#86868b] sm:px-6">{{ $parameter->satuan ?: '-' }}</td>
                                <td class="px-4 py-4 text-right text-sm font-bold text-slate-800 sm:px-6">
                                    {{ $parameter->harga === null ? '-' : \Illuminate\Support\Number::currency($parameter->harga, 'IDR', 'id') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @elseif($komoditiId)
            <div class="rounded-[24px] border-2 border-dashed border-black/5 py-10 text-center sm:rounded-[30px]">
                <p class="font-medium text-slate-400">Parameter untuk komoditi ini belum tersedia.</p>
            </div>
        @else
            <div class="rounded-[24px] border-2 border-dashed border-black/5 py-10 text-center sm:rounded-[30px]">
                <p class="font-medium text-slate-400">Pilih komoditi untuk melihat daftar parameter dan tarif pengujian.</p>
            </div>
        @endif
    </div>
</div>
