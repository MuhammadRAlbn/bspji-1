<nav class="fixed top-0 left-0 right-0 z-[100] nav-glass">
    <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
        <!-- Left: Logo (Text-based) -->
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                <span class="text-white font-bold text-xl leading-none">B</span>
            </div>
            <div class="hidden sm:block">
                <span class="block text-lg font-extrabold text-primary leading-tight">BSPJI</span>
                <span class="block text-xs text-slate-500 font-semibold uppercase tracking-wider">Banda Aceh</span>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-8">
            <a href="{{ url('/') }}" class="nav-link text-base font-bold text-slate-600">Beranda</a>
            <a href="{{ route('sejarah-singkat.index') }}" class="nav-link text-base font-bold text-slate-600">Profil</a>
            <a href="{{ route('pengujian.index') }}" class="nav-link text-base font-bold text-slate-600">Pelayanan</a>
            <a href="{{ route('informasi-publik.index') }}" class="nav-link text-base font-bold text-slate-600">Informasi Publik</a>
        </div>

        <!-- Right: Action Button -->
        <div class="hidden md:block">
            <a href="#" class="btn-sipintu px-6 py-2.5 rounded-full text-base font-bold text-white inline-flex items-center gap-2">
                <span>sipintu</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>

        <!-- Mobile Menu Toggle -->
        <div class="md:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-slate-600 hover:text-brand-orange transition-colors">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
                <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu (Drawer) -->
    <div x-show="mobileMenuOpen" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-4" 
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150" 
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-4"
        class="md:hidden bg-white/95 backdrop-blur-lg border-t border-slate-100 shadow-xl overflow-hidden" 
        style="display: none;">
        <div class="px-6 py-6 flex flex-col gap-4">
            <a href="{{ url('/') }}" class="text-base font-bold text-slate-600 py-2 border-b border-slate-50">Beranda</a>
            <a href="{{ route('sejarah-singkat.index') }}" class="text-base font-bold text-slate-600 py-2 border-b border-slate-50">Profil</a>
            <a href="{{ route('pengujian.index') }}" class="text-base font-bold text-slate-600 py-2 border-b border-slate-50">Pelayanan</a>
            <a href="{{ route('informasi-publik.index') }}" class="text-base font-bold text-slate-600 py-2 border-b border-slate-50">Informasi Publik</a>
            <a href="#" class="btn-sipintu mt-4 px-6 py-3 rounded-xl text-center text-base font-bold text-white flex items-center justify-center gap-2">
                <span>sipintu</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </div>
    </div>
</nav>
