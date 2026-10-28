
{{-- Peta Wilayah & Tabel Data Sebaran RTLH & BSPS Kab. Bogor --}}
<section class="w-full max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 pb-16" id="peta-wilayah">

{{-- Peta Wilayah & Tabel Data Sebaran RTLH & BSPS Kab. Bogor --}}
<section class="w-full max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 pb-16 scroll-mt-24 page-sheet-reveal" id="peta-wilayah">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">

        {{-- Header Peta & Data --}}
        <div class="p-5 sm:p-7 border-b border-slate-100 bg-white">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">
                        Peta &amp; Data Sebaran Bedah Rumah
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-2xl leading-relaxed">
                        Visualisasi pemetaan titik sasaran dan sebaran bantuan Rumah Tidak Layak Huni (RTLH &amp; BSPS) Pemerintah Kabupaten Bogor.
                    </p>
                </div>

                {{-- Quick Legend / Status Markers --}}
                <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs font-semibold bg-slate-50 p-2.5 rounded-xl border border-slate-200/80 shadow-xs">
                    <span class="flex items-center gap-1.5 text-slate-700">
                        <img src="{{ asset('images/icon-teal-solid.png') }}" class="w-3.5 h-3.5 rounded-full shadow-xs" alt="RTLH">
                        <span class="text-[11px] font-bold">RTLH (APBD)</span>
                    </span>
                    <span class="flex items-center gap-1.5 text-slate-700">
                        <img src="{{ asset('images/icon-dark-solid.png') }}" class="w-3.5 h-3.5 rounded-full shadow-xs" alt="BSPS">
                        <span class="text-[11px] font-bold">BSPS (APBN/PUPR)</span>
                    </span>
                </div>
            </div>

            <!-- {{-- Statistik Ringkas Wilayah --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-5 pt-4 border-t border-slate-100">
                <div class="bg-slate-50/70 p-3 sm:p-3.5 rounded-xl border border-slate-100">
                    <div class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Titik Sasaran</div>
                    <div class="text-lg sm:text-xl font-black mt-0.5">{{ number_format($totalDesaKel ?? 435, 0, ',', '.') }} <span class="text-xs font-semibold text-slate-500">Desa/Kel</span></div>
                </div>
                <div class="bg-slate-50/70 p-3 sm:p-3.5 rounded-xl border border-slate-100">
                    <div class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Kecamatan Sasaran</div>
                    <div class="text-lg sm:text-xl font-black mt-0.5">{{ count($daftar40Kecamatan ?? []) ?: 40 }} <span class="text-xs font-semibold text-slate-500">Kecamatan</span></div>
                </div>
                <div class="bg-slate-50/70 p-3 sm:p-3.5 rounded-xl border border-slate-100">
                    <div class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Program RTLH</div>
                    <div class="text-lg sm:text-xl font-black mt-0.5">{{ number_format($totalRtlh ?? 1502, 0, ',', '.') }} <span class="text-xs font-semibold text-slate-500">Penerima</span></div>
                </div>
                <div class="bg-slate-50/70 p-3 sm:p-3.5 rounded-xl border border-slate-100">
                    <div class="text-[10px] sm:text-[11px] font-bold text-slate-400 uppercase tracking-wider">Program BSPS</div>
                    <div class="text-lg sm:text-xl font-black mt-0.5">{{ number_format($totalBsps ?? 9795, 0, ',', '.') }} <span class="text-xs font-semibold text-slate-500">Unit</span></div>
                </div>
            </div> -->
        </div>

        {{-- Container Utama: Berdampingan Kiri Peta & Kanan Tabel --}}
        <div class="p-4 sm:p-6 bg-slate-50/50">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-stretch">

                {{-- SISI KIRI: PETA INTERAKTIF LEAFLET (7 Kolom) --}}
                <div class="lg:col-span-7 flex flex-col">
                    <div class="relative w-full h-[480px] lg:h-[620px] rounded-xl overflow-hidden border border-slate-200/90 shadow-sm bg-slate-100">

                        {{-- Map Element --}}
                        <div id="leaflet-map" class="w-full h-full z-10"></div>

                        {{-- Floating Top Left: Mode Sebaran Kecamatan Aktif --}}
                        <div id="map-active-kecamatan-bar" class="absolute top-3 left-14 z-20 bg-white/95 backdrop-blur-md px-3.5 py-2 rounded-xl border border-slate-200/90 shadow-lg hidden items-center justify-between gap-2 transition-all max-w-[280px] sm:max-w-xs">
                            <div class="flex items-center gap-2 min-w-0">
                                <div class="truncate">
                                    <span class="text-xs font-black text-slate-900" id="map-active-kec-name">Kecamatan Cibinong</span>
                                    <span class="text-[10.5px] text-slate-500 block font-medium" id="map-active-kec-counts">(54 RTLH • 470 BSPS)</span>
                                </div>
                            </div>
                        </div>

                        {{-- Floating Top Right: Layer Control Batas Wilayah (Kab, Kec, Kel/Desa, Titik) --}}
                        <div id="map-layer-controls" class="absolute top-3 right-3 z-20 bg-white/95 backdrop-blur-md px-3 py-2.5 rounded-xl border border-slate-200/90 shadow-lg text-slate-700 pointer-events-auto">
                            <div class="text-[10px] font-extrabold uppercase tracking-wider text-teal-800 mb-1.5 flex items-center gap-1.5 border-b border-slate-100 pb-1">
                                <svg class="w-3.5 h-3.5 text-teal-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                                <span>Batas Wilayah</span>
                            </div>
                            <div class="space-y-1 text-[11px] font-medium">
                                <label class="flex items-center gap-2 cursor-pointer hover:text-teal-800 transition-colors">
                                    <input type="checkbox" id="layer-toggle-kab" checked onchange="toggleLayerKabupaten(this.checked)" class="rounded text-teal-600 focus:ring-teal-500 w-3.5 h-3.5 accent-teal-600">
                                    <span>Kabupaten</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer hover:text-teal-800 transition-colors">
                                    <input type="checkbox" id="layer-toggle-kec" checked onchange="toggleLayerKecamatan(this.checked)" class="rounded text-teal-600 focus:ring-teal-500 w-3.5 h-3.5 accent-teal-600">
                                    <span>Kecamatan</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer hover:text-teal-800 transition-colors">
                                    <input type="checkbox" id="layer-toggle-kel" onchange="toggleLayerKelurahan(this.checked)" class="rounded text-teal-600 focus:ring-teal-500 w-3.5 h-3.5 accent-teal-600">
                                    <span>Desa / Kelurahan</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer hover:text-teal-800 transition-colors border-t border-slate-100 pt-1">
                                    <input type="checkbox" id="layer-toggle-marker" checked onchange="toggleLayerMarkers(this.checked)" class="rounded text-teal-600 focus:ring-teal-500 w-3.5 h-3.5 accent-teal-600">
                                    <span>Titik Sasaran</span>
                                </label>
                            </div>
                        </div>

                        {{-- Floating Map Controls Info Bottom --}}
                        <div id="map-bottom-hint" class="absolute bottom-3 left-3 right-3 z-20 bg-white/95 backdrop-blur-md px-3.5 py-2 rounded-xl border border-slate-200/80 shadow-md text-[11px] text-slate-600 flex items-center justify-between gap-2 pointer-events-auto">
                            <div class="flex items-center gap-2 truncate">
                                <svg class="w-4 h-4 text-teal-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span id="map-hint-text" class="truncate">Klik wilayah / titik kecamatan di peta atau baris tabel untuk melihat sebaran rumah.</span>
                            </div>
                            <button type="button" onclick="resetToKabupatenOverview()" class="text-teal-700 hover:text-teal-900 font-bold text-[10.5px] underline shrink-0 hidden" id="map-quick-reset">
                                Semua Kecamatan
                            </button>
                        </div>
                    </div>
                </div>

                {{-- SISI KANAN: TABEL DATA BEDAH RUMAH (5 Kolom) --}}
                <div class="lg:col-span-5 flex flex-col bg-white rounded-xl border border-slate-200/90 shadow-sm overflow-hidden h-[480px] lg:h-[620px]">

                    {{-- Header Panel --}}
                    <div class="p-3.5 border-b border-slate-100 bg-white space-y-2.5 shrink-0">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black uppercase tracking-wider text-slate-800 flex items-center gap-1.5" id="panel-title-text">
                                Data 40 Kecamatan
                            </span>
                            <span id="tab-indicator-badge" class="text-[10px] font-extrabold text-teal-800 bg-teal-50 px-2.5 py-0.5 rounded-md border border-teal-100/80">
                                40 Kecamatan
                            </span>
                        </div>

                        {{-- Navigation Toggle Mode (Kecamatan vs Sebaran Rumah) --}}
                        <div id="panel-toggle-container" class="flex items-center gap-1 p-1 bg-slate-100 rounded-xl text-xs font-bold">
                            <button type="button" id="tab-btn-kecamatan" onclick="resetToKabupatenOverview()" class="flex-1 py-1.5 px-3 rounded-lg text-xs font-bold transition-all bg-white text-teal-800 shadow-xs">
                                Rekap 40 Kecamatan
                            </button>
                            <button type="button" id="tab-btn-sebaran" class="flex-1 py-1.5 px-3 rounded-lg text-xs font-bold transition-all text-slate-400 cursor-not-allowed" disabled>
                                Sebaran Rumah
                            </button>
                        </div>
                    </div>

                    {{-- ================= TABEL 1: REKAPITULASI 40 KECAMATAN ================= --}}
                    <div id="panel-tabel-kecamatan" class="flex flex-col flex-1 overflow-hidden">
                        {{-- Search Input Kecamatan --}}
                        <div class="p-2.5 px-3 border-b border-slate-100 bg-slate-50/50 shrink-0">
                            <div class="relative">
                                <input type="text" id="search-kecamatan-input" oninput="filterKecamatanTable()" placeholder="Cari kecamatan..." class="w-full text-xs bg-white border border-slate-200 rounded-lg pl-8 pr-3 py-1.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all">
                                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Scrollable Table 40 Kecamatan --}}
                        <div class="overflow-y-auto flex-1">
                            <table class="w-full text-left text-xs text-slate-700">
                                <thead class="bg-slate-50 text-[10px] font-bold text-slate-600 uppercase tracking-wider sticky top-0 border-b border-slate-200 z-10 shadow-2xs">
                                    <tr>
                                        <th scope="col" class="py-2 px-2.5 text-center w-8">#</th>
                                        <th scope="col" class="py-2 px-2.5">Kecamatan</th>
                                        <th scope="col" class="py-2 px-2 text-center text-emerald-700">RTLH</th>
                                        <th scope="col" class="py-2 px-2 text-center text-blue-700">BSPS</th>
                                        <th scope="col" class="py-2 px-2.5 text-center">Jumlah</th>
                                        <th scope="col" class="py-2 px-2 text-center w-12">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-kecamatan-body" class="divide-y divide-slate-100">
                                    {{-- Diisi secara dinamis via JavaScript dari daftar40Kecamatan --}}
                                </tbody>
                            </table>
                        </div>

                        {{-- Footer Rekap Total Kecamatan --}}
                        <div class="p-2.5 px-3.5 border-t border-slate-200 bg-slate-50 text-[10.5px] font-bold text-slate-700 flex items-center justify-between shrink-0">
                            <span>Total: <strong class="text-teal-800">{{ count($daftar40Kecamatan ?? []) ?: 40 }} Kecamatan</strong></span>
                            <span><strong class="text-emerald-700">{{ number_format($totalRtlh ?? 1502, 0, ',', '.') }} RTLH</strong> | <strong class="text-blue-700">{{ number_format($totalBsps ?? 9795, 0, ',', '.') }} BSPS</strong> | <strong class="text-slate-900">{{ number_format($totalAllBnba ?? 11297, 0, ',', '.') }} Total</strong></span>
                        </div>
                    </div>

                    {{-- ================= TABEL 2: SEBARAN RUMAH PER KECAMATAN ================= --}}
                    <div id="panel-tabel-sebaran" class="flex flex-col flex-1 overflow-hidden hidden">
                        {{-- Controls & Filter Bar --}}
                        <div class="p-2.5 px-3 border-b border-slate-100 bg-slate-50/50 space-y-2 shrink-0">
                            <div class="flex items-center justify-between gap-2">
                                <button type="button" onclick="resetToKabupatenOverview()" class="text-[11px] font-bold text-teal-700 hover:text-teal-900 flex items-center gap-1 py-0.5">
                                <span>Semua Kecamatan</span>
                                </button>
                                <div class="flex items-center gap-1" id="filter-program-pills">
                                    <button type="button" onclick="filterSebaranProgram('ALL')" id="pill-filter-all" class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-800 text-white transition-all">Semua</button>
                                    <button type="button" onclick="filterSebaranProgram('RTLH')" id="pill-filter-rtlh" class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700 hover:bg-emerald-100 hover:text-emerald-800 transition-all">RTLH</button>
                                    <button type="button" onclick="filterSebaranProgram('BSPS')" id="pill-filter-bsps" class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700 hover:bg-blue-100 hover:text-blue-800 transition-all">BSPS</button>
                                </div>
                            </div>

                            {{-- Search Input --}}
                            <div class="relative">
                                <input type="text" id="search-sebaran-input" oninput="filterSebaranTable()" placeholder="Cari nama penerima, NIK, desa..." class="w-full text-xs bg-white border border-slate-200 rounded-lg pl-8 pr-3 py-1.5 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 transition-all">
                                <svg class="w-3.5 h-3.5 text-slate-400 absolute left-2.5 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>

                        {{-- Scrollable List Calon Penerima --}}
                        <div class="overflow-y-auto flex-1 divide-y divide-slate-100 bg-slate-50/20">
                            <table class="w-full text-left border-collapse">
                                <tbody id="table-sebaran-body" class="divide-y divide-slate-100">
                                    {{-- Diisi secara dinamis saat kecamatan diklik --}}
                                </tbody>
                            </table>
                        </div>

                        {{-- Footer Panel Sebaran --}}
                        <div class="p-2.5 px-3.5 border-t border-slate-100 bg-slate-50 text-[10px] text-slate-500 flex items-center justify-between shrink-0">
                            <span>Menampilkan <strong id="sebaran-count-text" class="text-slate-800">0</strong> sasaran rumah</span>
                            <span class="text-teal-700 font-semibold" id="sebaran-footer-kec">Kecamatan</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</section>

