<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BSPJI - Portal Profil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased selection:bg-blue-100 selection:text-blue-900">

    <div class="relative overflow-hidden min-h-screen flex flex-col">
        <!-- Background Decorations -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full -z-10 overflow-hidden pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] rounded-full bg-blue-100/50 blur-3xl"></div>
            <div class="absolute top-[20%] -right-[5%] w-[30%] h-[30%] rounded-full bg-indigo-100/40 blur-3xl"></div>
        </div>

        <!-- Header/Navbar -->
        <header class="w-full max-w-7xl mx-auto px-6 py-8 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                    <span class="text-white font-bold text-xl leading-none">B</span>
                </div>
                <span class="font-bold text-2xl tracking-tight text-slate-800">BSPJI</span>
            </div>
            <a href="{{ url('/admin') }}" class="group flex items-center gap-2 px-5 py-2.5 bg-white border border-slate-200 rounded-full text-sm font-semibold text-slate-700 hover:border-blue-600 hover:text-blue-600 transition-all duration-300 shadow-sm">
                <span>Login Admin</span>
                <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                </svg>
            </a>
        </header>

        <!-- Main Content -->
        <main class="flex-grow flex flex-col items-center justify-center px-6 py-12 relative">
            <div class="max-w-4xl text-center mb-16">
                <h1 class="text-5xl md:text-6xl font-bold text-slate-900 mb-6 leading-tight">
                    Portal Informasi Pelayanan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Standardisasi & Jasa Industri</span>
                </h1>
                <p class="text-xl text-slate-600 max-w-2xl mx-auto leading-relaxed">
                    Akses informasi lengkap mengenai visi, misi, tugas, fungsi, dan sejarah instansi kami melalui menu navigasi di bawah ini.
                </p>
            </div>

            <!-- Navigation Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full max-w-5xl">
                <!-- Sejarah Singkat -->
                <a href="{{ route('sejarah-singkat.index') }}" class="group relative bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:shadow-blue-500/5 hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 -mr-8 -mt-8 bg-blue-50 rounded-full scale-0 group-hover:scale-100 transition-transform duration-500 origin-top-right"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">Sejarah Singkat</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">Mengenal lebih dekat perjalanan dan latar belakang berdirinya instansi kami.</p>
                        <span class="inline-flex items-center text-blue-600 font-semibold text-sm group-hover:gap-2 transition-all">
                            Lihat Selanjutnya <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </span>
                    </div>
                </a>

                <!-- Visi dan Misi -->
                <a href="{{ route('visi-misi.index') }}" class="group relative bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:shadow-blue-500/5 hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 -mr-8 -mt-8 bg-indigo-50 rounded-full scale-0 group-hover:scale-100 transition-transform duration-500 origin-top-right"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">Visi dan Misi</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">Cita-cita dan landasan operasional kami dalam memberikan pelayanan terbaik.</p>
                        <span class="inline-flex items-center text-blue-600 font-semibold text-sm group-hover:gap-2 transition-all">
                            Lihat Selanjutnya <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </span>
                    </div>
                </a>

                <!-- Tugas dan Fungsi -->
                <a href="{{ route('tugas-fungsi.index') }}" class="group relative bg-white p-8 rounded-3xl border border-slate-200 shadow-sm hover:shadow-xl hover:shadow-blue-500/5 hover:-translate-y-1 transition-all duration-300 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 -mr-8 -mt-8 bg-emerald-50 rounded-full scale-0 group-hover:scale-100 transition-transform duration-500 origin-top-right"></div>
                    <div class="relative">
                        <div class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-slate-800 mb-2">Tugas dan Fungsi</h3>
                        <p class="text-slate-500 text-sm leading-relaxed mb-4">Uraian tugas pokok dan fungsi strategis kami dalam standardisasi industri.</p>
                        <span class="inline-flex items-center text-blue-600 font-semibold text-sm group-hover:gap-2 transition-all">
                            Lihat Selanjutnya <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                        </span>
                    </div>
                </a>
            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full max-w-7xl mx-auto px-6 py-10 border-t border-slate-200">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-slate-500 text-sm">
                    &copy; {{ date('Y') }} BSPJI. Seluruh hak cipta dilindungi.
                </div>
                <div class="flex gap-8">
                    <a href="#" class="text-slate-400 hover:text-blue-600 transition-colors text-sm">Hubungi Kami</a>
                    <a href="#" class="text-slate-400 hover:text-blue-600 transition-colors text-sm">Kebijakan Privasi</a>
                    <a href="#" class="text-slate-400 hover:text-blue-600 transition-colors text-sm">Lokasi Kami</a>
                </div>
            </div>
        </footer>
    </div>

</body>
</html>