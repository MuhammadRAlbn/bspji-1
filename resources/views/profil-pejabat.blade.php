<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pejabat</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased">
    <div class="max-w-6xl mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-extrabold text-blue-900 mb-2">Profil Pejabat</h1>
            <p class="text-lg text-gray-600">Jajaran pejabat di lingkungan instansi kami.</p>
        </div>

        @if($pejabats->isEmpty())
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-500">
                Data profil pejabat belum tersedia.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($pejabats as $pejabat)
                    <div class="bg-white rounded-2xl shadow-sm overflow-hidden transition duration-300 hover:shadow-lg flex flex-col items-center">
                        <div class="pt-8 px-6 flex justify-center w-full">
                            @if($pejabat->foto)
                                <img src="{{ asset('storage/' . $pejabat->foto) }}" alt="{{ $pejabat->nama }}" class="w-40 h-40 rounded-full object-cover border-4 border-blue-100 shadow-md">
                            @else
                                <div class="w-40 h-40 rounded-full bg-gray-200 flex items-center justify-center border-4 border-gray-100 shadow-md">
                                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="p-6 text-center w-full flex-grow">
                            <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $pejabat->nama }}</h2>
                            <p class="text-blue-600 font-medium mb-4">{{ $pejabat->jabatan }}</p>
                            
                            @if($pejabat->detail)
                                <div class="text-gray-600 text-sm prose max-w-none text-left border-t border-gray-100 pt-4 mt-2">
                                    {!! $pejabat->detail !!}
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        
        <div class="mt-12 text-center">
            <a href="{{ url('/') }}" class="text-blue-600 hover:underline"> Kembali ke Beranda </a>
        </div>
    </div>
</body>
</html>
