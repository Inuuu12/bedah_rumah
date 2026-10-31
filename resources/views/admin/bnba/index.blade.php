@extends('admin.layout')

@section('title', 'Data BNBA Penerima')
@section('header_title', 'Data Penerima')
@section('header_subtitle', 'Kelola penerima bantuan RTLH APBD & BSPS')

@php
    $maskNumber = function ($value) {
        $val = trim((string) $value);
        if ($val === '' || $val === '0' || $val === '-') {
            return '-';
        }
        $len = strlen($val);
        if ($len <= 4) {
            return $val;
        }
        return substr($val, 0, 2) . str_repeat('*', $len - 4) . substr($val, -2);
    };
@endphp

@section('content')
<div class="space-y-5">

    {{-- Info Khusus Admin Kecamatan --}}
    @if (Auth::user()?->isKecamatan())
        <div class="p-3.5 rounded-xl bg-blue-50/80 border border-blue-200 text-xs text-blue-900 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="p-1.5 rounded-lg bg-blue-100 text-blue-700 shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </span>
                <div>
                    <span class="font-bold">Mode Akses Monitoring Kecamatan:</span>
                    <span class="text-blue-700">Akun Kecamatan berwenang melakukan monitoring dan verifikasi data wilayah. Penginputan data usulan warga baru dilakukan oleh Admin Inti dan Admin Desa.</span>
                </div>
            </div>
            <span class="hidden sm:inline-flex px-2 py-0.5 rounded text-[10px] font-bold bg-blue-200/60 text-blue-800 shrink-0">
                Monitoring Wilayah
            </span>
        </div>
    @endif

    {{-- Filter & Search Card --}}
    <div class="bg-white rounded-xl border border-slate-200 p-4 sm:p-5 shadow-xs">
        <form method="GET" action="{{ route('admin.bnba') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            
            {{-- Pencarian Nama / NIK / Alamat --}}
            <div class="lg:col-span-2">
                <label for="q" class="block text-xs font-semibold text-slate-700 mb-1">Cari Nama / NIK / Alamat</label>
                <div class="relative">
                    <input 
                        type="text" 
                        name="q" 
                        id="q" 
                        value="{{ request('q') }}" 
                        placeholder="Ketik nama penerima, NIK, atau alamat..." 
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg pl-8 pr-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            {{-- Filter Kecamatan --}}
            <div>
                <label for="kecamatan" class="block text-xs font-semibold text-slate-700 mb-1">Pilih Kecamatan</label>
                <select 
                    name="kecamatan" 
                    id="kecamatan" 
                    class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-2.5 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                >
                    <option value=""> Semua Kecamatan</option>
                    @foreach ($kecamatanList as $kec)
                        <option value="{{ $kec->id_kec }}" {{ request('kecamatan') == $kec->id_kec ? 'selected' : '' }}>
                            Kec. {{ $kec->name_kec }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Program --}}
            <div>
                <label for="program" class="block text-xs font-semibold text-slate-700 mb-1">Program Bantuan</label>
                <select 
                    name="program" 
                    id="program" 
                    class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-2.5 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                >
                    <option value=""> Semua Program </option>
                    <option value="RTLH" {{ request('program') == 'RTLH' ? 'selected' : '' }}>RTLH APBD BOGOR</option>
                    <option value="BSPS" {{ request('program') == 'BSPS' ? 'selected' : '' }}>BSPS KEMENPERA</option>
                </select>
            </div>

            {{-- Filter Status & Submit --}}
            <div class="flex items-end gap-2">
                <div class="flex-1">
                    <label for="status" class="block text-xs font-semibold text-slate-700 mb-1">Status</label>
                    <select 
                        name="status" 
                        id="status" 
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-2.5 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                    >
                        <option value="">
                         Semua Status </option>
                        <option value="PERSIAPAN" {{ request('status') == 'PERSIAPAN' ? 'selected' : '' }}>PERSIAPAN</option>
                        <option value="PROSES" {{ request('status') == 'PROSES' ? 'selected' : '' }}>PEMBANGUNAN</option>
                        <option value="SELESAI" {{ request('status') == 'SELESAI' ? 'selected' : '' }}>SELESAI</option>
                    </select>
                </div>

                <button 
                    type="submit" 
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white text-xs font-semibold rounded-lg transition-colors shadow-xs shrink-0"
                >
                    Filter
                </button>

                @if(request()->anyFilled(['q', 'kecamatan', 'program', 'status']))
                    <a 
                        href="{{ route('admin.bnba') }}" 
                        class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-lg transition-colors border border-slate-200 shrink-0"
                        title="Reset Filter"
                    >
                        Reset
                    </a>
                @endif
            </div>

        </form>
    </div>

    {{-- Data Table Card --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
        
        {{-- Table Toolbar / Info --}}
        <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
            <div>
                <span class="text-xs font-bold text-slate-800">
                    Total Ditemukan: {{ number_format($penerimaList->total(), 0, ',', '.') }} Data
                </span>
                <span class="text-xs text-slate-500 ml-1">
                    (Menampilkan {{ $penerimaList->firstItem() ?? 0 }} - {{ $penerimaList->lastItem() ?? 0 }})
                </span>
            </div>

            <div class="flex items-center gap-2.5">
                @if (Auth::user()?->canInputWarga())
                    <button 
                        type="button" 
                        onclick="openCreateModal()" 
                        class="inline-flex items-center px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-semibold text-xs rounded-lg transition-colors shadow-xs cursor-pointer"
                    >
                        <span>Tambah Data Penerima</span>
                    </button>
                @endif
                <div class="text-xs text-slate-500 pl-2 border-l border-slate-300">
                    Halaman {{ $penerimaList->currentPage() }} dari {{ $penerimaList->lastPage() }}
                </div>
            </div>
        </div>

        {{-- Main Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-3 w-12 text-center">No</th>
                        <th class="py-3 px-3">Nama Penerima</th>
                        <th class="py-3 px-3">NIK</th>
                        <th class="py-3 px-3">No. KK</th>
                        <th class="py-3 px-3">Alamat Lengkap</th>
                        <th class="py-3 px-3">Desa / Kelurahan</th>
                        <th class="py-3 px-3">Kecamatan</th>
                        <th class="py-3 px-3">Program</th>
                        <th class="py-3 px-3">Status</th>
                        <th class="py-3 px-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($penerimaList as $index => $row)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="py-3 px-3 text-center text-slate-400 font-mono">
                                {{ $penerimaList->firstItem() + $index }}
                            </td>
                            <td class="py-3 px-3 font-bold text-slate-900 whitespace-nowrap">
                                {{ $row->name_bnba }}
                                @if($row->bnba_jkel)
                                    <span class="text-[10px] text-slate-400 font-normal">({{ $row->bnba_jkel }})</span>
                                @endif
                            </td>
                            {{-- Kolom NIK (2 angka awal & 2 angka akhir, tengah dibintangin) --}}
                            <td class="py-3 px-3 font-mono text-slate-700 whitespace-nowrap text-xs font-semibold">
                                {{ $maskNumber($row->bnba_nik) }}
                            </td>
                            {{-- Kolom No. KK (2 angka awal & 2 angka akhir, tengah dibintangin) --}}
                            <td class="py-3 px-3 font-mono text-slate-600 whitespace-nowrap text-xs">
                                {{ $maskNumber($row->bnba_kk) }}
                            </td>
                            <td class="py-3 px-3 text-slate-700 min-w-[180px]">
                                <span class="font-medium">{{ $row->bnba_alamat }}</span>
                                <div class="text-[10px] text-slate-400">RT {{ $row->bnba_rt ?? '-' }} / RW {{ $row->bnba_rw ?? '-' }}</div>
                            </td>
                            <td class="py-3 px-3 text-slate-800 whitespace-nowrap font-medium">
                                {{ $row->xkel }}
                            </td>
                            <td class="py-3 px-3 text-slate-800 whitespace-nowrap font-medium">
                                KEC. {{ $row->xkec }}
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap">
                                @if (str_contains($row->cat_bnba, 'APBD'))
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        RTLH APBD
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                        BSPS
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3 whitespace-nowrap">
                                @if ($row->st_akhir === 'SELESAI')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-200">
                                        SELESAI
                                    </span>
                                @elseif ($row->st_akhir === 'PROSES')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                        PEMBANGUNAN
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                        PERSIAPAN
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-3 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button 
                                        type="button" 
                                        onclick="showDetailModal({{ $row->id_bnba }})" 
                                        class="px-2.5 py-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-600 hover:text-white rounded border border-emerald-300 transition-colors"
                                        title="Lihat Detail Lengkap"
                                    >
                                        Detail
                                    </button>
                                    <button 
                                        type="button" 
                                        onclick="openStatusModal({{ $row->id_bnba }}, '{{ addslashes($row->name_bnba) }}', '{{ $row->st_akhir }}', '{{ str_contains(strtoupper($row->cat_bnba), 'APBD') ? 'RTLH' : 'BSPS' }}', '{{ addslashes($row->xkel ?? '') }}', {{ $row->id_kel ?? 'null' }})" 
                                        class="px-2.5 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded border border-slate-300 transition-colors"
                                        title="Ubah Status & Upload Foto Progres"
                                    >
                                        Status
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="py-12 text-center text-slate-500">
                                <svg class="w-10 h-10 mx-auto text-slate-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="font-semibold text-sm text-slate-700">Data penerima tidak ditemukan</p>
                                <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau ubah filter kecamatan/program.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Links --}}
        @if ($penerimaList->hasPages())
            <div class="p-4 border-t border-slate-200 bg-slate-50/50">
                {{ $penerimaList->links() }}
            </div>
        @endif
    </div>

</div>

{{-- Modal Detail Penerima --}}
<div id="detail-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs hidden">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-lg w-full overflow-hidden animate-in fade-in zoom-in-95 duration-150">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Detail Lengkap Penerima BNBA</h3>
                <p class="text-xs text-slate-500" id="modal-subheading">Memuat data...</p>
            </div>
            <button type="button" onclick="closeDetailModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div id="modal-content" class="p-5 space-y-4 max-h-[75vh] overflow-y-auto text-xs">
            <div class="text-center py-6 text-slate-400">Memuat rincian data...</div>
        </div>

        <div class="px-5 py-3 border-t border-slate-200 bg-slate-50 flex justify-end">
            <button type="button" onclick="closeDetailModal()" class="px-4 py-2 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold rounded-lg text-xs transition-colors">
                Tutup
            </button>
        </div>
    </div>
</div>

{{-- Modal Ubah Status & Upload Foto Progresan (Tampil di Depan) --}}
<div id="status-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs hidden">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-lg w-full overflow-hidden max-h-[92vh] flex flex-col animate-in fade-in zoom-in-95 duration-150">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50 shrink-0">
            <div>
                <h3 class="text-sm font-bold text-slate-900">Ubah Status Bantuan & Unggah Progres</h3>
                <p class="text-[11px] text-slate-500">Perbarui tahapan pelaksanaan dan unggah foto dokumentasi untuk portal depan.</p>
            </div>
            <button type="button" onclick="closeStatusModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="status-form" method="POST" action="" enctype="multipart/form-data" class="p-5 space-y-4 overflow-y-auto flex-1 text-xs">
            @csrf

            {{-- 1. Filter Berdasarkan Desa / Kelurahan --}}
            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label for="modal-select-desa" class="block text-xs font-semibold text-slate-700">
                        1. Filter Berdasarkan Desa / Kelurahan:
                    </label>
                    <span id="modal-desa-hint" class="text-[10px] text-slate-400 font-medium">Pilih wilayah desa</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
                    {{-- Dropdown Desa --}}
                    <div class="sm:col-span-2">
                        <select 
                            id="modal-select-desa" 
                            onchange="onModalDesaChange(this.value)"
                            class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                            {{-- Pilihan Desa dinamis --}}
                        </select>
                    </div>

                    {{-- Filter Program Bantuan (Semua / RTLH / BSPS) --}}
                    <div>
                        <select 
                            id="modal-select-prog-filter"
                            onchange="onModalProgramFilterChange(this.value)"
                            class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-2.5 py-2 text-slate-700 font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                            <option value="">Semua Program</option>
                            <option value="RTLH">RTLH APBD</option>
                            <option value="BSPS">BSPS PUSAT</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- 2. Pilih Nama Penerima (Terfilter Khusus Desa Terpilih) --}}
            <div>
                <div class="flex items-center justify-between mb-1">
                    <label for="modal-select-bnba" class="block text-xs font-semibold text-slate-700">
                        2. Pilih Nama Penerima:
                    </label>
                    <span id="modal-bnba-count" class="text-[10px] text-emerald-700 font-bold"></span>
                </div>
                <select 
                    id="modal-select-bnba" 
                    name="id_bnba" 
                    onchange="onModalBnbaSelect(this.value)" 
                    class="w-full text-xs bg-white border border-slate-300 rounded-lg px-3 py-2 text-slate-800 font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    required
                >
                    <!-- Terfilter otomatis sesuai desa yang dipilih -->
                </select>

                {{-- Detail singkat penerima terpilih --}}
                <div id="modal-bnba-selected-info" class="mt-2 p-2.5 rounded-lg bg-emerald-50/70 border border-emerald-200/80 text-[11px] text-emerald-950 flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <span class="font-bold text-emerald-900" id="info-selected-name">-</span> • 
                        <span id="info-selected-lokasi">Desa -, Kec. -</span>
                    </div>
                    <div>
                        <span class="text-emerald-700 font-medium">Status Saat Ini:</span>
                        <strong class="text-emerald-900 ml-1" id="info-selected-current-status">-</strong>
                    </div>
                </div>
            </div>

            {{-- 3. Pilih Status Baru --}}
            <div>
                <label for="modal-st-akhir" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    3. Pilih Status Pelaksanaan Baru:
                </label>
                <select 
                    name="st_akhir" 
                    id="modal-st-akhir" 
                    onchange="onModalStatusChange(this.value)"
                    class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 font-semibold focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                    required
                >
                    <option value="PERSIAPAN">PERSIAPAN (Tahap verifikasi & administrasi)</option>
                    <option value="PROSES">PEMBANGUNAN (Tahap pengerjaan fisik / bedah rumah)</option>
                    <option value="SELESAI">SELESAI (Pekerjaan tuntas & serah terima)</option>
                </select>
            </div>

            {{-- 4. Upload Foto Progresan Buat Ditampilkan di Depan --}}
            <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="block text-xs font-bold text-slate-800 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span>Upload Foto Progresan (Buat Tampil di Depan)</span>
                        </span>
                        <span class="text-[10px] text-slate-500" id="modal-photo-stage-hint">
                            Foto akan otomatis masuk ke galeri dokumentasi portal depan.
                        </span>
                    </div>
                    <span class="text-[10px] px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold uppercase" id="badge-target-stage">
                        Tahap Persiapan
                    </span>
                </div>

                {{-- Grid 3 Slot Foto Progres --}}
                <div class="grid grid-cols-3 gap-2.5">
                    @for ($i = 1; $i <= 3; $i++)
                        <div class="space-y-1">
                            <label class="block text-[10px] font-bold text-slate-600">Foto {{ $i }}</label>
                            <label class="relative flex flex-col items-center justify-center h-24 rounded-lg border-2 border-dashed border-slate-300 hover:border-emerald-500 bg-white cursor-pointer overflow-hidden group transition-all">
                                <img id="preview-prog-{{ $i }}" class="absolute inset-0 w-full h-full object-cover hidden" alt="Pratinjau">
                                <div id="placeholder-prog-{{ $i }}" class="flex flex-col items-center justify-center p-2 text-center text-slate-400 group-hover:text-emerald-600">
                                    <svg class="w-5 h-5 mb-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                    <span class="text-[9px] font-semibold">Pilih Foto</span>
                                </div>
                                <input type="file" name="foto_progres_{{ $i }}" accept="image/*" class="sr-only" onchange="previewStatusPhoto(this, 'preview-prog-{{ $i }}', 'placeholder-prog-{{ $i }}')">
                            </label>
                        </div>
                    @endfor
                </div>

                {{-- Catatan / Keterangan Progres --}}
                <div>
                    <label for="keterangan_progres" class="block text-[11px] font-semibold text-slate-600 mb-1">
                        Keterangan / Berita Progres (Opsional):
                    </label>
                    <textarea 
                        name="keterangan_progres" 
                        id="keterangan_progres" 
                        rows="2" 
                        placeholder="Contoh: Telah dimulai pengerjaan pembongkaran atap dan pemasangan bata hebel..."
                        class="w-full text-xs bg-white border border-slate-300 rounded-lg p-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500"
                    ></textarea>
                </div>
            </div>

            <div class="pt-3 border-t border-slate-200 flex items-center justify-end gap-2 shrink-0">
                <button type="button" onclick="closeStatusModal()" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-semibold rounded-lg text-xs transition-colors shadow-xs flex items-center gap-1.5">
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Modal Tambah Data Rumah (Hanya untuk Admin Inti & Admin Desa) --}}
@if (Auth::user()?->canInputWarga())
    @include('admin.bnba.create-modal')
