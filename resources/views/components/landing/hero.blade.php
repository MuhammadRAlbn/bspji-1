<div class="relative flex h-screen w-full flex-col">
    <header class="relative h-full w-full grow overflow-hidden bg-black group">
        <video class="absolute inset-0 h-full w-full object-cover opacity-80" autoplay muted loop playsinline>
            <source src="{{ asset('video/videocrop.webm') }}" type="video/webm">
        </video>
        <div class="absolute inset-0 bg-linear-to-t from-black via-black/20 to-black/10"></div>

        <div class="relative z-20 mx-auto flex h-full w-full max-w-[1430px] flex-col justify-end px-6 pb-28 lg:px-0">
            <div class="max-w-3xl" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="mb-6 text-3xl leading-[1.1] tracking-tight text-white md:text-5xl">
                    Mewujudkan Industri Nasional yang Mandiri dan Berdaya Saing
                </h1>
                <!-- <p class="mb-10 max-w-xl text-lg font-ultra-light leading-relaxed text-white/80 md:text-xl">
                    BSPJI Aceh hadir sebagai mitra strategis untuk meningkatkan daya saing industri melalui
                    standardisasi dan layanan jasa teknis yang terpercaya.
                </p> -->
                <div class="flex flex-wrap gap-4">
                    <a href="#layanan"
                        class="rounded-full border border-white/20 bg-white/10 px-8 py-3 text-md font-semibold text-white backdrop-blur-md transition-all hover:bg-white/20">
                        Jelajahi Layanan Kami
                    </a>
                    <!-- <a href="#app-showcase"
                        class="group flex items-center bg-transparent px-8 py-3 text-sm font-semibold text-white transition-all">
                        Daftar akun SIPINTU
                        <i data-lucide="arrow-right"
                            class="ml-2 h-4 w-4 transition-transform group-hover:translate-x-1"></i>
                    </a> -->
                </div>
            </div>
        </div>
    </header>
</div>
