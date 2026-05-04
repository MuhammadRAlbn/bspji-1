@props([
    'documents' => collect(),
    'emptyMessage' => 'Belum ada dokumen yang tersedia saat ini.',
])

@php
    $documents = collect($documents);
@endphp

<div class="overflow-x-auto">
    <table class="w-full min-w-[620px] border-separate border-spacing-y-3 text-left">
        <thead>
            <tr class="text-xs font-bold uppercase tracking-widest text-slate-500">
                <th class="px-5 py-3">No</th>
                <th class="px-5 py-3">Nama Dokumen</th>
                <th class="px-5 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($documents as $document)
                <tr class="bg-white text-sm shadow-sm transition hover:bg-orange-50">
                    <td class="w-20 rounded-l-lg border-y border-l border-slate-200 px-5 py-4 font-bold text-slate-400">
                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                    </td>
                    <td class="border-y border-slate-200 px-5 py-4 font-semibold text-slate-900">
                        {{ $document->nama_dokumen }}
                    </td>
                    <td class="rounded-r-lg border-y border-r border-slate-200 px-5 py-4 text-right">
                        <a href="{{ route('zona-integritas.dokumen.download', $document) }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-slate-900 px-4 py-2 text-xs font-bold text-white transition hover:bg-orange-600">
                            <i data-lucide="download" class="h-4 w-4"></i>
                            Download
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="rounded-lg border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center text-sm font-medium text-slate-500">
                        {{ $emptyMessage }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
