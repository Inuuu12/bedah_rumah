{{-- Topbar Utilitas Khas Portal Resmi Kemnaker RI --}}
<div class="bg-[#071c3d] text-white/90 text-xs py-2 border-b border-white/10 hidden md:block">
    <div class="w-full max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 flex flex-col md:flex-row items-center justify-between gap-3">
        {{-- Sisi Kiri: Hotline, Jam Layanan, & Ticker Info --}}
        <div class="flex items-center gap-6 divide-x divide-white/20">
            <div class="flex items-center gap-4">
                <a href="tel:1500630" class="flex items-center gap-2 hover:text-[#f59e0b] transition-colors">
                    <svg class="w-3.5 h-3.5 text-[#f59e0b]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                    <span>Call Center: <strong>1500-630</strong></span>
                </a>
                <span class="text-white/60">|</span>
                <span class="flex items-center gap-1.5 text-white/80">
                    <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Layanan: Senin - Jumat (08.00 - 16.00 WIB)</span>
                </span>
            </div>

            {{-- Running / Ticker Info Singkat --}}
            <div class="pl-6 flex items-center gap-2">
                <span class="bg-[#f59e0b] text-[#071c3d] font-bold text-[10px] uppercase px-1.5 py-0.5 rounded tracking-wide">PENGUMUMAN</span>
                <span class="text-white/90 truncate max-w-sm lg:max-w-md">
                    Pendaftaran Verifikasi RTLH Bantuan Stimulan TA 2026 Dibuka.
                </span>
            </div>
        </div>

        {{-- Sisi Kanan: Tanggal, Aksesibilitas, Bahasa & Medsos --}}
        <div class="flex items-center gap-5">
            {{-- Pilihan Bahasa --}}
            <div class="flex items-center gap-1.5 text-[11px] font-medium">
                <span class="text-[#f59e0b] font-bold">ID</span>
                <span class="text-white/40">/</span>
                <a href="#lang-en" class="text-white/70 hover:text-white transition-colors">EN</a>
            </div>

            {{-- Aksesibilitas Font --}}
            <div class="hidden lg:flex items-center gap-1 bg-white/10 px-2 py-0.5 rounded text-[11px]">
                <span class="text-white/60 text-[10px] mr-1">Teks:</span>
                <button onclick="changeFontSize(-1)" title="Perkecil Font" class="hover:text-[#f59e0b] px-1 font-semibold">A-</button>
                <button onclick="changeFontSize(0)" title="Font Normal" class="hover:text-[#f59e0b] px-1 font-semibold">A</button>
                <button onclick="changeFontSize(1)" title="Perbesar Font" class="hover:text-[#f59e0b] px-1 font-semibold">A+</button>
            </div>

            {{-- Media Sosial Kemnaker RI --}}
            <div class="flex items-center gap-2.5 pl-3 border-l border-white/20">
                <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" title="Instagram" class="hover:text-[#f59e0b] transition-colors">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                </a>
                <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" title="YouTube" class="hover:text-[#f59e0b] transition-colors">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </a>
                <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" title="Facebook" class="hover:text-[#f59e0b] transition-colors">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M9 8H6v4h3v12h5V12h3.642L18 8h-4V6.333C14 5.374 14.5 5 15.5 5H18V0h-3.808C10.595 0 9 1.583 9 4.615V8z"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>
