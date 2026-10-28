@extends('admin.layout')

@section('title', 'Data BNBA Penerima')
@section('header_title', 'Data BNBA (By Name By Address)')
@section('header_subtitle', 'Kelola dan verifikasi daftar penerima bantuan RTLH APBD & BSPS')

@section('content')
<div class="space-y-5">

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
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg pl-8 pr-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 font-medium"
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
                    class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-2.5 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 font-medium"
                >
                    <option value="">-- Semua Kecamatan (40) --</option>
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
                    class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-2.5 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 font-medium"
                >
                    <option value="">-- Semua Program --</option>
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
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-2.5 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:border-emerald-600 font-medium"
                    >
                        <option value="">-- Semua Status --</option>
                        <option value="PERSIAPAN" {{ request('status') == 'PERSIAPAN' ? 'selected' : '' }}>PERSIAPAN</option>
                        <option value="PROSES" {{ request('status') == 'PROSES' ? 'selected' : '' }}>PROSES</option>
                        <option value="SELESAI" {{ request('status') == 'SELESAI' ? 'selected' : '' }}>SELESAI</option>
                    </select>
                </div>

                <button 
                    type="submit" 
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-lg transition-colors shadow-xs shrink-0"
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
        <div class="p-4 border-b border-slate-200 flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-slate-50/50">
            <div>
                <span class="text-xs font-bold text-slate-800">
                    Total Ditemukan: {{ number_format($penerimaList->total(), 0, ',', '.') }} Data
                </span>
                <span class="text-xs text-slate-500 ml-1">
                    (Menampilkan {{ $penerimaList->firstItem() ?? 0 }} - {{ $penerimaList->lastItem() ?? 0 }})
                </span>
            </div>

            <div class="text-xs text-slate-500">
                Halaman {{ $penerimaList->currentPage() }} dari {{ $penerimaList->lastPage() }}
            </div>
        </div>

        {{-- Main Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-left">
                <thead class="bg-slate-50 text-slate-600 font-semibold border-b border-slate-200 uppercase tracking-wider text-[11px]">
                    <tr>
                        <th class="py-3 px-3 w-12 text-center">No</th>
                        <th class="py-3 px-3">Nama Penerima</th>
                        <th class="py-3 px-3">NIK / No KK</th>
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
                            <td class="py-3 px-3 font-mono text-slate-600 whitespace-nowrap">
                                <div>{{ $row->bnba_nik }}</div>
                                @if($row->bnba_kk && $row->bnba_kk !== '0')
                                    <div class="text-[10px] text-slate-400">KK: {{ $row->bnba_kk }}</div>
                                @endif
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
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
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
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        SELESAI
                                    </span>
                                @elseif ($row->st_akhir === 'PROSES')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-blue-50 text-blue-700 border border-blue-200">
                                        PROSES
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
                                        class="px-2 py-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded border border-emerald-200 transition-colors"
                                        title="Lihat Detail Lengkap"
                                    >
                                        Detail
                                    </button>
                                    <button 
                                        type="button" 
                                        onclick="openStatusModal({{ $row->id_bnba }}, '{{ addslashes($row->name_bnba) }}', '{{ $row->st_akhir }}')" 
                                        class="px-2 py-1 text-[11px] font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded border border-slate-200 transition-colors"
                                        title="Ubah Status Bantuan"
                                    >
                                        Status
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-slate-500">
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

{{-- Modal Ubah Status --}}
<div id="status-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs hidden">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xl max-w-md w-full overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-200 flex items-center justify-between bg-slate-50">
            <h3 class="text-sm font-bold text-slate-900">Ubah Status Bantuan</h3>
            <button type="button" onclick="closeStatusModal()" class="text-slate-400 hover:text-slate-600 p-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form id="status-form" method="POST" action="" class="p-5 space-y-4">
            @csrf
            <div>
                <span class="block text-xs text-slate-500 mb-1">Nama Penerima:</span>
                <span id="status-modal-name" class="block text-sm font-bold text-slate-900"></span>
            </div>

            <div>
                <label for="modal-st-akhir" class="block text-xs font-semibold text-slate-700 mb-1.5">
                    Pilih Status Baru:
                </label>
                <select 
                    name="st_akhir" 
                    id="modal-st-akhir" 
                    class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2.5 text-slate-800 font-medium focus:ring-2 focus:ring-emerald-600 focus:outline-none"
                    required
                >
                    <option value="PERSIAPAN">PERSIAPAN (Tahap verifikasi & administrasi)</option>
                    <option value="PROSES">PROSES (Tahap pengerjaan fisik / bedah rumah)</option>
                    <option value="SELESAI">SELESAI (Pekerjaan tuntas & serah terima)</option>
                </select>
            </div>

            <div class="pt-3 border-t border-slate-100 flex items-center justify-end gap-2">
                <button type="button" onclick="closeStatusModal()" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg text-xs transition-colors shadow-xs">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function showDetailModal(id) {
        const modal = document.getElementById('detail-modal');
        const content = document.getElementById('modal-content');
        const subheading = document.getElementById('modal-subheading');
        modal.classList.remove('hidden');
        content.innerHTML = '<div class="text-center py-6 text-slate-400">Memuat rincian data...</div>';

        fetch(`/admin/bnba/${id}`)
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
                                <span class="font-mono font-bold text-slate-800">${d.bnba_nik}</span>
                            </div>
                            <div>
                                <span class="text-slate-400 block text-[10px] uppercase font-bold">Nomor Kartu Keluarga (KK)</span>
                                <span class="font-mono text-slate-700">${(d.bnba_kk && d.bnba_kk !== '0') ? d.bnba_kk : '-'}</span>
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
                                <span class="font-bold ${d.cat_bnba.includes('APBD') ? 'text-emerald-700' : 'text-sky-700'}">${d.cat_bnba}</span>
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

    function openStatusModal(id, name, currentStatus) {
        const modal = document.getElementById('status-modal');
        const form = document.getElementById('status-form');
        const nameSpan = document.getElementById('status-modal-name');
        const select = document.getElementById('modal-st-akhir');

        nameSpan.innerText = name;
        select.value = currentStatus;
        form.action = `/admin/bnba/${id}/status`;
        modal.classList.remove('hidden');
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
