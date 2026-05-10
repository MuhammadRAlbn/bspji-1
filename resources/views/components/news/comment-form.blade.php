@props([
    'news',
    'parentId' => null,
    'buttonLabel' => 'Kirim Komentar',
])

<form method="POST" action="{{ route('berita.comments.store', $news) }}" class="space-y-4">
    @csrf

    @if ($parentId)
        <input type="hidden" name="parent_id" value="{{ $parentId }}">
    @endif

    <div class="hidden" aria-hidden="true">
        <label for="website_{{ $parentId ?? 'root' }}">Website</label>
        <input id="website_{{ $parentId ?? 'root' }}" type="text" name="website" value="" tabindex="-1"
            autocomplete="off">
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div class="space-y-2">
            <label for="author_name_{{ $parentId ?? 'root' }}" class="text-sm font-semibold text-slate-700">Nama</label>
            <input id="author_name_{{ $parentId ?? 'root' }}" type="text" name="author_name"
                value="{{ old('author_name') }}"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                required maxlength="100">
            @error('author_name')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="space-y-2">
            <label for="author_email_{{ $parentId ?? 'root' }}" class="text-sm font-semibold text-slate-700">Email</label>
            <input id="author_email_{{ $parentId ?? 'root' }}" type="email" name="author_email"
                value="{{ old('author_email') }}"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
                required maxlength="255">
            @error('author_email')
                <p class="text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="space-y-2">
        <label for="content_{{ $parentId ?? 'root' }}" class="text-sm font-semibold text-slate-700">Komentar</label>
        <textarea id="content_{{ $parentId ?? 'root' }}" name="content" rows="4"
            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-800 outline-none transition focus:border-orange-400 focus:ring-4 focus:ring-orange-100"
            required minlength="3" maxlength="2000">{{ old('content') }}</textarea>
        @error('content')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
        @error('parent_id')
            <p class="text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <button type="submit"
        class="inline-flex items-center justify-center rounded-full bg-orange-500 px-6 py-3 text-sm font-bold text-white shadow-md shadow-orange-100 transition hover:bg-orange-600">
        {{ $buttonLabel }}
    </button>
</form>
