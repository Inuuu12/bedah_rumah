@extends('admin.layout')

@section('title', 'Tambah Dokumentasi Baru')
@section('header_title', 'Tambah Dokumentasi')
@section('header_subtitle', 'Publikasikan foto pengerjaan fisik, dokumen RAB, dan progres bedah rumah')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Breadcrumb & Back --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.posting.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-slate-500 hover:text-emerald-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>Kembali ke Daftar Dokumentasi</span>
        </a>
    </div>

    {{-- Error Alert --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl text-xs space-y-1 shadow-xs">
            <div class="font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Mohon periksa kembali isian formulir:</span>
            </div>
            <ul class="list-disc list-inside pl-1 space-y-0.5 text-red-700">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form Tambah Dokumentasi --}}
    <form method="POST" action="{{ route('admin.posting.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- 1. KOTAK INFORMASI UTAMA & BNBA --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 sm:p-6 shadow-xs space-y-5">
            <h3 class="text-sm font-bold text-slate-800 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-6 h-6 rounded-md bg-emerald-100 text-emerald-800 font-extrabold flex items-center justify-center text-xs">1</span>
                <span>Informasi Utama & Usulan BNBA</span>
            </h3>

            {{-- Baris 1: Tanggal Posting & Judul --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Tanggal Posting --}}
                <div>
                    <label for="tanggal_posting" class="block text-xs font-semibold text-slate-700 mb-1">
                        Tanggal Posting <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        name="tanggal_posting" 
                        id="tanggal_posting" 
                        value="{{ old('tanggal_posting', date('Y-m-d')) }}"
                        required
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium"
                    >
                </div>

                {{-- Judul Berita / Dokumentasi --}}
                <div class="md:col-span-2">
                    <label for="judul" class="block text-xs font-semibold text-slate-700 mb-1">
                        Judul Dokumentasi / Berita <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="judul" 
                        id="judul" 
                        value="{{ old('judul') }}"
                        placeholder="Contoh: Realisasi Serah Terima Kunci Bedah Rumah RTLH di Kecamatan Cibinong"
                        required
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium"
                    >
                </div>
            </div>

            {{-- Baris 2: Pencarian Penerima BNBA Bertingkat (Kecamatan -> Desa -> Penerima) --}}
            <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        <span>Tautkan dengan Penerima BNBA (Pilih Kecamatan & Desa Terlebih Dahulu)</span>
                    </span>
                    <span class="text-[10px] text-slate-400">Opsional, kosongkan jika ini dokumentasi umum</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    {{-- 1. Pilih Kecamatan --}}
                    <div>
                        <label for="select_kecamatan" class="block text-[11px] font-semibold text-slate-600 mb-1">
                            1. Pilih Kecamatan (40)
                        </label>
                        <select 
                            id="select_kecamatan" 
                            onchange="onKecamatanChange(this.value)"
                            class="w-full text-xs bg-white border border-slate-300 rounded-lg px-2.5 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium"
                        >
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach ($kecamatanList as $kec)
                                <option value="{{ $kec->id_kec }}">Kec. {{ $kec->name_kec }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- 2. Pilih Desa / Kelurahan --}}
                    <div>
                        <label for="select_desa" class="block text-[11px] font-semibold text-slate-600 mb-1">
                            2. Pilih Desa / Kelurahan
                        </label>
                        <select 
                            id="select_desa" 
                            disabled 
                            onchange="onDesaChange(this.value)"
                            class="w-full text-xs bg-white border border-slate-300 rounded-lg px-2.5 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium disabled:bg-slate-100 disabled:text-slate-400"
                        >
                            <option value="">-- Pilih kecamatan dulu --</option>
                        </select>
                    </div>

                    {{-- 3. Filter Program (BSPS / RTLH) --}}
                    <div>
                        <label for="select_program_filter" class="block text-[11px] font-semibold text-slate-600 mb-1">
                            3. Program Bantuan
                        </label>
                        <select 
                            id="select_program_filter" 
                            disabled 
                            onchange="onProgramFilterChange(this.value)"
                            class="w-full text-xs bg-white border border-slate-300 rounded-lg px-2.5 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium disabled:bg-slate-100 disabled:text-slate-400"
                        >
                            <option value="">-- Semua Program --</option>
                            <option value="RTLH">RTLH APBD BOGOR</option>
                            <option value="BSPS">BSPS KEMENPERA</option>
                        </select>
                    </div>

                    {{-- 4. Pilih Nama Penerima --}}
                    <div>
                        <label for="select_bnba" class="block text-[11px] font-semibold text-slate-600 mb-1">
                            4. Nama Penerima BNBA
                        </label>
                        <select 
                            id="select_bnba" 
                            disabled 
                            onchange="onBnbaChange(this.value)"
                            class="w-full text-xs bg-white border border-slate-300 rounded-lg px-2.5 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium disabled:bg-slate-100 disabled:text-slate-400"
                        >
                            <option value="">-- Pilih desa dulu --</option>
                        </select>
                    </div>
                </div>

                {{-- Hidden input untuk menyimpan id_bnba yang terpilih --}}
                <input type="hidden" name="id_bnba" id="input_id_bnba" value="{{ old('id_bnba') }}">

                {{-- Card Info Penerima Terpilih --}}
                <div id="bnba_info_card" class="hidden p-3 rounded-lg bg-emerald-50 border border-emerald-200 text-xs text-emerald-900 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="font-extrabold text-emerald-900" id="info_bnba_nama">-</span>
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-200 text-emerald-900" id="info_bnba_program">-</span>
                        </div>
                        <div class="text-[11px] text-emerald-700">
                            <span>NIK: <strong id="info_bnba_nik">-</strong></span> • 
                            <span id="info_bnba_alamat">-</span>
                        </div>
                    </div>
                    <button type="button" onclick="resetBnbaSelection()" class="text-xs text-rose-600 hover:text-rose-800 font-bold underline shrink-0">
                        Batal
                    </button>
                </div>
            </div>

            {{-- Isi Keterangan / Berita Progres --}}
            <div>
                <label for="keterangan" class="block text-xs font-semibold text-slate-700 mb-1">
                    Keterangan / Berita Progres Pengerjaan <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="keterangan" 
                    id="keterangan" 
                    rows="4" 
                    required
                    placeholder="Tuliskan deskripsi lengkap progres fisik, rincian perbaikan (atap, dinding, lantai, sanitasi), dan pencapaian renovasi..."
                    class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg p-3 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium leading-relaxed"
                >{{ old('keterangan') }}</textarea>
            </div>
        </div>

        {{-- 2. KOTAK UNGGAHAN FOTO (@3 FOTO PER TAHAP) --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 sm:p-6 shadow-xs space-y-6">
            <h3 class="text-sm font-bold text-slate-800 pb-2 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-md bg-emerald-100 text-emerald-800 font-extrabold flex items-center justify-center text-xs">2</span>
                    <span>Dokumentasi Foto</span>
                </div>
                <span class="text-[11px] text-slate-400 font-normal">Format: JPG, PNG, WEBP (Maks 5MB per foto)</span>
            </h3>

            {{-- Tahap A: Foto Persiapan --}}
            <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                        Tahap 1: Foto Persiapan / Kondisi Awal (Maks 3 Foto)
                    </span>
                    <span class="text-[10px] text-slate-500">Sebelum dibongkar / kondisi tidak layak</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="bg-white p-3 rounded-lg border border-slate-200 space-y-2">
                            <label class="block text-[11px] font-semibold text-slate-600">Foto Persiapan #{{ $i }}</label>
                            <input 
                                type="file" 
                                name="foto_persiapan_{{ $i }}" 
                                accept="image/*"
                                onchange="previewUpload(this, 'preview_persiapan_{{ $i }}')"
                                class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer"
                            >
                            <div id="preview_persiapan_{{ $i }}" class="hidden h-24 rounded-md overflow-hidden bg-slate-100 border border-slate-200">
                                <img src="" alt="Preview" class="w-full h-full object-cover">
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Tahap B: Foto Pembangunan / Konstruksi --}}
            <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                        Tahap 2: Foto Pembangunan / Pengerjaan Fisik (Maks 3 Foto)
                    </span>
                    <span class="text-[10px] text-slate-500">Proses tukang bekerja / pasang atap / dinding</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="bg-white p-3 rounded-lg border border-slate-200 space-y-2">
                            <label class="block text-[11px] font-semibold text-slate-600">Foto Pembangunan #{{ $i }}</label>
                            <input 
                                type="file" 
                                name="foto_pembangunan_{{ $i }}" 
                                accept="image/*"
                                onchange="previewUpload(this, 'preview_pembangunan_{{ $i }}')"
                                class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer"
                            >
                            <div id="preview_pembangunan_{{ $i }}" class="hidden h-24 rounded-md overflow-hidden bg-slate-100 border border-slate-200">
                                <img src="" alt="Preview" class="w-full h-full object-cover">
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            {{-- Tahap C: Foto Selesai / Serah Terima --}}
            <div class="p-4 rounded-xl bg-slate-50/80 border border-slate-200 space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                        Tahap 3: Foto Selesai / Hasil Akhir 100% (Maks 3 Foto)
                    </span>
                    <span class="text-[10px] text-slate-500">Kondisi rumah setelah jadi / serah terima kunci</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="bg-white p-3 rounded-lg border border-slate-200 space-y-2">
                            <label class="block text-[11px] font-semibold text-slate-600">Foto Selesai #{{ $i }}</label>
                            <input 
                                type="file" 
                                name="foto_selesai_{{ $i }}" 
                                accept="image/*"
                                onchange="previewUpload(this, 'preview_selesai_{{ $i }}')"
                                class="w-full text-[11px] text-slate-500 file:mr-2 file:py-1 file:px-2.5 file:rounded-md file:border-0 file:text-[10px] file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer"
                            >
                            <div id="preview_selesai_{{ $i }}" class="hidden h-24 rounded-md overflow-hidden bg-slate-100 border border-slate-200">
                                <img src="" alt="Preview" class="w-full h-full object-cover">
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- 3. KOTAK FILE RAB & TIM PELAPOR --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 sm:p-6 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-800 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-6 h-6 rounded-md bg-emerald-100 text-emerald-800 font-extrabold flex items-center justify-center text-xs">3</span>
                <span>File RAB & Tim Pelapor</span>
            </h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Unggah File RAB --}}
                <div>
                    <label for="file_rab" class="block text-xs font-semibold text-slate-700 mb-1">
                        Unggah File RAB (PDF Saja, Opsional)
                    </label>
                    <input 
                        type="file" 
                        name="file_rab" 
                        id="file_rab" 
                        accept=".pdf,application/pdf"
                        class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-slate-300 rounded-lg p-1 bg-slate-50"
                    >
                    <p class="text-[10px] text-slate-400 mt-1">Hanya format file PDF (.pdf). Maksimal 20MB.</p>
                </div>

                {{-- Tim Pelapor --}}
                <div>
                    <label for="tim_pelapor" class="block text-xs font-semibold text-slate-700 mb-1">
                        Tim Pelapor
                    </label>
                    <input 
                        type="text" 
                        name="tim_pelapor" 
                        id="tim_pelapor" 
                        value="{{ old('tim_pelapor') }}"
                        placeholder="Contoh: Tim Monev DPKPP Wilayah I (Ahmad & Tim)"
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium"
                    >
                    <p class="text-[10px] text-slate-400 mt-1">Nama petugas, surveyor, atau fasilitator yang melaporkan progres ini.</p>
                </div>
            </div>
        </div>

        {{-- 4. KOTAK LINK MEDIA SOSIAL --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 sm:p-6 shadow-xs space-y-4">
            <h3 class="text-sm font-bold text-slate-800 pb-2 border-b border-slate-100 flex items-center gap-2">
                <span class="w-6 h-6 rounded-md bg-emerald-100 text-emerald-800 font-extrabold flex items-center justify-center text-xs">4</span>
                <span>Tautan Media Sosial Publikasi (Opsional)</span>
            </h3>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                {{-- Link Instagram --}}
                <div>
                    <label for="link_instagram" class="block text-xs font-semibold text-slate-700 mb-1">
                        Link Instagram
                    </label>
                    <input 
                        type="url" 
                        name="link_instagram" 
                        id="link_instagram" 
                        value="{{ old('link_instagram') }}"
                        placeholder="https://www.instagram.com/p/..."
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-pink-500 font-medium"
                    >
                </div>

                {{-- Link Facebook --}}
                <div>
                    <label for="link_facebook" class="block text-xs font-semibold text-slate-700 mb-1">
                        Link Facebook
                    </label>
                    <input 
                        type="url" 
                        name="link_facebook" 
                        id="link_facebook" 
                        value="{{ old('link_facebook') }}"
                        placeholder="https://www.facebook.com/..."
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500 font-medium"
                    >
                </div>

                {{-- Link TikTok --}}
                <div>
                    <label for="link_tiktok" class="block text-xs font-semibold text-slate-700 mb-1">
                        Link TikTok
                    </label>
                    <input 
                        type="url" 
                        name="link_tiktok" 
                        id="link_tiktok" 
                        value="{{ old('link_tiktok') }}"
                        placeholder="https://www.tiktok.com/@..."
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-900 font-medium"
                    >
                </div>

                {{-- Link YouTube --}}
                <div>
                    <label for="link_youtube" class="block text-xs font-semibold text-slate-700 mb-1">
                        Link YouTube
                    </label>
                    <input 
                        type="url" 
                        name="link_youtube" 
                        id="link_youtube" 
                        value="{{ old('link_youtube') }}"
                        placeholder="https://www.youtube.com/watch?v=..."
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500 font-medium"
                    >
                </div>
            </div>
        </div>

        {{-- Tombol Aksi Simpan --}}
        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.posting.index') }}" class="px-5 py-2.5 rounded-lg border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-bold text-xs transition-colors">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-6 py-2.5 rounded-lg text-xs shadow-md hover:shadow-lg transition-all active:scale-95">
                <span>Simpan</span>
            </button>
        </div>
    </form>

</div>

<script>
    let currentBnbaData = [];

    function onKecamatanChange(kecId) {
        const desaSelect = document.getElementById('select_desa');
        const bnbaSelect = document.getElementById('select_bnba');

        desaSelect.innerHTML = '<option value="">-- Memuat Desa... --</option>';
        desaSelect.disabled = true;
        bnbaSelect.innerHTML = '<option value="">-- Pilih desa dulu --</option>';
        bnbaSelect.disabled = true;
        currentBnbaData = [];
        resetBnbaSelection();

        if (!kecId) {
            desaSelect.innerHTML = '<option value="">-- Pilih kecamatan dulu --</option>';
            return;
        }

        fetch(`{{ url('/admin/api/kelurahan') }}/${kecId}`)
            .then(res => res.json())
            .then(data => {
                desaSelect.innerHTML = '<option value="">-- Pilih Desa / Kelurahan --</option>';
                data.forEach(kel => {
                    desaSelect.innerHTML += `<option value="${kel.id_kel}">${kel.name_kel}</option>`;
                });
                desaSelect.disabled = false;
            })
            .catch(() => {
                desaSelect.innerHTML = '<option value="">Gagal memuat daftar desa</option>';
            });
    }

    function onDesaChange(kelId) {
        const bnbaSelect = document.getElementById('select_bnba');
        const progSelect = document.getElementById('select_program_filter');
        bnbaSelect.innerHTML = '<option value="">-- Memuat Penerima BNBA... --</option>';
        bnbaSelect.disabled = true;
        if (progSelect) {
            progSelect.disabled = true;
            progSelect.value = '';
        }
        currentBnbaData = [];
        resetBnbaSelection();

        if (!kelId) {
            bnbaSelect.innerHTML = '<option value="">-- Pilih desa dulu --</option>';
            return;
        }

        fetch(`{{ url('/admin/api/bnba-by-desa') }}/${kelId}`)
            .then(res => res.json())
            .then(data => {
                currentBnbaData = data || [];
                if (progSelect) progSelect.disabled = false;
                renderBnbaOptions();
            })
            .catch(() => {
                bnbaSelect.innerHTML = '<option value="">Gagal memuat data penerima</option>';
            });
    }

    function onProgramFilterChange(prog) {
        renderBnbaOptions(prog);
    }

    function renderBnbaOptions(filterProg = '') {
        const bnbaSelect = document.getElementById('select_bnba');
        resetBnbaSelection();

        if (!currentBnbaData || currentBnbaData.length === 0) {
            bnbaSelect.innerHTML = '<option value="">(Tidak ada penerima terdaftar di desa ini)</option>';
            bnbaSelect.disabled = true;
            return;
        }

        let filtered = currentBnbaData;
        if (filterProg === 'RTLH') {
            filtered = currentBnbaData.filter(b => (b.cat_bnba || '').toUpperCase().includes('APBD'));
        } else if (filterProg === 'BSPS') {
            filtered = currentBnbaData.filter(b => (b.cat_bnba || '').toUpperCase().includes('BSPS'));
        }

        if (filtered.length === 0) {
            bnbaSelect.innerHTML = `<option value="">(Tidak ada penerima program ${filterProg} di desa ini)</option>`;
            bnbaSelect.disabled = true;
            return;
        }

        bnbaSelect.innerHTML = `<option value="">-- Pilih Nama Penerima (${filtered.length} Orang) --</option>`;
        filtered.forEach(b => {
            bnbaSelect.innerHTML += `<option value="${b.id_bnba}">${b.name_bnba} (${b.cat_bnba}) - NIK: ${b.masked_nik}</option>`;
        });
        bnbaSelect.disabled = false;
    }

    function onBnbaChange(bnbaId) {
        const hiddenId = document.getElementById('input_id_bnba');
        const infoCard = document.getElementById('bnba_info_card');
        const infoNama = document.getElementById('info_bnba_nama');
        const infoNik = document.getElementById('info_bnba_nik');
        const infoProgram = document.getElementById('info_bnba_program');
        const infoAlamat = document.getElementById('info_bnba_alamat');
        const inputJudul = document.getElementById('judul');

        if (!bnbaId) {
            hiddenId.value = '';
            infoCard.classList.add('hidden');
            return;
        }

        hiddenId.value = bnbaId;
        const item = currentBnbaData.find(b => String(b.id_bnba) === String(bnbaId));
        if (item) {
            infoNama.innerText = item.name_bnba;
            infoNik.innerText = item.masked_nik || '-';
            infoProgram.innerText = item.cat_bnba || '-';
            infoAlamat.innerText = `${item.bnba_alamat || '-'} (Desa ${item.xkel || '-'}, Kec. ${item.xkec || '-'})`;
            infoCard.classList.remove('hidden');

            if (!inputJudul.value.trim()) {
                inputJudul.value = `Realisasi Bedah Rumah ${item.cat_bnba} - ${item.name_bnba} (${item.xkel}, Kec. ${item.xkec})`;
            }
        }
    }

    function resetBnbaSelection() {
        document.getElementById('input_id_bnba').value = '';
        document.getElementById('select_bnba').value = '';
        document.getElementById('bnba_info_card').classList.add('hidden');
    }

    function previewUpload(input, previewId) {
        const previewContainer = document.getElementById(previewId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = previewContainer.querySelector('img');
                img.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