<script>
    // 1. Data 40 Kecamatan Kabupaten Bogor (Dinamis dari Database dbbedahrumah)
    const dbKecamatan = {!! !empty($daftar40Kecamatan) ? json_encode($daftar40Kecamatan) : 'null' !!};
    const fallbackKecamatan = [
        { no: 1, id_kec: 1, nama: 'CIBINONG', desa: 13, kel: 0, jumlah: 524, rtlh: 54, bsps: 470, lat: -6.473271, lng: 106.853688 },
        { no: 2, id_kec: 2, nama: 'GUNUNG PUTRI', desa: 10, kel: 0, jumlah: 240, rtlh: 30, bsps: 210, lat: -6.423838, lng: 106.940441 },
        { no: 3, id_kec: 3, nama: 'CITEUREUP', desa: 14, kel: 0, jumlah: 310, rtlh: 45, bsps: 265, lat: -6.486906, lng: 106.878721 },
        { no: 4, id_kec: 4, nama: 'SUKARAJA', desa: 13, kel: 0, jumlah: 280, rtlh: 35, bsps: 245, lat: -6.538937, lng: 106.822428 },
        { no: 5, id_kec: 5, nama: 'BABAKAN MADANG', desa: 9, kel: 0, jumlah: 2232, rtlh: 1, bsps: 2231, lat: -6.5825, lng: 106.8834 }
    ];
    // Master data 40 kecamatan
    const daftar40Kecamatan = (dbKecamatan && dbKecamatan.length > 0) ? dbKecamatan : fallbackKecamatan;

    let leafletMap;
    let markersKecamatanLayer;
    let markersSebaranLayer;
    let geoJsonKabLayer = null;
    let geoJsonKecLayer = null;
    let geoJsonKelLayer = null;
    let allKelGeoJsonData = null; // Cache untuk admin_kel.json
    let currentActiveKecamatan = null;
    let currentSebaranData = [];
    let currentSebaranFilterProgram = 'ALL';

    // 2. Inisialisasi Peta Leaflet & Batas Wilayah (Kab, Kec, Kel/Desa)
    function initPetaBedahRumah() {
        if (!document.getElementById('leaflet-map')) return;

        // Inisialisasi Map berpusat di Kabupaten Bogor
        leafletMap = L.map('leaflet-map', {
            zoomControl: true,
            scrollWheelZoom: true
        }).setView([-6.55, 106.82], 10);
        window.leafletMapBogor = leafletMap;

        // OpenStreetMap Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors | Pemkab Bogor'
        }).addTo(leafletMap);

        // Group layer untuk marker titik
        markersKecamatanLayer = L.layerGroup().addTo(leafletMap);
        markersSebaranLayer = L.layerGroup().addTo(leafletMap);

        // Memuat Batas Wilayah GeoJSON dari file public
        loadBatasKabupaten();
        loadBatasKecamatan();

        // Render 1 Titik Ringkas per Kecamatan di Peta
        renderKecamatanSinglePointsOnMap();

        // Render Baris Tabel 40 Kecamatan di panel kanan
        renderKecamatanTableRows();
    }

    // 2.1. Memuat Batas Kabupaten Bogor (admin_kab.json)
    function loadBatasKabupaten() {
        fetch('{{ asset('admin_kab.json') }}')
            .then(res => res.json())
            .then(geoJson => {
                if (geoJsonKabLayer && leafletMap.hasLayer(geoJsonKabLayer)) {
                    leafletMap.removeLayer(geoJsonKabLayer);
                }
                geoJsonKabLayer = L.geoJSON(geoJson, {
                    style: {
                        color: '#0f766e',
                        weight: 2.8,
                        opacity: 0.95,
                        fillColor: '#0f766e',
                        fillOpacity: 0.02,
                        dashArray: '5, 5'
                    }
                });
                const toggle = document.getElementById('layer-toggle-kab');
                if (!toggle || toggle.checked) {
                    geoJsonKabLayer.addTo(leafletMap);
                }
            })
            .catch(err => console.warn('Batas kabupaten tidak dapat dimuat:', err));
    }

    // 2.2. Memuat Batas 40 Kecamatan (admin_kec.json)
    function loadBatasKecamatan() {
        fetch('{{ asset('admin_kec.json') }}')
            .then(res => res.json())
            .then(geoJson => {
                if (geoJsonKecLayer && leafletMap.hasLayer(geoJsonKecLayer)) {
                    leafletMap.removeLayer(geoJsonKecLayer);
                }
                geoJsonKecLayer = L.geoJSON(geoJson, {
                    style: function() {
                        return {
                            color: '#0d9488',
                            weight: 1.5,
                            opacity: 0.85,
                            fillColor: '#14b8a6',
                            fillOpacity: 0.12
                        };
                    },
                    onEachFeature: function(feature, layer) {
                        const ckec = feature.properties.CKEC;
                        const nkec = (feature.properties.NKEC || '').toUpperCase();

                        // Cari data kecamatan yang sesuai
                        const kecData = daftar40Kecamatan.find(k => k.id_kec == ckec || k.nama.replace(/\s+/g, '') === nkec.replace(/\s+/g, ''));
                        const namaKec = kecData ? kecData.nama : nkec;
                        const rtlh = kecData ? kecData.rtlh : 0;
                        const bsps = kecData ? kecData.bsps : 0;
                        const jumlah = kecData ? kecData.jumlah : (rtlh + bsps);

                        // Tooltip modern saat kursor menyentuh poligon kecamatan
                        layer.bindTooltip(`
                            <div style="font-family:'Poppins',sans-serif; min-width:150px; padding:3px 2px;">
                                <div style="font-weight:900; font-size:12px; color:#0f172a; text-transform:uppercase;">
                                    Kec. ${namaKec}
                                </div>
                                <div style="font-size:10px; margin-top:3px; display:flex; align-items:center; gap:6px;">
                                    <span style="color:#059669; font-weight:700;">${rtlh} RTLH</span>
                                    <span style="color:#2563eb; font-weight:700;">${bsps} BSPS</span>
                                    <span style="color:#0f172a; font-weight:800;">${jumlah} Total</span>
                                </div>
                            </div>
                        `, { sticky: true, opacity: 0.95 });

                        // Interaksi Poligon
                        layer.on({
                            mouseover: function(e) {
                                if (currentActiveKecamatan && (currentActiveKecamatan.id_kec == ckec || currentActiveKecamatan.nama.replace(/\s+/g,'') === nkec.replace(/\s+/g,''))) {
                                    return;
                                }
                                const l = e.target;
                                l.setStyle({
                                    weight: 2.5,
                                    color: '#0f172a',
                                    fillColor: '#0d9488',
                                    fillOpacity: 0.35
                                });
                                if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                    l.bringToFront();
                                }
                            },
                            mouseout: function(e) {
                                if (currentActiveKecamatan && (currentActiveKecamatan.id_kec == ckec || currentActiveKecamatan.nama.replace(/\s+/g,'') === nkec.replace(/\s+/g,''))) {
                                    return;
                                }
                                geoJsonKecLayer.resetStyle(e.target);
                            },
                            click: function() {
                                directToKecamatan(namaKec);
                            }
                        });
                    }
                });

                const toggle = document.getElementById('layer-toggle-kec');
                if (!toggle || toggle.checked) {
                    geoJsonKecLayer.addTo(leafletMap);
                }
            })
            .catch(err => console.warn('Batas kecamatan tidak dapat dimuat:', err));
    }

    // 2.3. Memuat Batas Desa / Kelurahan (admin_kel.json)
    function loadBatasKelurahan(targetKecId = null) {
        function applyKelFeatures(geoJson) {
            if (geoJsonKelLayer && leafletMap.hasLayer(geoJsonKelLayer)) {
                leafletMap.removeLayer(geoJsonKelLayer);
                geoJsonKelLayer = null;
            }

            let features = geoJson.features || [];
            if (targetKecId) {
                // Tampilkan hanya desa/kelurahan di kecamatan yang sedang aktif
                features = features.filter(f => f.properties && f.properties.CKEC == targetKecId);
            }

            if (features.length === 0) return;

            geoJsonKelLayer = L.geoJSON({ type: 'FeatureCollection', features: features }, {
                style: {
                    color: '#2563eb',
                    weight: 1.2,
                    opacity: 0.75,
                    fillColor: '#60a5fa',
                    fillOpacity: 0.08,
                    dashArray: '3, 3'
                },
                onEachFeature: function(feature, layer) {
                    const nkel = feature.properties?.NKEL || 'Desa';
                    const nkec = feature.properties?.NKEC || '';
                    layer.bindTooltip(`
                        <div style="font-family:'Poppins',sans-serif; font-size:10px; font-weight:700; color:#1e3a8a;">
                            Desa/Kel. ${nkel} <span style="font-weight:400; color:#64748b;">(${nkec})</span>
                        </div>
                    `, { sticky: true });
                    layer.on({
                        mouseover: function(e) {
                            e.target.setStyle({ weight: 2, color: '#1d4ed8', fillOpacity: 0.25 });
                        },
                        mouseout: function(e) {
                            if (geoJsonKelLayer) geoJsonKelLayer.resetStyle(e.target);
                        }
                    });
                }
            });

            const toggle = document.getElementById('layer-toggle-kel');
            if (targetKecId || (toggle && toggle.checked)) {
                geoJsonKelLayer.addTo(leafletMap);
            }
        }

        if (allKelGeoJsonData) {
            applyKelFeatures(allKelGeoJsonData);
        } else {
            fetch('{{ asset('admin_kel.json') }}')
                .then(res => res.json())
                .then(data => {
                    allKelGeoJsonData = data;
                    applyKelFeatures(data);
                })
                .catch(err => console.warn('Batas kelurahan tidak dapat dimuat:', err));
        }
    }

    // 2.4. Toggle Kontrol Batas Wilayah
    function toggleLayerKabupaten(show) {
        if (!geoJsonKabLayer) return;
        if (show) leafletMap.addLayer(geoJsonKabLayer);
        else leafletMap.removeLayer(geoJsonKabLayer);
    }
    function toggleLayerKecamatan(show) {
        if (!geoJsonKecLayer) return;
        if (show) leafletMap.addLayer(geoJsonKecLayer);
        else leafletMap.removeLayer(geoJsonKecLayer);
    }
    function toggleLayerKelurahan(show) {
        if (show) {
            loadBatasKelurahan(currentActiveKecamatan ? currentActiveKecamatan.id_kec : null);
        } else {
            if (geoJsonKelLayer && leafletMap.hasLayer(geoJsonKelLayer)) {
                leafletMap.removeLayer(geoJsonKelLayer);
                geoJsonKelLayer = null;
            }
        }
    }
    function toggleLayerMarkers(show) {
        if (show) {
            if (currentActiveKecamatan) {
                leafletMap.addLayer(markersSebaranLayer);
            } else {
                leafletMap.addLayer(markersKecamatanLayer);
            }
        } else {
            leafletMap.removeLayer(markersKecamatanLayer);
            leafletMap.removeLayer(markersSebaranLayer);
        }
    }

    // 3. RENDER 1 TITIK RINGKAS PER KECAMATAN (Tidak Menumpuk & Bersih)
    function renderKecamatanSinglePointsOnMap() {
        markersKecamatanLayer.clearLayers();
        markersSebaranLayer.clearLayers();

        daftar40Kecamatan.forEach(kec => {
            const singleKecIcon = L.divIcon({
                className: 'single-kec-marker',
                html: `
                    <div style="cursor: pointer; display: flex; flex-direction: column; align-items: center; transform: translate(-50%, -100%); transition: transform 0.15s ease;" onmouseenter="this.style.transform='translate(-50%, -108%) scale(1.15)'" onmouseleave="this.style.transform='translate(-50%, -100%) scale(1)'">
                        <div style="background: linear-gradient(135deg, #0d9488 0%, #0f766e 100%); color: #ffffff; width: 30px; height: 30px; border-radius: 50%; border: 2.5px solid #ffffff; box-shadow: 0 4px 10px rgba(0,0,0,0.35); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 900; font-family: 'Poppins', sans-serif;">
                            ${kec.jumlah}
                        </div>
                        <div style="background: rgba(15, 23, 42, 0.92); backdrop-filter: blur(4px); color: #ffffff; font-size: 8.5px; font-weight: 800; padding: 1.5px 5.5px; border-radius: 4px; margin-top: 2px; white-space: nowrap; box-shadow: 0 2px 4px rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.2); letter-spacing: 0.2px;">
                            ${kec.nama}
                        </div>
                        <div style="width: 0; height: 0; border-left: 4px solid transparent; border-right: 4px solid transparent; border-top: 5px solid rgba(15, 23, 42, 0.92); margin-top: -1px;"></div>
                    </div>
                `,
                iconSize: [0, 0],
                iconAnchor: [0, 0]
            });

            const marker = L.marker([kec.lat, kec.lng], { icon: singleKecIcon });
            marker.on('click', function() {
                directToKecamatan(kec.nama);
            });

            markersKecamatanLayer.addLayer(marker);
        });
    }

    // 4. DIRECT KE KECAMATAN TERSEBUT & TAMPILKAN SEBARAN TITIK RUMAH
    function directToKecamatan(namaKecamatan) {
        const kec = daftar40Kecamatan.find(k => k.nama.toLowerCase() === namaKecamatan.toLowerCase().trim());
        if (!kec || !leafletMap) return;

        currentActiveKecamatan = kec;

        // 1. Direct Peta & Highlight Poligon Batas Kecamatan
        document.getElementById('peta-wilayah')?.scrollIntoView({ behavior: 'smooth', block: 'start' });

        let targetBounds = null;
        if (geoJsonKecLayer) {
            geoJsonKecLayer.eachLayer(layer => {
                const ckec = layer.feature?.properties?.CKEC;
                const nkec = (layer.feature?.properties?.NKEC || '').replace(/\s+/g,'').toLowerCase();
                const targetNama = kec.nama.replace(/\s+/g,'').toLowerCase();

                if (ckec == kec.id_kec || nkec === targetNama) {
                    layer.setStyle({
                        weight: 3.5,
                        color: '#0f766e',
                        fillColor: '#10b981',
                        fillOpacity: 0.32
                    });
                    if (layer.getBounds && layer.getBounds().isValid()) {
                        targetBounds = layer.getBounds();
                    }
                } else {
                    geoJsonKecLayer.resetStyle(layer);
                }
            });
        }

        if (targetBounds) {
            leafletMap.fitBounds(targetBounds, { padding: [35, 35], maxZoom: 14 });
        } else {
            leafletMap.flyTo([kec.lat, kec.lng], 13.5, { duration: 1.2 });
        }

        // 2. Muat Batas Desa/Kelurahan untuk kecamatan ini
        loadBatasKelurahan(kec.id_kec);

        // 3. Bersihkan layer ringkas kecamatan & siapkan sebaran rumah
        markersKecamatanLayer.clearLayers();
        markersSebaranLayer.clearLayers();

        // 4. Tampilkan Floating Top Banner di Peta
        const activeBar = document.getElementById('map-active-kecamatan-bar');
        if (activeBar) {
            activeBar.classList.remove('hidden');
            activeBar.classList.add('flex');
            document.getElementById('map-active-kec-name').innerText = `Kecamatan ${kec.nama}`;
            document.getElementById('map-active-kec-counts').innerText = `(${kec.rtlh} RTLH • ${kec.bsps} BSPS - Total ${kec.jumlah} Sasaran)`;
        }

        const bottomHint = document.getElementById('map-hint-text');
        if (bottomHint) {
            bottomHint.innerText = `Menampilkan sebaran titik sasaran di Kec. ${kec.nama}. Klik pin rumah untuk melihat detail.`;
        }
        document.getElementById('map-quick-reset')?.classList.remove('hidden');

        // 5. Ambil data asli penerima BNBA dari database via API
        const kecId = kec.id_kec || kec.nama;
        fetch(`{{ url('/api/penerima-kecamatan') }}/${kecId}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.length > 0) {
                    currentSebaranData = data.map((item, i) => {
                        let finalLat = item.lat;
                        let finalLng = item.lng;

                        // Jika titik dari GPS Desa/Kelurahan (karena GPS rumah spesifik di bnba bernilai 0):
                        // Tempatkan di koordinat desa aslinya dengan sebaran mikro berdasarkan ID & RT/RW agar tidak tumpuk di 1 titik
                        if (item.tipe_titik === 'gps_desa' && item.lat && item.lng) {
                            const hash = (parseInt(item.id_bnba) || (i + 1)) * 137 + (parseInt(item.rt) || 0) * 19 + (parseInt(item.rw) || 0) * 7;
                            const angle = (hash % 360) * (Math.PI / 180);
                            const radius = 0.0018 + ((hash % 10) * 0.0004); // Sebaran 150m - 500m di dalam desa tersebut
                            finalLat = item.lat + (Math.sin(angle) * radius * 0.75);
                            finalLng = item.lng + (Math.cos(angle) * radius);
                        } else if (!finalLat || !finalLng) {
                            // Fallback jika desa belum memiliki titik koordinat
                            const angle = (i * 137.5) * (Math.PI / 180);
                            const radius = 0.005 + ((i % 8) * 0.0035);
                            finalLat = kec.lat + (Math.sin(angle) * radius * 0.75);
                            finalLng = kec.lng + (Math.cos(angle) * radius);
                        }

                        const isRtlh = item.program === 'RTLH';
                        return {
                            index: i,
                            program: item.program || (isRtlh ? 'RTLH' : 'BSPS'),
                            color: isRtlh ? '#10b981' : '#2563eb',
                            badgeClass: isRtlh ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-blue-50 text-blue-700 border-blue-200',
                            kode: `${item.program || 'RTLH'}-${kec.nama.substring(0,3).toUpperCase()}-2026-${String(i+1).padStart(3, '0')}`,
                            nama: item.nama,
                            nik: item.nik,
                            desa: item.desa_full || item.desa || '',
                            kondisi: item.alamat || (isRtlh ? 'Program RTLH APBD Kab. Bogor' : 'Program BSPS PUPR Kab. Bogor'),
                            bantuan: isRtlh ? 'Bantuan RTLH APBD' : 'Bantuan BSPS PUPR',
                            status: item.status || 'PERSIAPAN',
                            tipe_titik: item.tipe_titik || 'gps_desa',
                            lat: finalLat,
                            lng: finalLng
                        };
                    });
                } else {
                    currentSebaranData = generateSebaranRumah(kec);
                }
                renderSebaranMarkersOnMap(currentSebaranData);
                switchToSebaranPanel(kec, currentSebaranData);
            })
            .catch(() => {
                currentSebaranData = generateSebaranRumah(kec);
                renderSebaranMarkersOnMap(currentSebaranData);
                switchToSebaranPanel(kec, currentSebaranData);
            });
    }

    // 5. RENDER SEBARAN TITIK RUMAH (Warna RTLH & BSPS Berbeda)
    function renderSebaranMarkersOnMap(dataList) {
        markersSebaranLayer.clearLayers();

        dataList.forEach((house, idx) => {
            const iconImg = house.program === 'RTLH' ? '{{ asset('images/icon-teal-solid.png') }}' : '{{ asset('images/icon-dark-solid.png') }}';
            const badgeBg = house.program === 'RTLH' ? '#065f46' : '#0f172a';

            const housePinIcon = L.divIcon({
                className: 'marker-titik-rumah',
                html: `
                    <div style="cursor: pointer; position: relative; display: flex; flex-direction: column; align-items: center; transform: translate(-50%, -50%); transition: transform 0.15s ease;" onmouseenter="this.style.transform='translate(-50%, -55%) scale(1.15)'" onmouseleave="this.style.transform='translate(-50%, -50%) scale(1)'">
                        <div style="width: 28px; height: 28px; position: relative; display: flex; align-items: center; justify-content: center;">
                            <img src="${iconImg}" alt="${house.program}" style="width: 28px; height: 28px; border-radius: 50%; border: 2px solid #ffffff; box-shadow: 0 4px 10px rgba(0,0,0,0.35); object-fit: contain; display: block;" />
                            <span style="position: absolute; top: -6px; right: -7px; background: ${badgeBg}; color: white; font-size: 7.5px; font-weight: 900; padding: 1px 3.5px; border-radius: 3px; border: 1px solid white; letter-spacing: 0.2px; z-index: 10; box-shadow: 0 2px 4px rgba(0,0,0,0.25);">
                                ${house.program}
                            </span>
                        </div>
                    </div>
                `,
                iconSize: [28, 28],
                iconAnchor: [14, 14]
            });

            const marker = L.marker([house.lat, house.lng], { icon: housePinIcon });

            const popupContent = `
                <div style="min-width: 230px; font-family: 'Poppins', sans-serif;">
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 4px;">
                        <span style="font-size: 9px; font-weight: 800; color: #1e293b; background: #f1f5f9; padding: 2px 6px; border-radius: 4px; border: 1px solid #cbd5e1; text-transform: uppercase;">
                            ${house.kode}
                        </span>
                        <span style="display: inline-block; padding: 2px 7px; border-radius: 12px; font-size: 9px; font-weight: 800; background: ${house.program === 'RTLH' ? '#d1fae5' : '#dbeafe'}; color: ${house.program === 'RTLH' ? '#065f46' : '#1e40af'};">
                            Program ${house.program}
                        </span>
                    </div>

                    <div style="font-size: 14.5px; font-weight: 900; color: #0f172a; margin-top: 4px;">
                        ${house.nama}
                    </div>
                    <div style="font-size: 10px; color: #64748b; font-family: monospace;">
                        NIK: ${house.nik}
                    </div>
                    <div style="font-size: 11px; color: #475569; margin-top: 3px;">
                        📍 ${house.desa}
                    </div>

                    <div style="margin-top: 8px; padding-top: 8px; border-top: 1px solid #e2e8f0; font-size: 11px;">
                        <div style="color: #64748b;">Keterangan / Alamat:</div>
                        <div style="color: #0f766e; font-weight: 700; margin-top: 1px;">${house.kondisi}</div>
                    </div>

                    <div style="margin-top: 8px; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 9.5px; font-weight: 800; color: #f59e0b; background: #fef3c7; padding: 1.5px 6px; border-radius: 4px;">
                            ${house.status}
                        </span>
                        <span style="font-size: 9.5px; font-weight: 700; color: #0d9488; background: #f0fdf4; padding: 1.5px 6px; border-radius: 4px;">
                            ${house.tipe_titik === 'gps_rumah' ? '📍 GPS Rumah' : '📍 ' + (house.desa.split(',')[0] || 'Desa')}
                        </span>
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent);
            markersSebaranLayer.addLayer(marker);
        });

        const toggle = document.getElementById('layer-toggle-marker');
        if (toggle && !toggle.checked) {
            leafletMap.removeLayer(markersSebaranLayer);
        }
    }

    // 6. KEMBALI KE SEMUA KECAMATAN (Reset ke 1 Titik per Kecamatan)
    function resetToKabupatenOverview() {
        currentActiveKecamatan = null;
        currentSebaranData = [];

        // 1. Reset zoom ke seluruh Kabupaten Bogor
        if (leafletMap) {
            leafletMap.flyTo([-6.55, 106.82], 10, { duration: 1.1 });
        }

        // 2. Reset style poligon batas kecamatan
        if (geoJsonKecLayer) {
            geoJsonKecLayer.eachLayer(layer => {
                geoJsonKecLayer.resetStyle(layer);
            });
        }

        // 3. Hapus batas kelurahan kecuali jika user mencentang toggle global batas kelurahan
        const toggleKel = document.getElementById('layer-toggle-kel');
        if (geoJsonKelLayer && (!toggleKel || !toggleKel.checked)) {
            leafletMap.removeLayer(geoJsonKelLayer);
            geoJsonKelLayer = null;
        }

        // 4. Tampilkan kembali 1 titik per kecamatan
        renderKecamatanSinglePointsOnMap();

        // 5. Sembunyikan Floating Bar
        const activeBar = document.getElementById('map-active-kecamatan-bar');
        if (activeBar) {
            activeBar.classList.add('hidden');
            activeBar.classList.remove('flex');
        }

        const bottomHint = document.getElementById('map-hint-text');
        if (bottomHint) {
            bottomHint.innerText = 'Klik wilayah / titik kecamatan di peta atau baris tabel untuk melihat sebaran rumah.';
        }
        document.getElementById('map-quick-reset')?.classList.add('hidden');

        // 6. Kembalikan Panel Tabel ke Rekap 40 Kecamatan
        document.getElementById('panel-tabel-kecamatan').classList.remove('hidden');
        document.getElementById('panel-tabel-sebaran').classList.add('hidden');

        const btnKec = document.getElementById('tab-btn-kecamatan');
        const btnSeb = document.getElementById('tab-btn-sebaran');
        btnKec.className = 'flex-1 py-1.5 px-3 rounded-lg text-xs font-bold transition-all bg-white text-teal-800 shadow-xs';
        btnSeb.className = 'flex-1 py-1.5 px-3 rounded-lg text-xs font-bold transition-all text-slate-400 cursor-not-allowed';
        btnSeb.setAttribute('disabled', 'disabled');
        btnSeb.innerText = 'Sebaran Rumah';

        document.getElementById('panel-title-text').innerText = 'Data 40 Kecamatan';
        document.getElementById('tab-indicator-badge').innerText = '40 Kecamatan';
    }

    // 7. Render Baris Tabel 40 Kecamatan (Dinamis dari Database)
    function renderKecamatanTableRows() {
        const tbody = document.getElementById('table-kecamatan-body');
        if (!tbody) return;

        let html = '';
        daftar40Kecamatan.forEach(row => {
            html += `
                <tr class="hover:bg-teal-50/70 transition-colors cursor-pointer group" onclick="directToKecamatan('${row.nama}')" data-nama="${row.nama.toLowerCase()}">
                    <td class="py-2.5 px-2.5 text-center text-slate-400 font-semibold text-[11px]">
                        ${row.no}
                    </td>
                    <td class="py-2.5 px-2.5 font-extrabold text-slate-800 group-hover:text-teal-800 text-xs">
                        ${row.nama}
                    </td>
                    <td class="py-2.5 px-2 text-center font-bold text-emerald-600 bg-emerald-50/40 text-[11px]">
                        ${row.rtlh.toLocaleString('id-ID')}
                    </td>
                    <td class="py-2.5 px-2 text-center font-bold text-blue-600 bg-blue-50/40 text-[11px]">
                        ${row.bsps.toLocaleString('id-ID')}
                    </td>
                    <td class="py-2.5 px-2.5 text-center font-black text-slate-900 text-xs">
                        ${row.jumlah.toLocaleString('id-ID')}
                    </td>
                    <td class="py-2.5 px-2 text-center">
                        <span class="inline-flex items-center text-[10px] font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded border border-teal-200/70 group-hover:bg-teal-700 group-hover:text-white transition-all">
                            Lihat
                        </span>
                    </td>
                </tr>
            `;
        });
        tbody.innerHTML = html;
    }

    // 8. Fallback Generate Data Sebaran Titik Rumah jika API kosong
    function generateSebaranRumah(kec) {
        const list = [];
        const count = Math.min(kec.jumlah, 50);
        for (let i = 0; i < count; i++) {
            const isRTLH = i < Math.min(kec.rtlh, count / 2);
            const program = isRTLH ? 'RTLH' : 'BSPS';
            const color = isRTLH ? '#10b981' : '#2563eb';
            const badgeClass = isRTLH ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-blue-50 text-blue-700 border-blue-200';

            const angle = (i * 137.5) * (Math.PI / 180);
            const radius = 0.007 + ((i % 5) * 0.004);
            const lat = kec.lat + (Math.sin(angle) * radius * 0.75);
            const lng = kec.lng + (Math.cos(angle) * radius);

            list.push({
                index: i,
                program: program,
                color: color,
                badgeClass: badgeClass,
                kode: `${program}-${kec.nama.substring(0,3).toUpperCase()}-2026-${String(i + 1).padStart(3, '0')}`,
                nama: `Penerima Sasaran ${i + 1}`,
                nik: `3201${String(kec.no).padStart(2, '0')}******${String(1001 + (i * 47)).padStart(4, '0')}`,
                desa: `Desa/Kel. di ${kec.nama}, RT 0${(i % 5) + 1}/RW 0${(i % 4) + 1}`,
                kondisi: isRTLH ? 'Program Bantuan RTLH APBD' : 'Program Bantuan BSPS PUPR',
                bantuan: "Rp 20.000.000",
                status: 'PERSIAPAN',
                lat: lat,
                lng: lng
            });
        }
        return list;
    }

    // 9. Beralih ke Panel Sebaran Rumah pada Tabel Kanan
    function switchToSebaranPanel(kec, houseList) {
        document.getElementById('panel-tabel-kecamatan').classList.add('hidden');
        document.getElementById('panel-tabel-sebaran').classList.remove('hidden');

        const btnKec = document.getElementById('tab-btn-kecamatan');
        const btnSeb = document.getElementById('tab-btn-sebaran');
        btnKec.className = 'flex-1 py-1.5 px-3 rounded-lg text-xs font-bold transition-all text-slate-600 hover:text-slate-900 cursor-pointer';
        btnSeb.className = 'flex-1 py-1.5 px-3 rounded-lg text-xs font-bold transition-all bg-white text-teal-800 shadow-xs cursor-default';
        btnSeb.removeAttribute('disabled');
        btnSeb.innerText = `Sebaran (${kec.nama})`;

        document.getElementById('panel-title-text').innerText = `Sebaran: Kec. ${kec.nama}`;
        document.getElementById('tab-indicator-badge').innerText = `${kec.jumlah} Sasaran`;
        document.getElementById('sebaran-footer-kec').innerText = `Kecamatan ${kec.nama}`;

        filterSebaranProgram('ALL');
    }

    // 10. Render Baris Data Sebaran Rumah di Tabel
    function renderSebaranTableRows(list) {
        const tbody = document.getElementById('table-sebaran-body');
        if (!tbody) return;

        let html = '';
        list.forEach((item, idx) => {
            html += `
                <tr class="hover:bg-teal-50/60 transition-colors group cursor-pointer" onclick="focusHouseMarker(${idx})" data-program="${item.program}">
                    <td class="p-3 align-top">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-1.5 mb-0.5">
                                    <span class="text-[9px] font-extrabold px-1.5 py-0.2 rounded border uppercase tracking-wider ${item.badgeClass}">
                                        ${item.program}
                                    </span>
                                    <span class="text-[9px] font-mono text-slate-400">${item.kode}</span>
                                </div>
                                <div class="text-xs sm:text-[13px] font-extrabold text-slate-800 group-hover:text-teal-800 transition-colors truncate">
                                    ${item.nama}
                                </div>
                                <div class="text-[11px] text-slate-500 mt-0.5 leading-tight truncate">
                                    ${item.desa}
                                </div>
                                <div class="text-[10px] text-slate-400 mt-1 leading-tight">
                                    Keterangan: <span class="text-teal-700 font-semibold">${item.kondisi}</span>
                                </div>
                            </div>
                            <div class="text-right shrink-0 flex flex-col items-end justify-center self-center">
                                <button type="button" onclick="event.stopPropagation(); focusHouseMarker(${idx});" class="inline-flex items-center gap-1 text-[10px] font-bold text-teal-700 hover:text-white hover:bg-teal-700 bg-teal-50 px-2.5 py-1 rounded-md border border-teal-200/80 transition-all shadow-2xs hover:shadow-xs">
                                    <span>📍</span> <span>Fokus</span>
                                </button>
                            </div>
                        </div>
                    </td>
                </tr>
            `;
        });

        if (list.length === 0) {
            html = `
                <tr>
                    <td class="p-6 text-center text-xs text-slate-400">
                        Tidak ada titik sasaran yang cocok dengan pencarian / filter.
                    </td>
                </tr>
            `;
        }

        tbody.innerHTML = html;
        document.getElementById('sebaran-count-text').innerText = list.length;
    }

    // 11. Filter Sebaran Rumah berdasarkan RTLH / BSPS / ALL
    function filterSebaranProgram(program) {
        currentSebaranFilterProgram = program;

        const pillAll = document.getElementById('pill-filter-all');
        const pillRtlh = document.getElementById('pill-filter-rtlh');
        const pillBsps = document.getElementById('pill-filter-bsps');

        if (pillAll) pillAll.className = program === 'ALL' ? 'px-2 py-0.5 rounded text-[10px] font-bold bg-slate-800 text-white transition-all' : 'px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700 hover:bg-slate-300 transition-all';
        if (pillRtlh) pillRtlh.className = program === 'RTLH' ? 'px-2 py-0.5 rounded text-[10px] font-bold bg-emerald-600 text-white transition-all' : 'px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700 hover:bg-emerald-100 hover:text-emerald-800 transition-all';
        if (pillBsps) pillBsps.className = program === 'BSPS' ? 'px-2 py-0.5 rounded text-[10px] font-bold bg-blue-600 text-white transition-all' : 'px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-700 hover:bg-blue-100 hover:text-blue-800 transition-all';

        filterSebaranTable();
    }

    // 12. Filter Input Pencarian Sebaran Rumah
    function filterSebaranTable() {
        const query = (document.getElementById('search-sebaran-input')?.value || '').toLowerCase().trim();
        const filtered = currentSebaranData.filter(house => {
            const matchProg = currentSebaranFilterProgram === 'ALL' || house.program === currentSebaranFilterProgram;
            const matchQuery = !query || house.nama.toLowerCase().includes(query) || house.nik.includes(query) || house.desa.toLowerCase().includes(query) || house.kode.toLowerCase().includes(query);
            return matchProg && matchQuery;
        });

        renderSebaranTableRows(filtered);
        renderSebaranMarkersOnMap(filtered);
    }

    // 13. Fokus ke Marker Rumah Spesifik Saat Baris Diklik
    function focusHouseMarker(idx) {
        const house = currentSebaranData[idx];
        if (!house || !leafletMap) return;

        leafletMap.flyTo([house.lat, house.lng], 15.5, { duration: 0.8 });

        markersSebaranLayer.eachLayer(layer => {
            const latLng = layer.getLatLng();
            if (Math.abs(latLng.lat - house.lat) < 0.0001 && Math.abs(latLng.lng - house.lng) < 0.0001) {
                setTimeout(() => {
                    layer.openPopup();
                }, 900);
            }
        });
    }

    // 14. Filter Input Pencarian Tabel 40 Kecamatan
    function filterKecamatanTable() {
        const q = (document.getElementById('search-kecamatan-input')?.value || '').toLowerCase().trim();
        const rows = document.querySelectorAll('#table-kecamatan-body tr');
        let count = 0;
        rows.forEach(r => {
            const nama = r.getAttribute('data-nama') || '';
            if (!q || nama.includes(q)) {
                r.style.display = '';
                count++;
            } else {
                r.style.display = 'none';
            }
        });
        const badge = document.getElementById('tab-indicator-badge');
        if (badge && !document.getElementById('panel-tabel-kecamatan').classList.contains('hidden')) {
            badge.innerText = `${count} Kecamatan`;
        }
    }

    // Inisialisasi saat DOM siap
    document.addEventListener('DOMContentLoaded', function() {
        initPetaBedahRumah();
        window.addEventListener('resize', function() {
            if (leafletMap) {
                leafletMap.invalidateSize();
            }
        });
    });
</script>
