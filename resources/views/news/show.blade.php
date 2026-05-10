<x-layouts.app :title="$news->title . ' - BSPJI Banda Aceh'">
    @php
        $fallbackImage = asset('images/imagelab.webp');
        $coverImage = $news->cover_image ? asset('storage/' . $news->cover_image) : $fallbackImage;
    @endphp

    <section class="mx-auto mt-6 max-w-6xl px-6">
        <a href="{{ route('berita.index') }}"
            class="mb-5 inline-flex items-center text-sm font-semibold text-slate-500 transition hover:text-orange-500">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Berita
        </a>

        <div class="grid items-center gap-8 rounded-3xl bg-slate-100 p-6 md:grid-cols-[1.05fr_0.95fr] md:p-10">
            <div class="space-y-5">
                <p class="text-sm font-bold uppercase tracking-wide text-orange-500">
                    {{ $news->published_at?->format('d M Y') }}
                </p>
                <h1 class="text-3xl font-extrabold leading-tight text-slate-900 md:text-5xl">
                    {{ $news->title }}
                </h1>
                @if ($news->excerpt)
                    <p class="max-w-2xl text-lg leading-8 text-slate-600">{{ $news->excerpt }}</p>
                @endif
            </div>

            <img src="{{ $coverImage }}" alt="{{ $news->title }}" class="aspect-[4/3] w-full rounded-3xl object-cover">
        </div>
    </section>

    <section class="mx-auto grid max-w-6xl gap-10 px-6 py-10 lg:grid-cols-[minmax(0,1fr)_360px]">
        <article class="min-w-0">
            <div class="rounded-2xl border border-slate-200 bg-white p-6 leading-8 text-slate-700 shadow-sm md:p-8 [&_a]:font-semibold [&_a]:text-orange-500 [&_li]:mb-2 [&_ol]:mb-5 [&_ol]:list-decimal [&_ol]:pl-6 [&_p]:mb-5 [&_strong]:text-slate-900 [&_ul]:mb-5 [&_ul]:list-disc [&_ul]:pl-6">
                {!! $news->body !!}
            </div>
        </article>

        <aside class="space-y-5">
            @if (session('comment_status'))
                <div class="rounded-2xl border border-green-200 bg-green-50 p-4 text-sm font-semibold text-green-700">
                    {{ session('comment_status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm font-semibold text-red-700">
                    Periksa kembali isian komentar.
                </div>
            @endif

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-xl font-extrabold text-slate-800">Tinggalkan Komentar</h2>
                <div class="mt-5">
                    <x-news.comment-form :news="$news" />
                </div>
            </div>
        </aside>
    </section>

    <section class="mx-auto max-w-6xl px-6 pb-12">
        <div class="mb-6 flex items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-800">Komentar</h2>
            </div>
        </div>

        @if ($news->rootComments->isEmpty())
            <div class="rounded-2xl border border-slate-200 bg-white p-8 text-center text-slate-500 shadow-sm">
                Belum ada komentar.
            </div>
        @else
            <div class="space-y-5">
                @foreach ($news->rootComments as $comment)
                    <div x-data="{ replying: false }" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="font-extrabold text-slate-800">{{ $comment->author_name }}</h3>
                                <p class="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-400">
                                    {{ $comment->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                </p>
                            </div>
                            <button type="button" @click="replying = !replying"
                                class="rounded-full border border-slate-200 px-4 py-2 text-xs font-bold text-slate-600 transition hover:border-orange-300 hover:text-orange-500">
                                Balas
                            </button>
                        </div>

                        <p class="mt-4 whitespace-pre-line leading-7 text-slate-700">{{ $comment->content }}</p>

                        <div x-show="replying" x-transition class="mt-5 rounded-2xl bg-slate-50 p-4" style="display: none;">
                            <x-news.comment-form :news="$news" :parent-id="$comment->id" button-label="Kirim Balasan" />
                        </div>

                        @if ($comment->orderedReplies->isNotEmpty())
                            <div class="mt-5 space-y-4 border-l-2 border-orange-100 pl-4">
                                @foreach ($comment->orderedReplies as $reply)
                                    <div class="rounded-2xl bg-slate-50 p-4">
                                        <div class="flex items-center justify-between gap-4">
                                            <h4 class="font-extrabold text-slate-800">{{ $reply->author_name }}</h4>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                                {{ $reply->created_at->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB
                                            </p>
                                        </div>
                                        <p class="mt-3 whitespace-pre-line leading-7 text-slate-700">{{ $reply->content }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</x-layouts.app>
