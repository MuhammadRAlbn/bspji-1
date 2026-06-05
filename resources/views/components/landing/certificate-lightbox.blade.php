<div
    x-data="certificateLightbox()"
    x-show="isCertificateLightboxOpen"
    x-cloak
    x-transition.opacity
    @certificate-open.window="open($event.detail)"
    @keydown.escape.window="close()"
    class="fixed inset-0 z-120"
    :aria-hidden="(!isCertificateLightboxOpen).toString()"
>
    <div class="absolute inset-0 bg-black/90" @click="close()"></div>
    <div class="relative z-10 flex min-h-full items-center justify-center p-2 md:p-6">
        <p class="sr-only" x-text="certificateTitle"></p>
        <button type="button"
            class="absolute right-3 top-3 text-white/90 transition-colors hover:text-white md:right-6 md:top-6"
            @click="close()"
            aria-label="Tutup lightbox">
            <i data-lucide="x" class="h-7 w-7"></i>
        </button>
        <img
            :src="certificateImageSrc"
            :alt="certificateAlt"
            :class="certificateImageClasses()"
        >
    </div>
</div>
