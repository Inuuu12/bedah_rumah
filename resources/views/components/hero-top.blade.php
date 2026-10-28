{{-- Hero Banner Bagian Depan Atas - Tema Ijo Tosca Solid --}}
<section class="relative bg-teal-950 text-white pt-16 overflow-hidden text-center -mt-px" style="padding-bottom: 10rem;">

    {{-- Background Image dengan Overlay Bernuansa Teal (Agak Lebih Gelap) --}}
    <div class="absolute inset-0 z-0 overflow-hidden" style="background-color: #022019;">
        <img src="/images/hero-bg.png" 
             alt="Pembongkaran Bangunan di Bawah Langit Cerah" 
             class="w-full h-full object-cover object-center"
             style="filter: brightness(0.50) contrast(1.10);">
        <div class="absolute inset-0" 
             style="background-color: rgba(2, 22, 17, 0.75);"></div>
    </div>

    {{-- Konten Utama Hero --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 relative z-10 space-y-5">
        
        {{-- Tagline / Label Kecil di Atas --}}
        <p class="text-xs sm:text-[13px] font-bold tracking-widest uppercase text-teal-200 drop-shadow-md">
            PORTAL RESMI PELAYANAN BEDAH RUMAH KABUPATEN BOGOR
        </p>

        {{-- Judul Besar --}}
        <h1 class="text-3xl sm:text-4xl md:text-[42px] font-extrabold text-white tracking-tight leading-tight drop-shadow-md">
            Selamat Datang di Portal Bedah Rumah
        </h1>

        {{-- Paragraf Penjelas --}}
        <p class="max-w-3xl mx-auto text-xs sm:text-sm md:text-[14.5px] leading-relaxed text-teal-100 font-normal drop-shadow">
            Portal resmi satu pintu pengajuan permohonan bantuan Rumah Tidak Layak Huni (RTLH), pendataan mandiri, dan
            verifikasi faktual ke seluruh wilayah Pemerintah Kabupaten Bogor. Terintegrasi secara
            cepat, transparan, dan terhubung langsung dengan instansi tujuan.
        </p>

    </div>
</section>

{{-- 2 Kotak Rekapitulasi Program Bedah Rumah: Kab. Bogor (RTLH) & Pusat Kemenpera (BSPS) --}}
<section class="w-full max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 relative z-20 pb-16 page-sheet-reveal" id="monitoring-program" style="margin-top: -125px;">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
        
        {{-- 1. KOTAK KIRI: PEMKAB BOGOR - REHABILITASI RUMAH TIDAK LAYAK HUNI (RTLH) TAHUN 2026 --}}
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-5 sm:p-7 flex flex-col justify-between hover:shadow-2xl transition-all duration-300">
            <div>
                {{-- Header Kartu Kab. Bogor --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-teal-50 border border-teal-100/80 flex items-center justify-center p-1.5 shrink-0 shadow-xs">
                            <img src="/images/lambang-kabupaten-bogor.svg" alt="Logo Kabupaten Bogor" class="h-9 w-auto drop-shadow-sm object-contain">
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-extrabold uppercase tracking-wider text-teal-700">Pemerintah Kab. Bogor</span>
                            </div>
                            <h2 class="text-base sm:text-lg font-black text-slate-900 leading-tight mt-0.5">
                                Rehabilitasi Rumah Tidak Layak Huni (RTLH)
                            </h2>
                        </div>
                    </div>
                    <div class="hidden sm:block text-right">
                        <span class="inline-block text-[11px] font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full border border-slate-200/60">
                            2026
                        </span>
                    </div>
                </div>

                {{-- Sub-deskripsi Ringkas --}}
                <p class="text-xs text-slate-500 mt-3 mb-5 leading-relaxed">
                    Data pemantauan program bedah rumah perbaikan fisik RTLH melalui Anggaran Pendapatan &amp; Belanja Daerah (APBD) Kabupaten Bogor.
                </p>

                {{-- 3 Metrik / Statistik Simple: Hanya Nama dan Unit --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    
                    {{-- 1. Total Penerima --}}
                    <div class="bg-slate-50/80 hover:bg-teal-50/40 rounded-xl p-4 sm:p-5 border border-slate-100 transition-colors">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-2">
                             Total Penerima
                        </span>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-xl sm:text-2xl font-black tracking-tight">{{ number_format($totalRtlh ?? 1502, 0, ',', '.') }}</span>
                            <span class="text-xs font-semibold text-slate-500">Unit</span>
                        </div>
                    </div>

                    {{-- 2. Dalam Proses --}}
                    <div class="bg-slate-50/80 hover:bg-amber-50/40 rounded-xl p-4 sm:p-5 border border-slate-100 transition-colors">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-2">
                             Dalam Proses
                        </span>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-xl sm:text-2xl font-black tracking-tight">{{ number_format($totalRtlhPersiapan ?? 1502, 0, ',', '.') }}</span>
                            <span class="text-xs font-semibold text-slate-500">Unit</span>
                        </div>
                    </div>

                    {{-- 3. Selesai --}}
                    <div class="bg-slate-50/80 hover:bg-emerald-50/40 rounded-xl p-4 sm:p-5 border border-slate-100 transition-colors">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-2">
                             Selesai
                        </span>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-xl sm:text-2xl font-black tracking-tight">0</span>
                            <span class="text-xs font-semibold text-slate-500">Unit</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- 2. KOTAK KANAN: PEMERINTAH PUSAT (KEMENPERA) - BANTUAN SOSIAL PERUMAHAN SWADAYA (BSPS) TAHUN 2026 --}}
        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-5 sm:p-7 flex flex-col justify-between hover:shadow-2xl transition-all duration-300">
            <div>
                {{-- Header Kartu Pusat / Kemenpera --}}
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-100">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-xl bg-sky-50 border border-sky-100/80 flex items-center justify-center p-1.5 shrink-0 shadow-xs">
                            <img src="/images/logo-kemenpera.svg" alt="Logo Kemenpera" class="h-9 w-auto drop-shadow-sm object-contain">
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] font-extrabold uppercase tracking-wider text-sky-800">Pemerintah Pusat - Kemenpera</span>
                            </div>
                            <h2 class="text-base sm:text-lg font-black text-slate-900 leading-tight mt-0.5">
                                Bantuan Sosial Perumahan Swadaya (BSPS)
                            </h2>
                        </div>
                    </div>
                    <div class="hidden sm:block text-right">
                        <span class="inline-block text-[11px] font-semibold text-slate-500 bg-slate-100 px-3 py-1 rounded-full border border-slate-200/60">
                            2026
                        </span>
                    </div>
                </div>

                {{-- Sub-deskripsi Ringkas --}}
                <p class="text-xs text-slate-500 mt-3 mb-5 leading-relaxed">
                    Data penyaluran Bantuan Stimulan / Sosial Perumahan Swadaya (BSPS) Kementerian Perumahan dan Kawasan Permukiman RI.
                </p>

                {{-- 3 Metrik / Statistik Simple: Hanya Nama dan Unit --}}
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    
                    {{-- 1. Total Penerima --}}
                    <div class="bg-slate-50/80 hover:bg-sky-50/40 rounded-xl p-4 sm:p-5 border border-slate-100 transition-colors">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-2">
                             Total Penerima
                        </span>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-xl sm:text-2xl font-black tracking-tight">{{ number_format($totalBsps ?? 9795, 0, ',', '.') }}</span>
                            <span class="text-xs font-semibold text-slate-500">Unit</span>
                        </div>
                    </div>

                    {{-- 2. Dalam Proses --}}
                    <div class="bg-slate-50/80 hover:bg-amber-50/40 rounded-xl p-4 sm:p-5 border border-slate-100 transition-colors">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-2">
                             Dalam Proses
                        </span>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-xl sm:text-2xl font-black tracking-tight">{{ number_format($totalBspsPersiapan ?? 9795, 0, ',', '.') }}</span>
                            <span class="text-xs font-semibold text-slate-500">Unit</span>
                        </div>
                    </div>

                    {{-- 3. Selesai --}}
                    <div class="bg-slate-50/80 hover:bg-emerald-50/40 rounded-xl p-4 sm:p-5 border border-slate-100 transition-colors">
                        <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-2">
                             Selesai
                        </span>
                        <div class="flex items-baseline gap-1.5">
                            <span class="text-xl sm:text-2xl font-black tracking-tight">0</span>
                            <span class="text-xs font-semibold text-slate-500">Unit</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</section>