{{-- Dokumentasi Kegiatan & Realisasi Bedah Rumah Kabupaten Bogor --}}
<section class="w-full max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 pb-20 scroll-mt-24 page-sheet-reveal" id="dokumentasi">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 sm:p-8 lg:p-10">
        
        {{-- Header Dokumentasi --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">
                    Dokumentasi Realisasi Bedah Rumah
                </h2>
                <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl leading-relaxed">
                    Dokumentasi progres renovasi fisik dan serah terima bantuan Rumah Tidak Layak Huni (RTLH) Pemerintah Kabupaten Bogor.
                </p>
            </div>
        </div>

        @php
            $dokumentasiList = [
                [
                    'nama' => 'Ahmad Supriyadi',
                    'lokasi' => 'Desa Cirimekar, Kec. Cibinong',
                    'kode' => 'RTLH-2026-001',
                    'status' => '100% Selesai Huni',
                    'statusBadge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'perbaikan' => 'Rangka atap baja ringan, dinding bata plester, lantai keramik, dan sanitasi MCK.',
                    'anggaran' => 'Rp 20.000.000',
                    'image' => 'https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=600&q=80',
                    'label' => 'Serah Terima Kunci',
                ],
                [
                    'nama' => 'Maman Hendrawan',
                    'lokasi' => 'Desa Pandansari, Kec. Ciawi',
                    'kode' => 'RTLH-2026-002',
                    'status' => 'Tahap Finishing (85%)',
                    'statusBadge' => 'bg-blue-50 text-blue-700 border-blue-200',
                    'perbaikan' => 'Penggantian kayu lapuk dengan tiang cor beton, plester acian, dan pengecatan dinding.',
                    'anggaran' => 'Rp 20.000.000',
                    'image' => 'https://images.unsplash.com/photo-1503387762-592deb58ef4e?auto=format&fit=crop&w=600&q=80',
                    'label' => 'Proses Konstruksi',
                ],
                [
                    'nama' => 'Siti Rokayah',
                    'lokasi' => 'Desa Barengkok, Kec. Leuwiliang',
                    'kode' => 'RTLH-2026-003',
                    'status' => '100% Selesai Huni',
                    'statusBadge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'perbaikan' => 'Perbaikan lantai tanah menjadi keramik, atap genteng press, dan ventilasi udara sehat.',
                    'anggaran' => 'Rp 20.000.000',
                    'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?auto=format&fit=crop&w=600&q=80',
                    'label' => 'Selesai Renovasi',
                ],
                [
                    'nama' => 'Dedi Kusnadi',
                    'lokasi' => 'Desa Sukamaju, Kec. Jonggol',
                    'kode' => 'RTLH-2026-004',
                    'status' => 'Pemasangan Atap (60%)',
                    'statusBadge' => 'bg-amber-50 text-amber-700 border-amber-200',
                    'perbaikan' => 'Bongkar atap seng bocor, perkuatan kolom struktur penahan gempa, dan bata hebel.',
                    'anggaran' => 'Rp 20.000.000',
                    'image' => 'https://images.unsplash.com/photo-1541888946425-d0fbb186c5f8?auto=format&fit=crop&w=600&q=80',
                    'label' => 'Proses Konstruksi',
                ],
                [
                    'nama' => 'Ujang Suherman',
                    'lokasi' => 'Desa Karang Tengah, Kec. Babakan Madang',
                    'kode' => 'RTLH-2026-005',
                    'status' => '100% Selesai Huni',
                    'statusBadge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'perbaikan' => 'Penggantian plafon jebol dengan gypsum, kusen kayu jati belanda, dan septictank higienis.',
                    'anggaran' => 'Rp 20.000.000',
                    'image' => 'https://images.unsplash.com/photo-1570129477492-45c003edd2be?auto=format&fit=crop&w=600&q=80',
                    'label' => 'Selesai Renovasi',
                ],
                [
                    'nama' => 'Endang Gunawan',
                    'lokasi' => 'Desa Waru, Kec. Parung',
                    'kode' => 'RTLH-2026-006',
                    'status' => '100% Selesai Huni',
                    'statusBadge' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'perbaikan' => 'Dinding geribik bambu diganti pasangan bata permanen plester rapi dan jendela kaca.',
                    'anggaran' => 'Rp 20.000.000',
                    'image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80',
                    'label' => 'Selesai Renovasi',
                ],
            ];
        @endphp

        {{-- Grid Galeri Foto Dokumentasi --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach ($dokumentasiList as $item)
                <div class="stagger-card bg-white rounded-2xl border border-slate-200/80 overflow-hidden shadow-xs hover:shadow-lg transition-all duration-300 flex flex-col group">
                    {{-- Foto Rumah --}}
                    <div class="relative h-48 overflow-hidden bg-slate-100">
                        <img src="{{ $item['image'] }}" alt="Dokumentasi {{ $item['nama'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                        
                        {{-- Tag Label Foto --}}
                        <div class="absolute top-3 left-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-black/60 backdrop-blur-md text-white border border-white/20">
                                {{ $item['label'] }}
                            </span>
                        </div>

                        {{-- Tag Status --}}
                        <div class="absolute top-3 right-3">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-extrabold bg-white/95 backdrop-blur-md text-slate-800 shadow-xs border border-slate-200">
                                {{ $item['kode'] }}
                            </span>
                        </div>

                        {{-- Nama & Lokasi di atas gambar --}}
                        <div class="absolute bottom-3 left-3 right-3 text-white">
                            <h3 class="text-sm font-extrabold drop-shadow-md leading-tight">{{ $item['nama'] }}</h3>
                            <p class="text-[11px] text-white/90 drop-shadow-sm mt-0.5">{{ $item['lokasi'] }}</p>
                        </div>
                    </div>

                    {{-- Konten Keterangan Perbaikan --}}
                    <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <div class="flex items-center justify-between gap-2 mb-2">
                                <span class="inline-block px-2 py-0.5 rounded-full text-[10px] font-extrabold border {{ $item['statusBadge'] }}">
                                    {{ $item['status'] }}
                                </span>
                            </div>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                {{ $item['perbaikan'] }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-400 font-medium">
                            <a href="#peta-wilayah" class="border border-teal-700 rounded-full px-2 py-1 text-teal-700 hover:text-teal-800 font-bold hover:underline">
                                Cek di Peta
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</section>
