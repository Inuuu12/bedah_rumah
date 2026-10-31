{{-- Modal Tambah Data Renovasi Rumah (Penerima BNBA Baru) --}}
<div id="create-bnba-modal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs hidden overflow-y-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-2xl max-w-2xl w-full my-8 overflow-hidden animate-in fade-in zoom-in-95 duration-150">
        
        {{-- Modal Header --}}
        <div class="px-6 py-4 border-b border-slate-200 bg-emerald-50/60 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="w-9 h-9 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                </span>
                <div>
                    <h3 class="text-sm font-bold text-slate-900">Tambah Data Renovasi Rumah</h3>
                    <p class="text-xs text-slate-500">Input data usulan penerima bantuan bedah rumah baru (RTLH / BSPS)</p>
                </div>
            </div>
            <button 
                type="button" 
                onclick="closeCreateModal()" 
                class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-1.5 rounded-lg transition-colors"
                aria-label="Tutup Modal"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Form --}}
        <form action="{{ route('admin.bnba.store') }}" method="POST" class="p-6 space-y-4 max-h-[75vh] overflow-y-auto text-xs">
            @csrf

            {{-- Baris 1: Nama & Jenis Kelamin --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <label for="create_name_bnba" class="block text-xs font-bold text-slate-700 mb-1">
                        Nama Lengkap Calon Penerima <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="name_bnba" 
                        id="create_name_bnba" 
                        required 
                        placeholder="Contoh: AHMAD HIDAYAT"
                        class="w-full text-xs uppercase bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                    >
                </div>
                <div>
                    <label for="create_bnba_jkel" class="block text-xs font-bold text-slate-700 mb-1">
                        Jenis Kelamin <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="bnba_jkel" 
                        id="create_bnba_jkel" 
                        required
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                    >
                        <option value="L">Laki-laki (L)</option>
                        <option value="P">Perempuan (P)</option>
                    </select>
                </div>
            </div>

            {{-- Baris 2: NIK & No KK --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="create_bnba_nik" class="block text-xs font-bold text-slate-700 mb-1">
                        Nomor Induk Kependudukan (NIK) <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="bnba_nik" 
                        id="create_bnba_nik" 
                        required 
                        maxlength="16"
                        pattern="\d{16}"
                        placeholder="16 digit angka (3201...)"
                        class="w-full text-xs font-mono bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                    >
                </div>
                <div>
                    <label for="create_bnba_kk" class="block text-xs font-bold text-slate-700 mb-1">
                        Nomor Kartu Keluarga (KK) <span class="text-slate-400 font-normal">(opsional)</span>
                    </label>
                    <input 
                        type="text" 
                        name="bnba_kk" 
                        id="create_bnba_kk" 
                        maxlength="16"
                        placeholder="16 digit angka No KK"
                        class="w-full text-xs font-mono bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                    >
                </div>
            </div>

            {{-- Baris 3: Program & Tahun Anggaran --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="create_cat_bnba" class="block text-xs font-bold text-slate-700 mb-1">
                        Kategori Program Bantuan <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="cat_bnba" 
                        id="create_cat_bnba" 
                        required
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                    >
                        <option value="APBD BOGOR">RTLH APBD Kab. Bogor</option>
                        <option value="BSPS">BSPS Kemenpera (Nasional)</option>
                    </select>
                </div>
                <div>
                    <label for="create_thn_bnba" class="block text-xs font-bold text-slate-700 mb-1">
                        Tahun Anggaran
                    </label>
                    <select 
                        name="thn_bnba" 
                        id="create_thn_bnba" 
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                    >
                        <option value="2026" selected>2026</option>
                        <option value="2025">2025</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
            </div>

            {{-- Baris 4: Wilayah (Kecamatan & Desa) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label for="create_id_kec" class="block text-xs font-bold text-slate-700 mb-1">
                        Kecamatan <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="id_kec" 
                        id="create_id_kec" 
                        required
                        onchange="loadDesaByKecamatan(this.value)"
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                    >
                        <option value="">-- Pilih Kecamatan (40) --</option>
                        @if(isset($kecamatanList))
                            @foreach ($kecamatanList as $kec)
                                <option value="{{ $kec->id_kec }}">Kec. {{ $kec->name_kec }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div>
                    <label for="create_id_kel" class="block text-xs font-bold text-slate-700 mb-1">
                        Desa / Kelurahan <span class="text-rose-500">*</span>
                    </label>
                    <select 
                        name="id_kel" 
                        id="create_id_kel" 
                        required
                        class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                    >
                        <option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>
                    </select>
                </div>
            </div>

            {{-- Baris 5: Alamat Rumah, RT, RW --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <label for="create_bnba_alamat" class="block text-xs font-bold text-slate-700 mb-1">
                        Alamat Lengkap Rumah / Kampung <span class="text-rose-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        name="bnba_alamat" 
                        id="create_bnba_alamat" 
                        required 
                        placeholder="Contoh: KP. BABAKAN RT 02/01"
                        class="w-full text-xs uppercase bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                    >
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label for="create_bnba_rt" class="block text-xs font-bold text-slate-700 mb-1">RT</label>
                        <input 
                            type="text" 
                            name="bnba_rt" 
                            id="create_bnba_rt" 
                            placeholder="001"
                            maxlength="3"
                            class="w-full text-xs font-mono bg-slate-50 border border-slate-300 rounded-lg px-2.5 py-2 text-slate-800 text-center placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                    </div>
                    <div>
                        <label for="create_bnba_rw" class="block text-xs font-bold text-slate-700 mb-1">RW</label>
                        <input 
                            type="text" 
                            name="bnba_rw" 
                            id="create_bnba_rw" 
                            placeholder="002"
                            maxlength="3"
                            class="w-full text-xs font-mono bg-slate-50 border border-slate-300 rounded-lg px-2.5 py-2 text-slate-800 text-center placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                    </div>
                </div>
            </div>

            {{-- Baris 6: Status Pelaksanaan Awal --}}
            <div>
                <label for="create_st_akhir" class="block text-xs font-bold text-slate-700 mb-1">
                    Tahap / Status Pelaksanaan <span class="text-rose-500">*</span>
                </label>
                <select 
                    name="st_akhir" 
                    id="create_st_akhir" 
                    required
                    class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                >
                    <option value="PERSIAPAN" selected>PERSIAPAN (Tahap usulan, verifikasi & administrasi)</option>
                    <option value="PROSES">PROSES (Tahap pengerjaan fisik / sedang direnovasi)</option>
                    <option value="SELESAI">SELESAI (Renovasi tuntas & telah serah terima)</option>
                </select>
            </div>

            {{-- Baris 7: Koordinat GPS (Opsional) --}}
            <div class="pt-2 border-t border-slate-100">
                <span class="block text-[11px] font-bold text-slate-600 mb-2">Koordinat Spasial GPS Rumah (Opsional):</span>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <input 
                            type="text" 
                            name="gps_lat" 
                            id="create_gps_lat" 
                            placeholder="Latitude (Contoh: -6.5821)"
                            class="w-full text-xs font-mono bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                    </div>
                    <div>
                        <input 
                            type="text" 
                            name="gps_long" 
                            id="create_gps_long" 
                            placeholder="Longitude (Contoh: 106.8123)"
                            class="w-full text-xs font-mono bg-slate-50 border border-slate-300 rounded-lg px-3 py-2 text-slate-800 placeholder-slate-400 focus:ring-2 focus:ring-emerald-500 focus:outline-none"
                        >
                    </div>
                </div>
            </div>

            {{-- Footer Buttons --}}
            <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-2">
                <button 
                    type="button" 
                    onclick="closeCreateModal()" 
                    class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 font-semibold rounded-lg text-xs transition-colors"
                >
                    Batal
                </button>
                <button 
                    type="submit" 
                    class="px-5 py-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white font-semibold rounded-lg text-xs transition-colors shadow-xs flex items-center gap-1.5"
                >
                    <span>Simpan Data Pemnerima</span>
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    function openCreateModal() {
        const modal = document.getElementById('create-bnba-modal');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeCreateModal() {
        const modal = document.getElementById('create-bnba-modal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function loadDesaByKecamatan(kecId) {
        const kelSelect = document.getElementById('create_id_kel');
        if (!kelSelect) return;

        if (!kecId) {
            kelSelect.innerHTML = '<option value="">-- Pilih Kecamatan Terlebih Dahulu --</option>';
            return;
        }

        kelSelect.innerHTML = '<option value="">Memuat desa / kelurahan...</option>';

        fetch(`{{ url('/admin/api/kelurahan') }}/${kecId}`)
            .then(res => res.json())
            .then(data => {
                kelSelect.innerHTML = '<option value="">-- Pilih Desa / Kelurahan --</option>';
                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.id_kel;
                    opt.textContent = item.name_kel;
                    kelSelect.appendChild(opt);
                });
            })
            .catch(() => {
                kelSelect.innerHTML = '<option value="">Gagal memuat desa/kelurahan</option>';
            });
    }

    // Close on Escape key
    window.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            closeCreateModal();
        }
    });
</script>

