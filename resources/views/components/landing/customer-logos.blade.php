@props([
    'logoItems',
    'firstLogoGroup',
    'secondLogoGroup',
    'showcaseImage',
])

<section id="logo-pelanggan" class="overflow-hidden rounded-bl-3xl rounded-br-3xl bg-white py-16 md:py-24">
    <div class="mx-auto max-w-6xl px-6 lg:px-0">
        <div class="grid grid-cols-1 items-start gap-12 lg:grid-cols-2 lg:gap-20">
            <div class="order-2 lg:order-1" data-aos="fade-right">
                <div class="mb-2 flex items-center gap-2">
                    <span class="text-[10px] text-orange-600">■</span>
                    <span class="text-xs font-bold uppercase tracking-[0.3em] text-gray-900">Dipercaya Pelanggan</span>
                </div>
                <p class="mb-8 max-w-md text-2xl leading-relaxed text-gray-800">
                    Kami bangga telah menjadi mitra strategis bagi berbagai pelaku industri.
                </p>

                @if ($logoItems->isEmpty())
                    <div class="rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-6 text-sm text-slate-500">
                        Logo mitra belum tersedia.
                    </div>
                @else
                    <div class="space-y-2">
                        <div class="logo-marquee">
                            <div class="logo-marquee-track">
                                <div class="logo-marquee-group">
                                    @foreach ($firstLogoGroup as $logo)
                                        <div class="logo-chip border border-slate-400/70">
                                            <img src="{{ $logo['image_url'] }}" alt="{{ $logo['alt'] }}">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="logo-marquee-group" aria-hidden="true">
                                    @foreach ($firstLogoGroup as $logo)
                                        <div class="logo-chip border border-slate-400/70">
                                            <img src="{{ $logo['image_url'] }}" alt="{{ $logo['alt'] }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="logo-marquee">
                            <div class="logo-marquee-track marquee-reverse">
                                <div class="logo-marquee-group">
                                    @foreach ($secondLogoGroup as $logo)
                                        <div class="logo-chip border border-slate-400/70">
                                            <img src="{{ $logo['image_url'] }}" alt="{{ $logo['alt'] }}">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="logo-marquee-group" aria-hidden="true">
                                    @foreach ($secondLogoGroup as $logo)
                                        <div class="logo-chip border border-slate-400/70">
                                            <img src="{{ $logo['image_url'] }}" alt="{{ $logo['alt'] }}">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="order-1 lg:order-2" data-aos="fade-left">
                <div class="relative">
                    <div class="relative overflow-hidden rounded-2xl">
                        <img src="{{ $showcaseImage }}" alt="Modern Industrial Facility Showcase"
                            class="h-[400px] w-full object-cover">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
