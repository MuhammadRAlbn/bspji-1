<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Pelayanan Publik - BSPJI Banda Aceh</title>
    <!-- Google Fonts: Manrope -->
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@300;400;600;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom Smooth Transition */
        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Navbar Glassmorphism */
        .nav-glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Gradient Button */
        .btn-sipintu {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.3);
            transition: all 0.3s ease;
        }

        .btn-sipintu:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
        }

        /* Nav Link Hover */
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background-color: #f97316;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .nav-link:hover {
            color: #f97316;
        }
    </style>
</head>

<body class="bg-white text-slate-800 antialiased font-sans pt-20" x-data="{ 
        mobileMenuOpen: false, 
        activeTab: 'profil',
        lightbox: { open: false, src: '' }
    }">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-[100] nav-glass">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <!-- Left: Logo (Text-based) -->
            <div class="flex items-center gap-2">
                <div
                    class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                    <span class="text-white font-bold text-xl leading-none">B</span>
                </div>
                <div class="hidden sm:block">
                    <span class="block text-lg font-extrabold text-primary leading-tight">BSPJI</span>
                    <span class="block text-[10px] text-slate-500 font-semibold uppercase tracking-wider">Banda
                        Aceh</span>
                </div>
            </div>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ url('/') }}" class="nav-link text-base font-bold text-slate-600">Beranda</a>
                <a href="{{ route('sejarah-singkat.index') }}"
                    class="nav-link text-base font-bold text-slate-600">Profil</a>
                <a href="{{ route('pengujian.index') }}"
                    class="nav-link text-base font-bold text-slate-600">Pelayanan</a>
                <a href="{{ route('informasi-publik.index') }}"
                    class="nav-link text-base font-bold text-slate-600">Informasi Publik</a>
            </div>

            <!-- Right: Action Button -->
            <div class="hidden md:block">
                <a href="#"
                    class="btn-sipintu px-6 py-2.5 rounded-full text-base font-bold text-white inline-flex items-center gap-2">
                    <span>sipintu</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

            <!-- Mobile Menu Toggle -->
            <div class="md:hidden">
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                    class="p-2 text-slate-600 hover:text-brand-orange transition-colors">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        style="display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Menu (Drawer) -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="md:hidden bg-white/95 backdrop-blur-lg border-t border-slate-100 shadow-xl overflow-hidden"
            style="display: none;">
            <div class="px-6 py-6 flex flex-col gap-4">
                <a href="{{ url('/') }}"
                    class="text-base font-bold text-slate-600 py-2 border-b border-slate-50">Beranda</a>
                <a href="{{ route('sejarah-singkat.index') }}"
                    class="text-base font-bold text-slate-600 py-2 border-b border-slate-50">Profil</a>
                <a href="{{ route('pengujian.index') }}"
                    class="text-base font-bold text-slate-600 py-2 border-b border-slate-50">Pelayanan</a>
                <a href="{{ route('informasi-publik.index') }}"
                    class="text-base font-bold text-slate-600 py-2 border-b border-slate-50">Informasi Publik</a>
                <a href="#"
                    class="btn-sipintu mt-4 px-6 py-3 rounded-xl text-center text-base font-bold text-white flex items-center justify-center gap-2">
                    <span>sipintu</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <section class="max-w-6xl mx-auto px-6 pt-6 md:pt-20 pb-20">

        <!-- Header -->
        <div class="mb-6 md:mb-10 p-2 md:p-4 rounded-lg">
            <h1 class="text-4xl md:text-5xl tracking-tight text-primary">
                Unit Pelayanan Publik
            </h1>
        </div>

        <!-- Navigation Tabs (6 Menus) -->
        <div class="flex flex-wrap justify-center mb-16 gap-2 sm:gap-3 bg-white rounded-full p-1.5 sm:p-2">
            @php
                $tabs = [
                    ['id' => 'profil', 'label' => 'Profil UPP'],
                    ['id' => 'maklumat', 'label' => 'Maklumat Pelayanan'],
                    ['id' => 'visi-misi', 'label' => 'Visi & Misi UPP'],
                    ['id' => 'sop-formulir', 'label' => 'Daftar SOP & Formulir'],
                    ['id' => 'sarana', 'label' => 'Sarana & Prasarana'],
                    ['id' => 'sk-spm', 'label' => 'SK SPM Pelayanan'],
                ];
            @endphp
            @foreach($tabs as $tab)
                <button @click="activeTab = '{{ $tab['id'] }}'"
                    :class="activeTab === '{{ $tab['id'] }}' ? 'bg-brand-orange text-white' : 'bg-slate-100 text-slate-700'"
                    class="px-3 sm:px-3 py-2 sm:py-3 rounded-full text-xs sm:text-sm md:text-[16px] font-semibold whitespace-nowrap transition-all duration-300 grow">
                    {{ $tab['label'] }}
                </button>
            @endforeach
        </div>

        <!-- Content Area -->
        <div class="relative rounded-[2.5rem] px-3">

            <!-- Tab 1: Profil UPP -->
            <div x-show="activeTab === 'profil'" class="tab-content" :class="{ 'active': activeTab === 'profil' }">
                <div class="mb-2">
                    <!-- Waktu Layanan Section -->
                    <div class="grid md:grid-cols-2 gap-12 items-center mb-16">
                        <!-- Kolom Kiri: Gambar -->
                        <div class="relative group">
                            @if($profil && $profil->foto_petugas_path)
                                <div class="absolute -inset-4 bg-brand-orange/30 rounded-[2.5rem] transform -rotate-2">
                                </div>
                                <img src="{{ asset('storage/' . $profil->foto_petugas_path) }}" alt="Petugas Layanan"
                                    class="relative rounded-[2rem] shadow-xl w-full h-80 object-cover border-4 border-white cursor-pointer hover:scale-[1.02] transition-transform duration-500"
                                    @click="lightbox.open = true; lightbox.src = '{{ asset('storage/' . $profil->foto_petugas_path) }}'">
                            @else
                                <div
                                    class="relative bg-slate-100 rounded-[2rem] h-80 flex items-center justify-center border-2 border-dashed border-slate-200">
                                    <p class="text-slate-400 italic">Foto petugas belum tersedia</p>
                                </div>
                            @endif
                        </div>

                        <!-- Kolom Kanan: Info Waktu -->
                        <div>
                            <h3 class="text-xl font-bold mb-6 text-slate-800 flex items-center gap-2">
                                <svg class="w-6 h-6 text-brand-orange" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Waktu Layanan
                            </h3>
                            <div class="space-y-4">
                                @if($profil && $profil->waktu_pelayanan)
                                    @foreach($profil->waktu_pelayanan as $jadwal)
                                        <div
                                            class="bg-white py-4 px-6 rounded-2xl shadow-sm border border-orange-300 border-l-4 border-l-brand-orange">
                                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">
                                                {{ $jadwal['hari'] }}</p>
                                            <p class="text-slate-800 font-semibold">{{ $jadwal['waktu'] }}</p>
                                        </div>
                                    @endforeach
                                @else
                                    <p class="text-slate-400 italic font-medium">Jadwal belum tersedia</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Tupoksi & Image Section -->
                    <div class="">
                        <div class="space-y-6">
                            <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                                <svg class="w-6 h-6 text-brand-orange" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                                Tugas & Fungsi
                            </h3>
                            <div
                                class="prose prose-slate max-w-none text-slate-600 leading-relaxed space-y-4 text-justify text-lg">
                                @if($profil && $profil->tupoksi)
                                    {!! $profil->tupoksi !!}
                                @else
                                    <p class="text-slate-400 italic">Data Tugas & Fungsi belum tersedia.</p>
                                @endif
                            </div>
                        </div>

                        @if($profil && $profil->moto_pelayanan_path)
                            <div class="mt-12">
                                <img src="{{ asset('storage/' . $profil->moto_pelayanan_path) }}" alt="Moto Pelayanan"
                                    class="w-full h-auto rounded-[2rem] shadow-lg border border-slate-100 bg-slate-200 cursor-pointer hover:opacity-95 transition-opacity"
                                    @click="lightbox.open = true; lightbox.src = '{{ asset('storage/' . $profil->moto_pelayanan_path) }}'">
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tab 2: Maklumat -->
            <div x-show="activeTab === 'maklumat'" class="tab-content" :class="{ 'active': activeTab === 'maklumat' }">
                <div class="flex justify-center">
                    @if($maklumat && $maklumat->path)
                        <img src="{{ asset('storage/' . $maklumat->path) }}"
                            class="object-cover w-full sm:w-[80%] rounded-2xl cursor-pointer hover:scale-[1.01] transition-transform mx-auto shadow-lg"
                            @click="lightbox.open = true; lightbox.src = '{{ asset('storage/' . $maklumat->path) }}'">
                    @else
                        <div class="py-20 text-center">
                            <p class="text-slate-400 italic font-medium text-lg">Maklumat pelayanan belum tersedia</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tab 3: Visi & Misi -->
            <div x-show="activeTab === 'visi-misi'" class="tab-content"
                :class="{ 'active': activeTab === 'visi-misi' }">
                <div class="max-w-5xl space-y-10">

                    <!-- Visi Card -->
                    <div
                        class="relative overflow-hidden bg-white p-8 md:p-12 rounded-[2.5rem] shadow-xl border border-slate-400">
                        <div class="absolute top-0 right-0 w-32 h-32 bg-brand-orange/5 rounded-full -mr-16 -mt-16">
                        </div>
                        <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                            <div class="bg-brand-orange/10 p-5 rounded-3xl">
                                <svg class="w-10 h-10 text-brand-orange" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-center md:text-left">
                                <h3 class="text-xs font-extrabold uppercase tracking-[0.2em] text-brand-orange mb-3">
                                    Visi</h3>
                                <div class="text-2xl md:text-3xl font-bold text-primary leading-tight">
                                    @if($visiMisi && $visiMisi->visi)
                                        {!! $visiMisi->visi !!}
                                    @else
                                        <p class="text-slate-400 italic">Visi belum tersedia</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-10">
                        <!-- Misi Card -->
                        <div
                            class="relative overflow-hidden bg-white p-8 rounded-[2.5rem] border border-slate-400 shadow-xl">
                            <div
                                class="absolute bottom-0 left-0 w-24 h-24 bg-brand-orange/10 rounded-full -ml-12 -mb-12">
                            </div>
                            <div class="relative z-10">
                                <h3 class="text-xl font-extrabold text-primary mb-8 flex items-center gap-3">
                                    <span
                                        class="w-8 h-8 bg-primary text-white rounded-full flex items-center justify-center text-sm">M</span>
                                    Misi Kami
                                </h3>
                                <div class="misi-list text-slate-600 font-medium">
                                    @if($visiMisi && $visiMisi->misi)
                                        {!! $visiMisi->misi !!}
                                    @else
                                        <p class="text-slate-400 italic">Misi belum tersedia</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Motto Card -->
                        <div
                            class="relative overflow-hidden bg-white p-8 rounded-[2.5rem] border border-slate-400 shadow-xl flex flex-col justify-center items-center text-center">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-brand-orange/10 rounded-full -mr-12 -mt-12">
                            </div>
                            <div class="absolute bottom-0 left-0 w-20 h-20 bg-slate-100/50 rounded-full -ml-10 -mb-10">
                            </div>
                            <div class="relative z-10">
                                <div class="mb-6 opacity-20">
                                    <svg class="w-12 h-12 text-brand-orange" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H16.017C15.4647 8 15.017 8.44772 15.017 9V12C15.017 12.5523 14.5693 13 14.017 13H12.017C11.4647 13 11.017 12.5523 11.017 12V9C11.017 7.34315 12.3602 6 14.017 6H19.017C20.6739 6 22.017 7.34315 22.017 9V15C22.017 16.6569 20.6739 18 19.017 18H17.017L14.017 21ZM5.017 21L5.017 18C5.017 16.8954 5.91243 16 7.017 16H10.017C10.5693 16 11.017 15.5523 11.017 15V9C11.017 8.44772 10.5693 8 10.017 8H7.017C6.46472 8 6.017 8.44772 6.017 9V12C6.017 12.5523 5.56928 13 5.017 13H3.017C2.46472 13 2.017 12.5523 2.017 12V9C2.017 7.34315 3.36015 6 5.017 6H10.017C11.6739 6 13.017 7.34315 13.017 9V15C13.017 16.6569 11.6739 18 10.017 18H8.017L5.017 21Z">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-xs font-extrabold uppercase tracking-[0.2em] text-slate-400 mb-4">Motto
                                    Kami</h3>
                                <p class="text-xl font-bold text-slate-800 italic leading-relaxed">
                                    @if($visiMisi && $visiMisi->moto)
                                        "{{ $visiMisi->moto }}"
                                    @else
                                        "Memberikan pelayanan dengan cepat, tepat dan akurat yang berorientasi pada kepuasan
                                        pelanggan."
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Tab 4: SOP & Formulir -->
            <div x-show="activeTab === 'sop-formulir'" class="tab-content"
                :class="{ 'active': activeTab === 'sop-formulir' }">
                {{-- SOP Cards --}}
                @if(isset($sopFormulir['sop']) && count($sopFormulir['sop']) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 mb-16">
                        @foreach($sopFormulir['sop'] as $sop)
                            <div
                                class="flex flex-col group h-full bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-xl transition-all overflow-hidden">
                                <div class="aspect-[16/10] bg-slate-200 overflow-hidden cursor-pointer"
                                    @click="lightbox.open = true; lightbox.src = '{{ asset('storage/' . $sop->path) }}'">
                                    <img src="{{ asset('storage/' . $sop->path) }}" alt="{{ $sop->name }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                                <div class="p-6 flex flex-col flex-grow">
                                    <h3 class="text-2xl font-bold text-slate-800 mb-4 leading-tight">{{ $sop->name }}</h3>
                                    <a href="{{ asset('storage/' . $sop->path) }}" target="_blank"
                                        class="mt-auto inline-flex items-center justify-between w-fit px-6 py-2.5 bg-white border border-slate-200 rounded-full text-sm font-semibold text-slate-600 hover:bg-white hover:border-brand-orange hover:text-brand-orange transition-all gap-2">
                                        Selengkapnya
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                {{-- Formulir List --}}
                @if(isset($sopFormulir['formulir']) && count($sopFormulir['formulir']) > 0)
                    <div class="space-y-4">
                        <h3 class="text-2xl font-bold text-slate-800 mb-8 flex items-center gap-3">
                            <span
                                class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-sm">📝</span>
                            Formulir Layanan
                        </h3>
                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach($sopFormulir['formulir'] as $form)
                                <a href="{{ asset('storage/' . $form->path) }}" target="_blank"
                                    class="flex items-center justify-between p-6 bg-slate-50 border border-slate-100 rounded-2xl group hover:bg-white hover:shadow-lg hover:border-blue-200 transition-all">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-blue-500">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <span class="font-bold text-slate-700">{{ $form->name }}</span>
                                    </div>
                                    <svg class="w-5 h-5 text-slate-300 group-hover:text-blue-500 group-hover:translate-x-1 transition-all"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Tab 5: Sarana & Prasarana -->
            <div x-show="activeTab === 'sarana'" class="tab-content" :class="{ 'active': activeTab === 'sarana' }">
                @if($saranaPrasarana && $saranaPrasarana->pdf)
                    <div class="bg-white p-4 rounded-[2.5rem] shadow-xl border border-slate-100">
                        <iframe src="{{ asset('storage/' . $saranaPrasarana->pdf) }}"
                            class="w-full h-[800px] rounded-2xl border-none"></iframe>
                    </div>
                @else
                    <div class="bg-slate-50 p-20 rounded-[2.5rem] text-center border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 italic text-lg font-medium">Data Sarana & Prasarana belum diunggah.</p>
                    </div>
                @endif
            </div>

            <!-- Tab 6: SK SPM -->
            <div x-show="activeTab === 'sk-spm'" class="tab-content" :class="{ 'active': activeTab === 'sk-spm' }">
                @if($skSpm && $skSpm->pdf)
                    <div class="bg-white p-4 rounded-[2.5rem] shadow-xl border border-slate-100">
                        <iframe src="{{ asset('storage/' . $skSpm->pdf) }}"
                            class="w-full h-[800px] rounded-2xl border-none"></iframe>
                    </div>
                @else
                    <div class="bg-slate-50 p-20 rounded-[2.5rem] text-center border-2 border-dashed border-slate-200">
                        <p class="text-slate-400 italic text-lg font-medium">Data SK Standar Pelayanan Minimal belum
                            diunggah.</p>
                    </div>
                @endif
            </div>

        </div>

        <!-- Footer Action -->
        <div class="mt-24 text-center">
            <a href="{{ url('/') }}"
                class="inline-flex items-center gap-3 px-8 py-4 bg-white border border-slate-200 text-slate-600 font-bold rounded-2xl shadow-sm hover:shadow-xl hover:text-brand-orange hover:border-brand-orange/20 transition-all duration-300 group">
                <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </section>

    <!-- Lightbox Modal -->
    <div x-show="lightbox.open" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="fixed inset-0 z-[200] bg-black/95 flex items-center justify-center p-6 cursor-zoom-out"
        @click="lightbox.open = false" @keydown.escape.window="lightbox.open = false" style="display: none;">

        <button class="absolute top-8 right-8 text-white/50 hover:text-white transition-colors"
            @click="lightbox.open = false">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        <img :src="lightbox.src" class="max-w-full max-h-[90vh] rounded-2xl shadow-2xl" @click.stop>
    </div>

</body>

</html>