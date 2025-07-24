<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-[60vh]">
        <div class="max-w-4xl mx-auto px-4">
            <div class="bg-gradient-to-r from-red-600 to-red-400 shadow-xl rounded-2xl p-8 flex flex-col items-center mb-8 relative overflow-hidden">
                <img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Welcome" class="w-24 h-24 mb-4 drop-shadow-lg animate-bounce" style="background:white;border-radius:50%;padding:8px;"/>
                <h3 class="text-2xl font-extrabold mb-2 text-white drop-shadow">Selamat Datang di <span class="text-yellow-200">SmartPED</span></h3>
                <p class="text-white mb-4 text-lg">Anda login sebagai <span class="font-semibold text-yellow-200">{{ Auth::user()->name }}</span>.</p>
                <div class="w-full border-t border-red-200 my-4 opacity-50"></div>
                <p class="text-red-100">Silakan pilih menu di atas untuk mulai menggunakan aplikasi.</p>
                <div class="absolute right-4 bottom-4 opacity-20 text-8xl select-none pointer-events-none">📊</div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center hover:scale-105 transition-transform duration-300 border-t-4 border-red-600">
                    <div class="text-3xl mb-2">📄</div>
                    <div class="text-lg font-bold text-gray-700">Dokumen</div>
                    <div class="text-gray-500 text-sm">123</div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center hover:scale-105 transition-transform duration-300 border-t-4 border-red-600">
                    <div class="text-3xl mb-2">👤</div>
                    <div class="text-lg font-bold text-gray-700">User</div>
                    <div class="text-gray-500 text-sm">5</div>
                </div>
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col items-center hover:scale-105 transition-transform duration-300 border-t-4 border-red-600">
                    <div class="text-3xl mb-2">⚡</div>
                    <div class="text-lg font-bold text-gray-700">Aktivitas</div>
                    <div class="text-gray-500 text-sm">-</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
