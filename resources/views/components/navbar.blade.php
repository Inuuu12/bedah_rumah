{{-- Navbar Persis Sesuai Screenshot Portal Kabupaten Bogor - Tema Ijo Tosca --}}
<nav id="main-navbar" class="bg-white/95 backdrop-blur-md border-b border-slate-200/80 sticky top-0 z-50 transition-all duration-300 shadow-[0_2px_10px_rgba(0,0,0,0.04)]">
    <div class="w-full max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 xl:px-20">
        <div class="flex items-center justify-between h-20">
            
            {{-- Logo Kabupaten Bogor (Kiri) - Lambang Tegar Beriman --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 group text-decoration-none">
                <img src="{{ asset('images/lambang-kabupaten-bogor.svg') }}" alt="Logo Tegar Beriman Kabupaten Bogor" class="h-12 w-auto drop-shadow-sm transition-transform group-hover:scale-105" width="40" height="50" style="height: 48px; width: auto; object-fit: contain;">
                <div class="flex flex-col text-left">
                    <span class="text-xs sm:text-sm font-extrabold tracking-tight text-slate-900 uppercase leading-none">Bedah Rumah</span>
                    <span class="text-[10px] sm:text-[11px] font-bold text-teal-700 tracking-wider uppercase mt-1">Kabupaten Bogor</span>
                </div>
            </a>

            {{-- Navigasi Menu Desktop: Peta & Dokumentasi --}}
            <div class="hidden md:flex items-center gap-2">
                <a href="{{ request()->routeIs('home') ? '#peta-wilayah' : url('/#peta-wilayah') }}" id="nav-link-peta" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold text-slate-700 hover:text-teal-700 hover:bg-teal-50/80 transition-all duration-200">
                    <span>Peta</span>
                </a>
                <a href="{{ request()->routeIs('home') ? '#dokumentasi' : route('dokumentasi.index') }}" id="nav-link-dokumentasi" class="flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-bold {{ request()->routeIs('dokumentasi.*') ? 'text-teal-700 bg-teal-50' : 'text-slate-700 hover:text-teal-700 hover:bg-teal-50/80' }} transition-all duration-200">
                    <span>Dokumentasi</span>
                </a>
                <div class="h-6 w-px bg-slate-200 mx-1"></div>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 bg-emerald-700 hover:bg-emerald-800 text-white font-bold px-4 py-2 rounded-xl text-xs sm:text-sm shadow-xs hover:shadow-md transition-all active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span>Panel Admin</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 bg-teal-700 hover:bg-teal-800 text-white font-bold px-4 py-2 rounded-xl text-xs sm:text-sm shadow-xs hover:shadow-md transition-all active:scale-95">
                        <span>Login</span>
                    </a>
                @endauth
            </div>

            {{-- Hamburger Mobile --}}
            <div class="flex items-center md:hidden">
                <button type="button" onclick="toggleMobileNav()" class="p-2 rounded-lg text-slate-700 hover:bg-slate-100 focus:outline-none" aria-label="Toggle Menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-nav" class="hidden md:hidden bg-white/95 backdrop-blur-md border-t border-slate-100 px-4 py-3 space-y-1.5 shadow-lg">
        <a href="{{ request()->routeIs('home') ? '#peta-wilayah' : url('/#peta-wilayah') }}" id="mobile-link-peta" onclick="toggleMobileNav()" class="flex items-center gap-2 text-slate-700 hover:text-teal-700 hover:bg-teal-50 font-bold px-3 py-2.5 rounded-lg text-sm transition-colors">
            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
            </svg>
            <span>Peta</span>
        </a>
        <a href="{{ request()->routeIs('home') ? '#dokumentasi' : route('dokumentasi.index') }}" id="mobile-link-dokumentasi" onclick="toggleMobileNav()" class="flex items-center gap-2 {{ request()->routeIs('dokumentasi.*') ? 'text-teal-700 bg-teal-50' : 'text-slate-700 hover:text-teal-700 hover:bg-teal-50' }} font-bold px-3 py-2.5 rounded-lg text-sm transition-colors">
            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>Dokumentasi</span>
        </a>
        <div class="pt-2 border-t border-slate-100 mt-1">
            @auth
                <a href="{{ route('admin.dashboard') }}" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-bold px-4 py-2.5 rounded-xl text-sm flex items-center justify-center gap-2 shadow-xs transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span>Panel Admin</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="w-full bg-teal-700 hover:bg-teal-800 text-white font-bold px-4 py-2.5 rounded-xl text-sm flex items-center justify-center gap-2 shadow-xs transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                    </svg>
                    <span>Login</span>
                </a>
            @endauth
        </div>
    </div>
    <script>
        function toggleMobileNav() {
            const nav = document.getElementById('mobile-nav');
            nav.classList.toggle('hidden');
        }
    </script>
</nav>