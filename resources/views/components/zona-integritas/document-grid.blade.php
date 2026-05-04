@props([
    'documents' => collect(),
    'emptyMessage' => 'Belum ada dokumen yang tersedia saat ini.',
])

@php
    $documents = collect($documents);
@endphp

@if ($documents->isNotEmpty())
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($documents as $document)
            <article class="flex h-full flex-col rounded-lg border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-1 hover:border-orange-300 hover:shadow-md">
                <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-lg bg-red-50 text-red-600">
                    <i data-lucide="file-text" class="h-7 w-7"></i>
                </div>
                <h4 class="mb-5 grow text-base font-semibold leading-snug text-slate-900">
                    {{ $document->nama_dokumen }}
                </h4>
                <a href="{{ route('zona-integritas.dokumen.download', $document) }}"
                    class="inline-flex w-fit items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-600">
                    <i data-lucide="download" class="h-4 w-4"></i>
                    Download
                </a>
            </article>
        @endforeach
    </div>
@else
    <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center text-sm font-medium text-slate-500">
        {{ $emptyMessage }}
    </div>
@endif