@endif

@push('scripts')
<script>
    function maskNumber(value) {
        if (!value || value === '0' || value === '-') return '-';
        const str = String(value).trim();
        if (str.length <= 4) return str;
        return str.substring(0, 2) + '*'.repeat(str.length - 4) + str.substring(str.length - 2);
    }

    function showDetailModal(id) {
        const modal = document.getElementById('detail-modal');
        const content = document.getElementById('modal-content');
        const subheading = document.getElementById('modal-subheading');
        modal.classList.remove('hidden');
        content.innerHTML = '<div class="text-center py-6 text-slate-400">Memuat rincian data...</div>';

        fetch(`{{ url('/admin/bnba') }}/${id}`)
            .then(res => res.json())
            .then(res => {
                if (!res.data) {
                    content.innerHTML = '<div class="text-rose-600 font-semibold">Gagal memuat data penerima.</div>';
                    return;
                }
                const d = res.data;
                subheading.innerText = `ID #${d.id_bnba} • Tahun Anggaran ${d.thn_bnba}`;

                const coordHtml = res.koordinat ? `
                    <div class="p-3 bg-emerald-50/70 border border-emerald-200 rounded-lg">
                        <span class="block text-[11px] font-bold text-emerald-800">Koordinat Wilayah Desa (${res.koordinat.nama || d.xkel})</span>
                        <div class="mt-1 font-mono text-[11px] text-emerald-900">Lat: ${res.koordinat.lat}, Long: ${res.koordinat.long}</div>
                    </div>
                ` : '<div class="text-slate-400 text-[11px] italic">Koordinat GPS khusus belum tercatat.</div>';

                content.innerHTML = `
                    <div class="space-y-3">
                        <div class="grid grid-cols-2 gap-3 pb-3 border-b border-slate-100">
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Nama Penerima</span>
                                <span class="font-bold text-slate-900 text-sm">${d.name_bnba}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Jenis Kelamin</span>
                                <span class="font-semibold text-slate-700">${d.bnba_jkel === 'L' ? 'Laki-laki (L)' : (d.bnba_jkel === 'P' ? 'Perempuan (P)' : '-')}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pb-3 border-b border-slate-100">
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Nomor NIK</span>
                                <span class="font-mono font-bold text-slate-800">${maskNumber(d.bnba_nik)}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Nomor Kartu Keluarga (KK)</span>
                                <span class="font-mono text-slate-700">${maskNumber(d.bnba_kk)}</span>
                            </div>
                        </div>

                        <div class="pb-3 border-b border-slate-100">
                            <span class="text-slate-400 block text-[10px] uppercase font-bold">Alamat Rumah</span>
                            <span class="font-medium text-slate-800 text-xs">${d.bnba_alamat || '-'}</span>
                            <div class="mt-1 text-slate-500 text-[11px]">RT ${d.bnba_rt || '-'} / RW ${d.bnba_rw || '-'}</div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pb-3 border-b border-slate-100">
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Desa / Kelurahan</span>
                                <span class="font-semibold text-slate-800">${d.xkel}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Kecamatan</span>
                                <span class="font-semibold text-slate-800">KEC. ${d.xkec}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3 pb-3 border-b border-slate-100">
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Program Bantuan</span>
                                <span class="font-bold ${d.cat_bnba.includes('APBD') ? 'text-emerald-800' : 'text-sky-700'}">${d.cat_bnba}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Status Pelaksanaan</span>
                                <span class="font-bold text-amber-700">${d.st_akhir}</span>
                            </div>
                        </div>

                        <div>
                            <span class="text-slate-400 block text-[10px] uppercase font-bold mb-1.5">Informasi Lokasi Spasial</span>
                            ${coordHtml}
                        </div>
                    </div>
                `;
            })
            .catch(() => {
                content.innerHTML = '<div class="text-rose-600 font-semibold">Terjadi kendala saat mengambil data penerima.</div>';
            });
    }

    function closeDetailModal() {
        document.getElementById('detail-modal').classList.add('hidden');
    }

    @php
        $modalBnbaRows = [];
        $uniqueDesas = [];
        $desaIdMap = [];
        foreach ($penerimaList as $r) {
            $desaName = strtoupper(trim((string) ($r->xkel ?? '')));
            if ($desaName !== '' && !in_array($desaName, $uniqueDesas)) {
                $uniqueDesas[] = $desaName;
            }
            if (!empty($r->id_kel) && $desaName !== '' && !isset($desaIdMap[$desaName])) {
                $desaIdMap[$desaName] = (int) $r->id_kel;
            }
            $modalBnbaRows[] = [
                'id' => $r->id_bnba,
                'name' => $r->name_bnba,
                'cat' => str_contains(strtoupper($r->cat_bnba ?? ''), 'APBD') ? 'RTLH' : 'BSPS',
                'raw_cat' => $r->cat_bnba,
                'status' => $r->st_akhir,
                'id_kel' => $r->id_kel ?? null,
                'desa' => $desaName ?: '-',
                'kec' => strtoupper((string) ($r->xkec ?? '-')),
                'nik' => $maskNumber($r->bnba_nik ?? '-'),
            ];
        }
        sort($uniqueDesas);
    @endphp

    const bnbaRowsData = @json($modalBnbaRows);
    const uniqueDesaList = @json($uniqueDesas);
    const desaIdMap = @json($desaIdMap);

    let activeModalDesa = '';
    let activeModalProgram = '';
    let desaApiCache = {};

    function initModalDesaOptions(selectedDesa = '') {
        const selectDesa = document.getElementById('modal-select-desa');
        if (!selectDesa) return;

        selectDesa.innerHTML = '';
        if (uniqueDesaList.length > 1) {
            selectDesa.innerHTML += '<option value="">-- Semua Desa / Kelurahan --</option>';
        }

        uniqueDesaList.forEach(d => {
            const isSel = selectedDesa && selectedDesa.toUpperCase() === d.toUpperCase() ? 'selected' : '';
            selectDesa.innerHTML += `<option value="${d}" ${isSel}>Desa ${d}</option>`;
        });

        if (selectedDesa && uniqueDesaList.includes(selectedDesa.toUpperCase())) {
            selectDesa.value = selectedDesa.toUpperCase();
            activeModalDesa = selectedDesa.toUpperCase();
        } else if (uniqueDesaList.length > 0) {
            selectDesa.value = uniqueDesaList[0];
            activeModalDesa = uniqueDesaList[0];
        } else {
            selectDesa.value = '';
            activeModalDesa = '';
        }
    }

    function onModalDesaChange(desa) {
        activeModalDesa = desa ? desa.toUpperCase() : '';
        renderModalBnbaOptions();

        if (activeModalDesa && desaIdMap[activeModalDesa]) {
            fetchDesaBnba(desaIdMap[activeModalDesa], activeModalDesa);
        }
    }

    function onModalProgramFilterChange(prog) {
        activeModalProgram = prog;
        renderModalBnbaOptions();
    }

    function fetchDesaBnba(kelId, desaName, selectTargetId = null) {
        if (desaApiCache[kelId]) {
            renderWithApiData(desaApiCache[kelId], desaName, selectTargetId);
            return;
        }

        fetch(`{{ url('/admin/api/bnba-by-desa') }}/${kelId}`)
            .then(res => res.json())
            .then(data => {
                if (Array.isArray(data) && data.length > 0) {
                    desaApiCache[kelId] = data;
                    if (activeModalDesa === desaName) {
                        renderWithApiData(data, desaName, selectTargetId);
                    }
                }
            })
            .catch(() => {});
    }

    function renderWithApiData(data, desaName, selectTargetId = null) {
        const select = document.getElementById('modal-select-bnba');
        const countSpan = document.getElementById('modal-bnba-count');

        let filtered = data;
        if (activeModalProgram === 'RTLH') {
            filtered = data.filter(b => (b.cat_bnba || '').toUpperCase().includes('APBD'));
        } else if (activeModalProgram === 'BSPS') {
            filtered = data.filter(b => (b.cat_bnba || '').toUpperCase().includes('BSPS'));
        }

        countSpan.innerText = `(${filtered.length} Penerima di Desa ${desaName})`;

        if (filtered.length === 0) {
            select.innerHTML = `<option value="">(Tidak ada penerima terdaftar di Desa ${desaName})</option>`;
            updateModalBnbaInfo(null);
            return;
        }

        const currentVal = selectTargetId || select.value;
        select.innerHTML = '';
        filtered.forEach(b => {
            const isSel = currentVal && String(b.id_bnba) === String(currentVal);
            const prog = (b.cat_bnba || '').toUpperCase().includes('APBD') ? 'RTLH' : 'BSPS';
            select.innerHTML += `<option value="${b.id_bnba}" ${isSel ? 'selected' : ''}>${b.name_bnba} (${prog} - ${b.st_akhir || 'PERSIAPAN'}) - NIK: ${b.masked_nik || '-'}</option>`;
        });

        const targetId = currentVal && filtered.some(b => String(b.id_bnba) === String(currentVal))
            ? currentVal
            : (filtered[0] ? filtered[0].id_bnba : null);

        if (targetId) {
            select.value = targetId;
            const item = filtered.find(b => String(b.id_bnba) === String(targetId));
            if (item) {
                updateModalBnbaInfoFromApi(item);
            }
        }
    }

    function renderModalBnbaOptions(selectedId = null) {
        const select = document.getElementById('modal-select-bnba');
        const countSpan = document.getElementById('modal-bnba-count');

        let filtered = bnbaRowsData;
        if (activeModalDesa) {
            filtered = filtered.filter(r => r.desa.toUpperCase() === activeModalDesa.toUpperCase());
        }
        if (activeModalProgram) {
            filtered = filtered.filter(r => r.cat === activeModalProgram);
        }

        const desaLabel = activeModalDesa ? `Desa ${activeModalDesa}` : 'Semua Desa';
        countSpan.innerText = `(${filtered.length} Penerima di ${desaLabel})`;

        select.innerHTML = '';
        if (filtered.length === 0) {
            select.innerHTML = `<option value="">(Tidak ada penerima terdaftar di ${desaLabel})</option>`;
            updateModalBnbaInfo(null);
            return;
        }

        filtered.forEach(r => {
            const isSel = selectedId && String(r.id) === String(selectedId);
            select.innerHTML += `<option value="${r.id}" ${isSel ? 'selected' : ''}>${r.name} (${r.cat} - ${r.status}) - NIK: ${r.nik}</option>`;
        });

        const targetId = selectedId || (filtered[0] ? filtered[0].id : null);
        if (targetId) {
            select.value = targetId;
            onModalBnbaSelect(targetId);
        }
    }

    function onModalBnbaSelect(id) {
        for (const kelId in desaApiCache) {
            const found = desaApiCache[kelId].find(x => String(x.id_bnba) === String(id));
            if (found) {
                updateModalBnbaInfoFromApi(found);
                return;
            }
        }

        const r = bnbaRowsData.find(x => String(x.id) === String(id));
        updateModalBnbaInfo(r);
    }

    function updateModalBnbaInfoFromApi(item) {
        const form = document.getElementById('status-form');
        const nameSpan = document.getElementById('info-selected-name');
        const locSpan = document.getElementById('info-selected-lokasi');
        const statusSpan = document.getElementById('info-selected-current-status');
        const statusSelect = document.getElementById('modal-st-akhir');

        form.action = `{{ url('/admin/bnba') }}/${item.id_bnba}/status`;
        nameSpan.innerText = item.name_bnba;
        locSpan.innerText = `Desa ${item.xkel || '-'}, Kec. ${item.xkec || '-'}`;
        statusSpan.innerText = item.st_akhir || 'PERSIAPAN';
        statusSelect.value = item.st_akhir || 'PERSIAPAN';
        onModalStatusChange(statusSelect.value);
    }

    function updateModalBnbaInfo(r) {
        const form = document.getElementById('status-form');
        const nameSpan = document.getElementById('info-selected-name');
        const locSpan = document.getElementById('info-selected-lokasi');
        const statusSpan = document.getElementById('info-selected-current-status');
        const statusSelect = document.getElementById('modal-st-akhir');

        if (!r) {
            nameSpan.innerText = '-';
            locSpan.innerText = 'Desa -, Kec. -';
            statusSpan.innerText = '-';
            return;
        }

        form.action = `{{ url('/admin/bnba') }}/${r.id}/status`;
        nameSpan.innerText = r.name;
        locSpan.innerText = `Desa ${r.desa}, Kec. ${r.kec}`;
        statusSpan.innerText = r.status;
        statusSelect.value = r.status || 'PERSIAPAN';
        onModalStatusChange(statusSelect.value);
    }

    function onModalStatusChange(status) {
        const badge = document.getElementById('badge-target-stage');
        const hint = document.getElementById('modal-photo-stage-hint');
        if (status === 'SELESAI') {
            badge.className = 'text-[10px] px-2 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold uppercase';
            badge.innerText = 'Tahap Selesai 100%';
            hint.innerText = 'Foto akan dipublikasikan ke galeri tahap "Selesai 100%" di portal depan.';
        } else if (status === 'PROSES') {
            badge.className = 'text-[10px] px-2 py-0.5 rounded bg-sky-100 text-sky-800 font-bold uppercase';
            badge.innerText = 'Tahap Pembangunan';
            hint.innerText = 'Foto akan dipublikasikan ke galeri tahap "Proses Pembangunan" di portal depan.';
        } else {
            badge.className = 'text-[10px] px-2 py-0.5 rounded bg-amber-100 text-amber-800 font-bold uppercase';
            badge.innerText = 'Tahap Persiapan';
            hint.innerText = 'Foto akan dipublikasikan ke galeri tahap "Sebelum Renovasi (Persiapan)" di portal depan.';
        }
    }

    function previewStatusPhoto(input, imgId, placeholderId) {
        const img = document.getElementById(imgId);
        const placeholder = document.getElementById(placeholderId);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                img.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function openStatusModal(id = null, name = null, currentStatus = null, catBnba = null, desa = null, idKel = null) {
        const modal = document.getElementById('status-modal');
        modal.classList.remove('hidden');

        // Reset preview foto
        for (let i = 1; i <= 3; i++) {
            const img = document.getElementById(`preview-prog-${i}`);
            const ph = document.getElementById(`placeholder-prog-${i}`);
            if (img) img.classList.add('hidden');
            if (ph) ph.classList.remove('hidden');
        }
        document.getElementById('keterangan_progres').value = '';

        let targetDesa = desa;
        let targetIdKel = idKel;
        if (!targetDesa && id) {
            const row = bnbaRowsData.find(x => String(x.id) === String(id));
            if (row) {
                targetDesa = row.desa;
                targetIdKel = row.id_kel;
            }
        }
        if (!targetDesa && uniqueDesaList.length > 0) {
            targetDesa = uniqueDesaList[0];
            targetIdKel = desaIdMap[targetDesa] || null;
        }

        activeModalDesa = (targetDesa || '').toUpperCase();
        activeModalProgram = '';

        initModalDesaOptions(activeModalDesa);
        const progSelect = document.getElementById('modal-select-prog-filter');
        if (progSelect) progSelect.value = '';

        // Tampilkan langsung dari data lokal
        renderModalBnbaOptions(id);

        // Ambil data lengkap seluruh penerima desa via API
        const finalKelId = targetIdKel || (activeModalDesa ? desaIdMap[activeModalDesa] : null);
        if (finalKelId) {
            fetchDesaBnba(finalKelId, activeModalDesa, id);
        }
    }

    function closeStatusModal() {
        document.getElementById('status-modal').classList.add('hidden');
    }

    // Close on Escape key
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeDetailModal();
            closeStatusModal();
        }
    });
</script>
@endpush
@endsection
