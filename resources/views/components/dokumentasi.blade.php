{{-- Dokumentasi Kegiatan & Realisasi Bedah Rumah Kabupaten Bogor (Gaya Modern Presisi Kami Mendengar) --}}
<section class="w-full max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 pb-20 scroll-mt-24 page-sheet-reveal" id="dokumentasi">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-6 sm:p-8 lg:p-10">
        
        {{-- Header Dokumentasi --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-6 border-b border-slate-100">
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">
                    Dokumentasi Realisasi Bedah Rumah
                </h2>
            </div>

            @auth
                <div class="shrink-0">
                    <a href="{{ route('admin.posting.create') }}" class="inline-flex items-center gap-1.5 bg-teal-700 hover:bg-teal-800 text-white font-bold px-4 py-2.5 rounded-xl text-xs shadow-xs hover:shadow-md transition-all active:scale-95">
                        <i class="fa-solid fa-plus"></i>
                        <span>Posting Dokumentasi Baru</span>
                    </a>
                </div>
            @endauth
        </div>

        @php
            $modalList = [];
            $postingsData = [];

            if (isset($postings) && $postings->isNotEmpty()) {
                foreach ($postings as $item) {
                    $bnba = $item->bnba;
                    
                    // Kumpulkan foto dari 3 tahap terpisah
                    $photosSebelum = [];
                    for ($i = 1; $i <= 3; $i++) {
                        $f = $item->{"foto_persiapan_{$i}"};
                        if ($f) $photosSebelum[] = [
                            'title' => "Sebelum Renovasi #{$i}",
                            'url' => asset($f),
                            'stage' => 'sebelum',
                            'stage_label' => 'Sebelum Renovasi'
                        ];
                    }

                    $photosPembangunan = [];
                    for ($i = 1; $i <= 3; $i++) {
                        $f = $item->{"foto_pembangunan_{$i}"};
                        if ($f) $photosPembangunan[] = [
                            'title' => "Proses Pembangunan #{$i}",
                            'url' => asset($f),
                            'stage' => 'pembangunan',
                            'stage_label' => 'Proses Pembangunan'
                        ];
                    }

                    $photosSelesai = [];
                    for ($i = 1; $i <= 3; $i++) {
                        $f = $item->{"foto_selesai_{$i}"};
                        if ($f) $photosSelesai[] = [
                            'title' => "Selesai 100% #{$i}",
                            'url' => asset($f),
                            'stage' => 'selesai',
                            'stage_label' => 'Selesai 100%'
                        ];
                    }

                    // Urutan foto total: Selesai -> Pembangunan -> Sebelum
                    $photos = array_merge($photosSelesai, $photosPembangunan, $photosSebelum);
                    $imgUrl = !empty($photosSelesai) 
                        ? $photosSelesai[0]['url'] 
                        : (!empty($photosPembangunan) ? $photosPembangunan[0]['url'] : (!empty($photosSebelum) ? $photosSebelum[0]['url'] : asset('images/hero-bg.png')));

                    $tahapLabel = 'Tahap Persiapan';
                    $tahapCls = 'badge-tahap-persiapan';
                    if (!empty($item->foto_selesai_1)) {
                        $tahapLabel = '100% Selesai Huni';
                        $tahapCls = 'badge-tahap-selesai';
                    } elseif (!empty($item->foto_pembangunan_1)) {
                        $tahapLabel = 'Proses Pembangunan';
                        $tahapCls = 'badge-tahap-proses';
                    }

                    $lokasi = 'Kabupaten Bogor';
                    $rawNama = $item->judul;
                    $programLabel = 'RTLH APBD BOGOR';
                    $programBadgeCls = 'badge-program-rtlh';

                    if ($bnba) {
                        $rawNama = $bnba->name_bnba;
                        $lokasi = 'Desa ' . ($bnba->xkel ?? '-') . ', Kec. ' . ($bnba->xkec ?? '-');
                        if (str_contains(strtoupper($bnba->cat_bnba ?? ''), 'BSPS')) {
                            $programLabel = 'BSPS KEMENPERA';
                            $programBadgeCls = 'badge-program-bsps';
                        }
                    }

                    // Sensor nama penerima & judul di public (1 huruf awal per kata)
                    $namaPenerima = \App\Http\Controllers\HomeController::maskName($rawNama);
                    $judul = \App\Http\Controllers\HomeController::maskTitle($item->judul, $bnba?->name_bnba);

                    $postingsData[] = [
                        'judul' => $judul,
                        'tgl_formatted' => $item->tanggal_posting ? $item->tanggal_posting->translatedFormat('d F Y') : date('d F Y'),
                        'tgl_badge' => $item->tanggal_posting ? $item->tanggal_posting->format('d/m/Y') : date('d/m/Y'),
                        'keterangan' => $item->keterangan,
                        'tim_pelapor' => $item->tim_pelapor ?: 'Petugas Lapangan',
                        'lokasi' => $lokasi,
                        'nama_penerima' => $namaPenerima,
                        'program' => $programLabel,
                        'program_cls' => $programBadgeCls,
                        'tahap_label' => $tahapLabel,
                        'tahap_cls' => $tahapCls,
                        'img_cover' => $imgUrl,
                        'photos' => $photos,
                        'photos_sebelum' => $photosSebelum,
                        'photos_pembangunan' => $photosPembangunan,
                        'photos_selesai' => $photosSelesai,
                        'file_rab' => $item->file_rab ? asset($item->file_rab) : null,
                        'nama_file_rab' => $item->nama_file_rab ?: 'Dokumen RAB',
                        'link_ig' => $item->link_instagram,
                        'link_fb' => $item->link_facebook,
                        'link_tt' => $item->link_tiktok,
                        'link_yt' => $item->link_youtube,
                    ];
                }
            }

            // Batasi tampilan beranda maksimal 10 kartu ke bawah
            $postingsData = array_slice($postingsData, 0, 10);
        @endphp

        {{-- NEWS GRID (4 Kolom / Kartu Berjajar di Layar Desktop) --}}
        <div class="news-grid">
            @forelse ($postingsData as $idx => $card)
                @php
                    $modalList[$idx] = $card;
                @endphp
                <div class="news-card" onclick="openNewsModal({{ $idx }})">
                    
                    {{-- Wrapper Gambar Bersih Tanpa Overlay Gelap Menutupi Foto --}}
                    <div class="card-img-wrapper">
                        <div class="card-img-top-badges">
                            <span class="badge-date">
                                <i class="fa-regular fa-calendar"></i>
                                <span>{{ $card['tgl_badge'] ?? $card['tgl_formatted'] }}</span>
                            </span>

                            <span class="badge-status-tahap {{ $card['tahap_cls'] }}">
                                {{ $card['tahap_label'] }}
                            </span>
                        </div>

                        <img 
                            src="{{ $card['img_cover'] }}" 
                            alt="{{ $card['judul'] }}" 
                            loading="lazy"
                            onerror="this.onerror=null;this.src='{{ asset('images/hero-bg.png') }}';"
                        >
                    </div>

                    {{-- Card Body --}}
                    <div class="card-body">
                        {{-- Badge Program --}}
                        <span class="badge-instansi {{ $card['program_cls'] }}">
                            {{ $card['program'] }}
                        </span>

                        {{-- Judul Kegiatan --}}
                        <h4 class="card-title">{{ $card['judul'] }}</h4>

                        {{-- Lokasi / Wilayah --}}
                        <p class="card-location">
                            <i class="fa-solid fa-location-dot"></i>
                            <span>{{ $card['lokasi'] }}</span>
                        </p>

                        {{-- Badges Kelengkapan Eviden & Dokumen --}}
                        <div class="card-evidences">
                            @if (!empty($card['file_rab']))
                                <span class="badge-evidence badge-pdf">
                                    <i class="fa-solid fa-file-pdf"></i> Dokumen RAB
                                </span>
                            @endif

                            @if (!empty($card['link_ig']))
                                <span class="badge-evidence badge-ig">
                                    <i class="fa-brands fa-instagram"></i> IG
                                </span>
                            @endif

                            @if (!empty($card['link_fb']))
                                <span class="badge-evidence badge-fb">
                                    <i class="fa-brands fa-facebook"></i> FB
                                </span>
                            @endif

                            @if (!empty($card['link_tt']))
                                <span class="badge-evidence badge-tt">
                                    <i class="fa-brands fa-tiktok"></i> TikTok
                                </span>
                            @endif

                            @if (!empty($card['link_yt']))
                                <span class="badge-evidence badge-yt">
                                    <i class="fa-brands fa-youtube"></i> YouTube
                                </span>
                            @endif

                            @if (count($card['photos']) > 0)
                                <span class="badge-evidence badge-foto">
                                    <i class="fa-solid fa-images"></i> {{ count($card['photos']) }} Foto
                                </span>
                            @endif
                        </div>

                        {{-- Cuplikan Deskripsi (Hingga 4 Baris) --}}
                        <p class="card-text">
                            {{ Str::limit($card['keterangan'], 140) }}
                        </p>

                        {{-- Footer Kartu --}}
                        <div class="card-footer-row">
                            <span class="card-reporter">
                                <i class="fa-regular fa-user"></i>
                                <span>{{ $card['tim_pelapor'] }}</span>
                            </span>
                            <span class="card-link">
                                <span>Lihat Kegiatan</span>
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-news">
                    <i class="fa-regular fa-folder-open"></i>
                    <p>Belum ada dokumentasi kegiatan bedah rumah yang dipublikasikan.</p>
                </div>
            @endforelse
        </div>

        {{-- Tombol Lihat Selengkapnya (Pindah Halaman ke /dokumentasi) --}}
        @if (count($postingsData) > 0)
        <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 text-xs text-slate-500">
                <span>Menampilkan <strong class="text-slate-800">{{ count($postingsData) }}</strong> dokumentasi terbaru di Kabupaten Bogor</span>
            </div>
            <a 
                href="{{ route('dokumentasi.index') }}" 
                class="inline-flex items-center gap-2.5 px-6 py-2.5 rounded-xl bg-teal-700 hover:bg-teal-800 active:bg-teal-900 text-white font-bold text-xs sm:text-sm shadow-xs hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5"
            >
                <span>Lihat Selengkapnya</span>
            </a>
        </div>
        @endif

    </div>
</section>

{{-- MODAL DETAIL KEGIATAN PERSIS KAMI MENDENGAR --}}
<div class="modal-overlay" id="newsModal">
    <div class="modal-content">
        <button type="button" class="close-btn" onclick="closeNewsModal()" aria-label="Tutup Detail">&times;</button>
        
        {{-- Preview Gambar Utama Hero --}}
        <div class="modal-img-container">
            <span id="modalActiveStageBadge" class="modal-active-stage-badge" style="display: none;"></span>
            <img src="" alt="Foto Dokumentasi" class="modal-img" id="modalImg" onerror="this.onerror=null;this.src='{{ asset('images/hero-bg.png') }}';">
        </div>

        {{-- Galeri Thumbnail Foto Dokumentasi (Dipisah Kategori: Sebelum, Pembangunan, Selesai) --}}
        <div id="modalGalleryWrapper" class="modal-gallery-wrapper" style="display: none;">
            <div class="modal-gallery-title">
                <i class="fa-solid fa-images"></i>
                <span>Galeri Dokumentasi Foto Pelaksanaan (Klik foto untuk pratinjau):</span>
            </div>
            <div id="modalGalleryStages" class="modal-gallery-stages-container"></div>
        </div>

        {{-- Modal Body --}}
        <div class="modal-body">
            
            {{-- Meta Row dengan Icon --}}
            <div class="modal-meta-row">
                <div class="modal-meta-item">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span id="modalDate"></span>
                </div>
                <div class="modal-meta-item">
                    <i class="fa-solid fa-house-chimney"></i>
                    <span id="modalProgram"></span>
                </div>
                <div class="modal-meta-item">
                    <i class="fa-solid fa-location-dot"></i>
                    <span id="modalLocation"></span>
                </div>
                <div class="modal-meta-item">
                    <i class="fa-regular fa-user"></i>
                    <span id="modalPenerima"></span>
                </div>
                <div class="modal-meta-item">
                    <i class="fa-solid fa-user-pen"></i>
                    <span id="modalActor"></span>
                </div>
            </div>

            {{-- Judul & Deskripsi --}}
            <h2 class="modal-title" id="modalTitle"></h2>
            <div class="modal-desc" id="modalDesc"></div>

            {{-- Dokumen Laporan / RAB --}}
            <div id="modalDocSection" style="margin-top: 18px; margin-bottom: 20px; display: none;">
                <div class="section-sub-title">
                    <i class="fa-solid fa-file-pdf" style="color: #dc2626;"></i>
                    <span>Berkas Dokumen Laporan & RAB:</span>
                </div>
                <div id="modalDocContainer"></div>
            </div>

            {{-- Tautan Media Sosial Resmi --}}
            <div id="modalSosmedSection" class="modal-actions-section" style="margin-top: 20px;">
                <div class="section-sub-title">
                    <i class="fa-solid fa-share-nodes" style="color: #0d9488;"></i>
                    <span>Publikasi Media Sosial Resmi:</span>
                </div>
                <div class="modal-actions" id="modalActions"></div>
            </div>

        </div>
    </div>
</div>

<style>
    /* --- NEWS GRID & CARDS (4 Kolom / Kartu di Desktop, Gaya Presisi Kami Mendengar) --- */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(1, minmax(0, 1fr));
        gap: 18px;
        margin-top: 25px;
    }

    @media (min-width: 640px) {
        .news-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }
    }

    @media (min-width: 1024px) {
        .news-grid {
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 20px;
        }
    }

    .news-card {
        background: #ffffff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        cursor: pointer;
        border: 1px solid #e2e8f0;
        display: flex;
        flex-direction: column;
    }

    .news-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 14px 28px rgba(13, 148, 136, 0.14);
        border-color: #99f6e4;
    }

    .card-img-wrapper {
        position: relative;
        height: 180px;
        overflow: hidden;
        background-color: #f1f5f9;
    }

    .card-img-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.45s ease;
    }

    .news-card:hover .card-img-wrapper img {
        transform: scale(1.07);
    }

    .card-img-top-badges {
        position: absolute;
        top: 10px;
        left: 10px;
        right: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 6px;
        z-index: 5;
        pointer-events: none;
    }

    .badge-date {
        background: rgba(15, 23, 42, 0.78);
        color: #ffffff;
        padding: 3.5px 8px;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 600;
        backdrop-filter: blur(4px);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .badge-status-tahap {
        padding: 3.5px 9px;
        border-radius: 20px;
        font-size: 0.68rem;
        font-weight: 700;
        backdrop-filter: blur(4px);
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .badge-tahap-selesai {
        background: rgba(16, 185, 129, 0.92);
        color: #ffffff;
    }

    .badge-tahap-proses {
        background: rgba(14, 165, 233, 0.92);
        color: #ffffff;
    }

    .badge-tahap-persiapan {
        background: rgba(245, 158, 11, 0.92);
        color: #ffffff;
    }

    .card-body {
        padding: 18px;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .badge-instansi {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 0.7rem;
        font-weight: 700;
        margin-bottom: 8px;
        align-self: flex-start;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .badge-program-rtlh {
        background-color: #f0fdf4;
        color: #047857;
        border: 1px solid #bbf7d0;
    }

    .badge-program-bsps {
        background-color: #f0f9ff;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .card-title {
        font-size: 0.96rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.4;
        margin-bottom: 6px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-location {
        font-size: 0.8rem;
        color: #64748b;
        margin-bottom: 10px;
        font-weight: 500;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .card-location i {
        color: #0d9488;
    }

    .card-evidences {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-bottom: 10px;
    }

    .badge-evidence {
        font-size: 0.7rem;
        font-weight: 600;
        padding: 2.5px 7px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: 3.5px;
    }

    .badge-pdf {
        background-color: #fef2f2;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .badge-ig {
        background-color: #fdf2f8;
        color: #db2777;
        border: 1px solid #fbcfe8;
    }

    .badge-fb {
        background-color: #eff6ff;
        color: #1d4ed8;
        border: 1px solid #bfdbfe;
    }

    .badge-tt {
        background-color: #f8fafc;
        color: #0f172a;
        border: 1px solid #cbd5e1;
    }

    .badge-yt {
        background-color: #fef2f2;
        color: #ef4444;
        border: 1px solid #fca5a5;
    }

    .badge-foto {
        background-color: #f0fdf4;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }

    .card-text {
        font-size: 0.82rem;
        color: #64748b;
        line-height: 1.55;
        margin-bottom: 14px;
        flex: 1;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .card-footer-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: auto;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
        font-size: 0.78rem;
    }

    .card-reporter {
        font-size: 0.76rem;
        color: #94a3b8;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .card-reporter i {
        color: #0d9488;
    }

    .card-link {
        color: #0f766e;
        font-size: 0.84rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: color 0.2s ease;
    }

    .news-card:hover .card-link {
        color: #042f2e;
    }

    .empty-news {
        grid-column: 1 / -1;
        background: #fafafa;
        border: 2px dashed #dedede;
        border-radius: 12px;
        padding: 50px 20px;
        text-align: center;
        color: #64748b;
    }

    .empty-news i {
        font-size: 2.2rem;
        margin-bottom: 10px;
        color: #94a3b8;
    }

    /* --- MODAL POPUP DETAIL (GAYA KAMI MENDENGAR) --- */
    .modal-overlay {
        position: fixed;
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%;
        background: rgba(15, 23, 42, 0.7);
        backdrop-filter: blur(4px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 1000;
        padding: 20px;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background: #ffffff;
        width: 100%;
        max-width: 820px;
        max-height: 90vh;
        border-radius: 16px;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
        animation: modalFadeIn 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .close-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.65);
        color: #ffffff;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
        line-height: 1;
        z-index: 10;
        transition: background-color 0.2s ease, transform 0.2s ease;
    }

    .close-btn:hover {
        background: #0f172a;
        transform: scale(1.05);
    }

    .modal-img {
        width: 100%;
        height: 340px;
        object-fit: cover;
        display: block;
        background-color: #f1f5f9;
    }

    .modal-body {
        padding: 28px;
    }

    .modal-meta-row {
        display: flex;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 16px;
        font-size: 0.85rem;
        color: #64748b;
    }

    .modal-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .modal-meta-item i {
        color: #0d9488;
    }

    .modal-title {
        font-size: 1.35rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 14px;
        line-height: 1.35;
    }

    .modal-desc {
        font-size: 0.92rem;
        color: #475569;
        line-height: 1.7;
        margin-bottom: 24px;
        white-space: pre-line;
    }

    .section-sub-title {
        font-size: 0.84rem;
        font-weight: 700;
        color: #334155;
        text-transform: uppercase;
        letter-spacing: 0.4px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .modal-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .btn-action {
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 0.84rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .btn-social-ig {
        background-color: #E1306C;
        color: #ffffff;
    }
    .btn-social-ig:hover { background-color: #c42459; }

    .btn-social-fb {
        background-color: #1877F2;
        color: #ffffff;
    }
    .btn-social-fb:hover { background-color: #145dbf; }

    .btn-social-tt {
        background-color: #0f172a;
        color: #ffffff;
    }
    .btn-social-tt:hover { background-color: #1e293b; }

    .btn-social-yt {
        background-color: #dc2626;
        color: #ffffff;
    }
    .btn-social-yt:hover { background-color: #b91c1c; }

    .btn-doc-pdf {
        background-color: #dc2626;
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
    }
    .btn-doc-pdf:hover {
        background-color: #b91c1c;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.35);
    }

    .modal-img-container {
        position: relative;
        width: 100%;
        height: 350px;
        background-color: #0f172a;
        overflow: hidden;
    }

    .modal-active-stage-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 700;
        backdrop-filter: blur(6px);
        z-index: 10;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    .modal-gallery-wrapper {
        padding: 14px 28px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
    }

    .modal-gallery-title {
        font-size: 0.76rem;
        font-weight: 700;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .modal-gallery-title i {
        color: #0d9488;
    }

    .modal-gallery-stages-container {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .stage-gallery-block {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    @media (min-width: 640px) {
        .stage-gallery-block {
            flex-direction: row;
            align-items: center;
            gap: 14px;
        }
    }

    .stage-gallery-header {
        display: flex;
        align-items: center;
        gap: 8px;
        min-width: 175px;
        flex-shrink: 0;
    }

    .stage-gallery-badge {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .stage-badge-sebelum {
        background-color: #fef3c7;
        color: #92400e;
        border: 1px solid #fde68a;
    }

    .stage-badge-pembangunan {
        background-color: #e0f2fe;
        color: #0369a1;
        border: 1px solid #bae6fd;
    }

    .stage-badge-selesai {
        background-color: #dcfce7;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .stage-gallery-thumbs {
        display: flex;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 2px;
        align-items: center;
        flex: 1;
    }

    .modal-gallery-thumb {
        width: 58px;
        height: 58px;
        border-radius: 8px;
        object-fit: cover;
        cursor: pointer;
        border: 2px solid #e2e8f0;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .modal-gallery-thumb:hover {
        transform: scale(1.06);
        border-color: #0d9488;
    }

    .modal-gallery-thumb.active {
        border-color: #0d9488;
        box-shadow: 0 0 0 2px rgba(13, 148, 136, 0.4);
        transform: scale(1.06);
    }
</style>

<script>
    window.newsDataList = @json($modalList ?? []);

    function openNewsModal(idx) {
        const data = (window.newsDataList && window.newsDataList[idx]) ? window.newsDataList[idx] : null;
        if (!data) return;

        const modal = document.getElementById('newsModal');
        const modalImg = document.getElementById('modalImg');
        const modalDate = document.getElementById('modalDate');
        const modalProgram = document.getElementById('modalProgram');
        const modalLocation = document.getElementById('modalLocation');
        const modalPenerima = document.getElementById('modalPenerima');
        const modalActor = document.getElementById('modalActor');
        const modalTitle = document.getElementById('modalTitle');
        const modalDesc = document.getElementById('modalDesc');
        const modalGalleryWrapper = document.getElementById('modalGalleryWrapper');
        const modalGalleryStages = document.getElementById('modalGalleryStages');
        const modalActiveStageBadge = document.getElementById('modalActiveStageBadge');
        const modalDocSection = document.getElementById('modalDocSection');
        const modalDocContainer = document.getElementById('modalDocContainer');
        const modalActions = document.getElementById('modalActions');

        modalImg.src = data.img_cover;
        modalDate.innerText = data.tgl_formatted || '';
        modalProgram.innerText = data.program || '';
        modalLocation.innerText = data.lokasi || '';
        modalPenerima.innerText = 'Penerima: ' + (data.nama_penerima || '-');
        modalActor.innerText = 'Pelapor: ' + (data.tim_pelapor || '-');
        modalTitle.innerText = data.judul || '';
        modalDesc.innerText = data.keterangan || '';

        // 1. Galeri Thumbnail Foto Terpisah Kategori (Sebelum, Pembangunan, Selesai)
        modalGalleryStages.innerHTML = '';

        const stagesConfig = [
            {
                key: 'sebelum',
                label: 'Sebelum Renovasi',
                sublabel: 'Persiapan',
                icon: 'fa-solid fa-clock-rotate-left',
                badgeCls: 'stage-badge-sebelum',
                items: data.photos_sebelum || []
            },
            {
                key: 'pembangunan',
                label: 'Proses Pembangunan',
                sublabel: 'Konstruksi',
                icon: 'fa-solid fa-trowel-bricks',
                badgeCls: 'stage-badge-pembangunan',
                items: data.photos_pembangunan || []
            },
            {
                key: 'selesai',
                label: 'Selesai Renovasi',
                sublabel: '100% Siap Huni',
                icon: 'fa-solid fa-circle-check',
                badgeCls: 'stage-badge-selesai',
                items: data.photos_selesai || []
            }
        ];

        let totalPhotos = 0;
        let initialStage = null;

        stagesConfig.forEach(st => {
            if (st.items && st.items.length > 0) {
                totalPhotos += st.items.length;

                // Tentukan info badge untuk cover aktif
                if (!initialStage) {
                    const matchCover = st.items.find(p => p.url === data.img_cover);
                    if (matchCover) {
                        initialStage = { label: matchCover.title || st.label, badgeCls: st.badgeCls, icon: st.icon };
                    }
                }

                const stageBlock = document.createElement('div');
                stageBlock.className = 'stage-gallery-block';

                const headerDiv = document.createElement('div');
                headerDiv.className = 'stage-gallery-header';
                headerDiv.innerHTML = `
                    <span class="stage-gallery-badge ${st.badgeCls}">
                        <i class="${st.icon}"></i>
                        <span>${st.label}</span>
                    </span>
                    <span class="text-[11px] font-bold text-slate-400">${st.items.length} Foto</span>
                `;
                stageBlock.appendChild(headerDiv);

                const thumbsDiv = document.createElement('div');
                thumbsDiv.className = 'stage-gallery-thumbs';

                st.items.forEach((ph, i) => {
                    const thumb = document.createElement('img');
                    thumb.src = ph.url;
                    thumb.alt = ph.title || st.label;
                    thumb.title = ph.title || st.label;
                    thumb.className = `modal-gallery-thumb ${ph.url === data.img_cover ? 'active' : ''}`;
                    thumb.onclick = function() {
                        modalImg.src = ph.url;
                        if (modalActiveStageBadge) {
                            modalActiveStageBadge.style.display = 'inline-flex';
                            modalActiveStageBadge.className = `modal-active-stage-badge ${st.badgeCls}`;
                            modalActiveStageBadge.innerHTML = `<i class="${st.icon}"></i> <span>${ph.title || st.label}</span>`;
                        }
                        document.querySelectorAll('.modal-gallery-thumb').forEach(t => t.classList.remove('active'));
                        thumb.classList.add('active');
                    };
                    thumbsDiv.appendChild(thumb);
                });

                stageBlock.appendChild(thumbsDiv);
                modalGalleryStages.appendChild(stageBlock);
            }
        });

        if (totalPhotos > 0) {
            modalGalleryWrapper.style.display = 'block';
            if (modalActiveStageBadge) {
                if (!initialStage) {
                    const firstAvail = stagesConfig.find(s => s.items.length > 0);
                    if (firstAvail) {
                        initialStage = { label: firstAvail.items[0].title || firstAvail.label, badgeCls: firstAvail.badgeCls, icon: firstAvail.icon };
                    }
                }
                if (initialStage) {
                    modalActiveStageBadge.style.display = 'inline-flex';
                    modalActiveStageBadge.className = `modal-active-stage-badge ${initialStage.badgeCls}`;
                    modalActiveStageBadge.innerHTML = `<i class="${initialStage.icon}"></i> <span>${initialStage.label}</span>`;
                }
            }
        } else {
            modalGalleryWrapper.style.display = 'none';
            if (modalActiveStageBadge) {
                modalActiveStageBadge.style.display = 'none';
            }
        }

        // 2. Berkas Dokumen Laporan / RAB
        modalDocContainer.innerHTML = '';
        if (data.file_rab && data.file_rab.trim() !== '') {
            modalDocSection.style.display = 'block';
            const docBtn = document.createElement('a');
            docBtn.href = data.file_rab;
            docBtn.target = '_blank';
            docBtn.className = 'btn-action btn-doc-pdf';
            docBtn.innerHTML = `<i class="fa-solid fa-file-pdf"></i> Unduh / Buka File RAB (${data.nama_file_rab || 'PDF'})`;
            modalDocContainer.appendChild(docBtn);
        } else {
            modalDocSection.style.display = 'none';
        }

        // 3. Media Sosial (Instagram, Facebook, TikTok, YouTube)
        modalActions.innerHTML = '';
        const sosmed = [
            { label: 'Instagram', url: data.link_ig, icon: 'fa-brands fa-instagram', cls: 'btn-social-ig' },
            { label: 'Facebook', url: data.link_fb, icon: 'fa-brands fa-facebook', cls: 'btn-social-fb' },
            { label: 'TikTok', url: data.link_tt, icon: 'fa-brands fa-tiktok', cls: 'btn-social-tt' },
            { label: 'YouTube', url: data.link_yt, icon: 'fa-brands fa-youtube', cls: 'btn-social-yt' }
        ];

        let countSosmed = 0;
        sosmed.forEach(s => {
            if (s.url && s.url.trim() !== '') {
                countSosmed++;
                const btn = document.createElement('a');
                btn.href = s.url;
                btn.target = '_blank';
                btn.className = `btn-action ${s.cls}`;
                btn.innerHTML = `<i class="${s.icon}"></i> ${s.label}`;
                modalActions.appendChild(btn);
            }
        });

        if (countSosmed === 0) {
            const emptyNotice = document.createElement('span');
            emptyNotice.style.fontSize = '0.82rem';
            emptyNotice.style.color = '#94a3b8';
            emptyNotice.innerText = 'Belum ada tautan media sosial yang dilampirkan.';
            modalActions.appendChild(emptyNotice);
        }

        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    function closeNewsModal() {
        const modal = document.getElementById('newsModal');
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }

    // Tutup modal jika klik di luar box
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('newsModal');
        if (e.target === modal) {
            closeNewsModal();
        }
    });

    // Tutup modal dengan tombol Escape
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeNewsModal();
        }
    });
</script>
