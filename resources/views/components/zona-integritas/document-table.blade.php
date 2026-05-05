@props([
    'documents' => collect(),
    'emptyMessage' => 'Belum ada dokumen yang tersedia saat ini.',
])

@php
    $documents = collect($documents);
@endphp

<div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
    @forelse ($documents as $document)
        <div class="flex items-center justify-between overflow-hidden rounded-lg border border-slate-200 bg-white shadow-sm">
            <div class="flex items-center gap-4">
                <div class="flex w-14 items-center justify-center self-stretch border-r border-slate-100 bg-slate-50 text-sm font-bold text-slate-400">
                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                </div>
                <div class="py-3 pr-2 text-sm font-semibold text-slate-900">
                    {{ $document->nama_dokumen }}
                </div>
            </div>
            <div class="shrink-0 py-3 pl-2 pr-4">
                <a href="{{ route('zona-integritas.dokumen.download', $document) }}"
                    class="inline-flex items-center gap-2 rounded-md bg-slate-900 px-3 py-1.5 text-xs font-bold text-white transition hover:bg-orange-600">
                    <i data-lucide="download" class="h-3.5 w-3.5"></i>
                    <span class="hidden sm:inline">Download</span>
                </a>
            </div>
        </div>
    @empty
        <div class="col-span-full rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center text-sm font-medium text-slate-500">
            {{ $emptyMessage }}
        </div>
    @endforelse
</div>
