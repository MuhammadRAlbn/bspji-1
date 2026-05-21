@props([
    'testimonialItems',
])

<section x-data="testimonialsCarousel"
    x-cloak
    @resize.window.debounce.150ms="measure()"
    class="relative isolate mb-8 mt-12 overflow-hidden bg-[#f5f8fc] py-10 sm:py-12 md:mb-10 md:mt-16 lg:mt-28 lg:min-h-[560px] lg:py-0"
    aria-labelledby="testimonials-slider-title">
    <div class="mx-auto grid w-full max-w-[1920px] grid-cols-1 lg:min-h-[560px] lg:grid-cols-[49%_51%]">
        <div class="relative h-[300px] overflow-hidden sm:h-[380px] lg:h-auto">
            <img src="{{ asset('images/udara1.jpeg') }}"
                alt="Petugas BSPJI Banda Aceh melakukan pemantauan alat pengujian udara"
                class="h-full w-full object-cover object-center">
            <div class="absolute inset-0 bg-linear-to-br from-slate-950/70 via-slate-950/25 to-white/5"></div>
            <div class="absolute left-5 right-5 top-6 z-10 flex items-start justify-between gap-4 text-white sm:left-8 sm:right-8 sm:top-8 lg:left-10 lg:right-auto lg:top-10 lg:flex-col lg:justify-start lg:gap-5">
                <h2 id="testimonials-slider-title" class="shrink-0 text-2xl font-semibold leading-[1.05] tracking-normal md:text-[30px] lg:whitespace-nowrap lg:text-[44px]">
                    <span class="block lg:inline">Testimoni</span>
                    <span class="block lg:inline">Pelanggan</span>
                </h2>
                <div class="flex items-center gap-2 sm:gap-3">
                    <button type="button"
                        @click="previous()"
                        :disabled="activeIndex === 0"
                        class="inline-flex h-12 w-12 items-center justify-center rounded-lg border border-[#9ba9bf] bg-white/95 text-[#7b8798] shadow-[0_8px_18px_rgba(15,23,42,0.18)] transition enabled:hover:border-[#1839a8] enabled:hover:text-[#1839a8] focus:outline-none disabled:opacity-60 sm:h-14 sm:w-14 lg:h-12 lg:w-12"
                        aria-label="Testimoni sebelumnya">
                        <svg class="h-7 w-7 sm:h-8 sm:w-8 lg:h-7 lg:w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M14.5 18L8.5 12L14.5 6" stroke="currentColor" stroke-width="2.7" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>

                    <button type="button"
                        @click="next()"
                        :disabled="activeIndex >= maxIndex()"
                        class="inline-flex h-12 w-12 items-center justify-center rounded-lg border border-[#9ba9bf] bg-white/95 text-[#7b8798] shadow-[0_8px_18px_rgba(15,23,42,0.18)] transition enabled:hover:border-[#1839a8] enabled:hover:text-[#1839a8] focus:outline-none disabled:opacity-60 sm:h-14 sm:w-14 lg:h-12 lg:w-12"
                        aria-label="Testimoni berikutnya">
                        <svg class="h-7 w-7 sm:h-8 sm:w-8 lg:h-7 lg:w-7" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M9.5 6L15.5 12L9.5 18" stroke="currentColor" stroke-width="2.7" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="relative flex flex-col justify-center px-5 pb-10 pt-8 sm:px-8 lg:px-0 lg:pb-0 lg:pt-0">
            <div class="pointer-events-none absolute inset-y-0 left-0 hidden w-24 bg-linear-to-r from-[#f5f8fc]/0 to-[#f5f8fc] lg:block"></div>

            <div class="testimonials-carousel relative z-10 -mt-24 overflow-visible pl-0 pr-0 sm:-mt-28 lg:mt-0 lg:-translate-x-[19%] lg:pl-0"
                aria-live="polite">
                <div x-ref="track"
                    class="flex will-change-transform"
                    :class="transitionEnabled ? 'transition-transform duration-700 ease-[cubic-bezier(0.22,1,0.36,1)]' : ''"
                    :style="`gap: var(--testimonial-card-gap); transform: translate3d(-${activeIndex * cardStep}px, 0, 0);`">
                    @forelse ($testimonialItems as $testimoni)
                        <article
                            @if ($loop->first) x-ref="card" @endif
                            class="group relative flex h-[380px] shrink-0 flex-col justify-between rounded-md border p-8 shadow-[0_14px_26px_rgba(15,23,42,0.18)] transition-[background-color,color,opacity,box-shadow,border-color] duration-500 sm:h-[420px] sm:p-10 lg:h-[450px] lg:p-12"
                            style="width: var(--testimonial-card-width);"
                            :class="cardTone({{ $loop->index }})"
                            :aria-hidden="cardPosition({{ $loop->index }}) > 2 || cardPosition({{ $loop->index }}) < 0">
                            <div class="flex h-full min-h-0 flex-col">
                                <p class="no-scrollbar min-h-0 overflow-y-auto text-[14px] font-normal italic leading-relaxed tracking-normal sm:text-[15px]"
                                    :class="cardPosition({{ $loop->index }}) === 0 ? 'text-white' : (cardPosition({{ $loop->index }}) === 1 ? 'text-gray-700' : 'text-[#939393]')">
                                    &ldquo;{{ $testimoni['message'] }}&rdquo;
                                </p>

                                <div class="mt-auto flex items-center gap-5 pt-8">
                                    @if ($testimoni['image_url'])
                                        <img src="{{ $testimoni['image_url'] }}" alt="{{ $testimoni['name'] }}"
                                            class="h-14 w-14 shrink-0 rounded-full border-2 object-cover shadow-sm sm:h-16 sm:w-16"
                                            :class="cardPosition({{ $loop->index }}) === 0 ? 'border-white/20' : 'border-gray-100'">
                                    @else
                                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full border-2 text-lg font-bold shadow-sm sm:h-16 sm:w-16"
                                            :class="cardPosition({{ $loop->index }}) === 0 ? 'border-white/20 bg-white/15 text-white' : 'border-gray-100 bg-blue-50 text-[#1839a8]'">
                                            {{ $testimoni['initial'] }}
                                        </div>
                                    @endif                                          
                                    <div class="min-w-0">
                                        <h4 class="text-[17px] font-bold leading-tight"
                                            :class="cardPosition({{ $loop->index }}) === 0 ? 'text-white' : 'text-gray-900'">
                                            {{ $testimoni['name'] }}
                                        </h4>
                                        {{--
                                        <p class="mt-2 text-[13px] font-medium leading-tight"
                                            :class="cardPosition({{ $loop->index }}) === 0 ? 'text-white/70' : 'text-gray-500'">
                                            {{ $testimoni->jabatan }}
                                        </p>
                                        --}}
                                        <p class="mt-1 text-[13px] font-medium leading-tight"
                                            :class="cardPosition({{ $loop->index }}) === 0 ? 'text-white/70' : 'text-gray-500'">
                                            {{ $testimoni['company'] }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @empty
                        <article x-ref="card"
                            class="group relative flex h-[380px] shrink-0 flex-col justify-between rounded-md border p-8 shadow-[0_14px_26px_rgba(15,23,42,0.18)] transition-[background-color,color,opacity,box-shadow,border-color] duration-500 sm:h-[420px] sm:p-10 lg:h-[450px] lg:p-12"
                            style="width: var(--testimonial-card-width);"
                            :class="cardTone(0)"
                            :aria-hidden="false">
                            <div class="flex h-full flex-col">
                                <p class="text-[14px] font-normal italic leading-relaxed tracking-normal text-white sm:text-[15px]">
                                    &ldquo;Testimoni akan muncul setelah data ditambahkan pada admin panel.&rdquo;
                                </p>
                            </div>
                        </article>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
