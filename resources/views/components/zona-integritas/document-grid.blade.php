@props([
    'documents' => collect(),
    'emptyMessage' => 'Belum ada dokumen yang tersedia saat ini.',
    'gridClass' => 'grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-4',
    'layout' => 'card',
])

@php
    $documents = collect($documents);
@endphp

@if ($documents->isNotEmpty())
    @if ($layout === 'list')
        <div class="flex flex-col gap-3">
            @foreach ($documents as $document)
                <div class="flex items-center gap-3 rounded-lg border border-slate-200 bg-white p-3 shadow-sm transition hover:border-orange-300">
                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50 text-red-600">
                        <i data-lucide="file-text" class="h-5 w-5"></i>
                    </div>
                    <h4 class="grow text-sm font-semibold leading-snug text-slate-900">
                        {{ $document->nama_dokumen }}
                    </h4>
                    <a href="{{ route('zona-integritas.dokumen.download', $document) }}"
                        class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-slate-900 text-white transition hover:bg-orange-600" title="Download">
                        <i data-lucide="download" class="h-4 w-4"></i>
                    </a>
                </div>
            @endforeach
        </div>
    @else
        <div class="grid {{ $gridClass }}">
            @foreach ($documents as $document)
                <article class="flex h-full flex-col rounded-lg border border-slate-200 bg-white p-5 shadow-sm">
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
    @endif
@else
    <div class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center text-sm font-medium text-slate-500">
        {{ $emptyMessage }}
    </div>
@endif
