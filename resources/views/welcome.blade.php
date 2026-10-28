<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="app-html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bedah Rumah • Portal Pelayanan & Peta Sebaran RTLH Kabupaten Bogor</title>
    <meta name="description" content="Sistem Informasi Pelayanan Bedah Rumah dan Pemetaan Sebaran Rumah Tidak Layak Huni (RTLH) Pemerintah Kabupaten Bogor.">

    <!-- Favicon - Lambang Tegar Beriman -->
    <link rel="icon" type="image/svg+xml" href="/images/lambang-kabupaten-bogor.svg">

    <!-- Fonts: Poppins via Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Leaflet CSS & JS for Map -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <!-- Styles / Scripts via Vite -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <!-- Fallback Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Poppins', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
    @endif

    <style>
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 5.5rem;
        }

        body {
            font-family: 'Poppins', sans-serif;
            -webkit-font-smoothing: antialiased;
            background-color: #f8fafc;
        }

        /* Leaflet popup customization */
        .leaflet-popup-content-wrapper {
            border-radius: 14px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15);
            padding: 2px;
            font-family: 'Poppins', sans-serif;
        }
        .leaflet-popup-content {
            margin: 12px 14px;
            line-height: 1.4;
        }
        /* Leaflet tooltip customization */
        .leaflet-tooltip {
            background: rgba(255, 255, 255, 0.96);
            backdrop-filter: blur(4px);
            border: 1px solid rgba(148, 163, 184, 0.4);
            border-radius: 8px;
            box-shadow: 0 6px 16px -2px rgba(0, 0, 0, 0.12);
            padding: 5px 9px;
            font-family: 'Poppins', sans-serif;
        }

        /* Animasi Efek Halaman Meluncur 2 Arah (Bawah & Atas) */
        .page-sheet-reveal {
            opacity: 0;
            transform-origin: center center;
            transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), 
                        transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        /* Muncul dari bawah saat scroll ke bawah */
        .page-sheet-reveal.from-bottom {
            transform: translateY(90px) scale(0.975);
        }

        /* Muncul dari atas saat scroll ke atas */
        .page-sheet-reveal.from-top {
            transform: translateY(-90px) scale(0.975);
        }

        /* Posisi aktif saat berada di layar */
        .page-sheet-reveal.is-visible {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
        }

        /* Staggered Cards for Dokumentasi (2 Arah) */
        .stagger-card {
            opacity: 0;
            transition: opacity 0.65s cubic-bezier(0.16, 1, 0.3, 1), transform 0.65s cubic-bezier(0.16, 1, 0.3, 1);
            will-change: opacity, transform;
        }

        .stagger-card.from-bottom {
            transform: translateY(45px) scale(0.96);
        }

        .stagger-card.from-top {
            transform: translateY(-45px) scale(0.96);
        }

        .stagger-card.is-visible {
            opacity: 1 !important;
            transform: translateY(0) scale(1) !important;
        }

        /* Active Nav Link (Scrollspy) */
        .nav-link-active {
            color: #0f766e !important; /* teal-700 */
            background-color: #f0fdfa !important; /* teal-50 */
            box-shadow: inset 0 0 0 1px rgba(15, 118, 110, 0.2);
        }

        /* Accessible reduced-motion fallback */
        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }
            .page-sheet-reveal,
            .reveal-on-scroll,
            .stagger-card {
                opacity: 1 !important;
                transform: none !important;
                transition: none !important;
            }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col antialiased">

    {{-- 1. Navbar Kabupaten Bogor --}}
    @include('components.navbar')
    {{-- 2. Hero Section + Watermark + 2 Floating Cards --}}
    @include('components.hero-top')

    {{-- 3. Peta Wilayah & Tabel Sebaran RTLH Kab. Bogor (Berdampingan) --}}
    @include('components.peta-wilayah')

    {{-- 4. Dokumentasi Realisasi Bedah Rumah --}}
    @include('components.dokumentasi')

    {{-- Footer Hijau Solid --}}
    <footer class="mt-auto py-8 bg-teal-800 text-teal-100 text-xs border-t border-teal-700">
        <div class="w-full max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2.5">
                <img src="/images/lambang-kabupaten-bogor.svg" alt="Kabupaten Bogor" class="h-6 w-auto drop-shadow-sm">
                <span class="font-bold text-white tracking-wide">BEDAH RUMAH</span>
                <span class="text-teal-200"> Pemerintah Kabupaten Bogor &copy; {{ date('Y') }}</span>
            </div>
            <div class="flex items-center gap-4 text-[11px] font-semibold text-teal-100">
                <a href="#peta-wilayah" class="hover:text-white transition-colors">Peta Wilayah</a>
                <a href="#dokumentasi" class="hover:text-white transition-colors">Dokumentasi</a>
                <a href="#app-html" class="hover:text-white transition-colors">Kembali ke Atas </a>
            </div>
        </div>
    </footer>
    {{-- Floating Back to Top Button --}}
    <button id="btn-back-to-top" 
            type="button" 
            aria-label="Kembali ke Atas"
            class="fixed bottom-6 right-6 z-40 p-3 rounded-full bg-teal-700 text-white shadow-lg shadow-teal-950/20 hover:bg-teal-800 hover:scale-110 active:scale-95 transition-all duration-300 opacity-0 pointer-events-none translate-y-4 flex items-center justify-center group focus:outline-none">
        <svg class="w-5 h-5 transition-transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7"/>
        </svg>
    </button>

    {{-- Script Animasi Scroll Halus & Scroll Reveal --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // 1. Smooth Scrolling dengan offset Navbar dinamis
            function getNavHeight() {
                const nav = document.getElementById('main-navbar') || document.querySelector('nav');
                return nav ? nav.offsetHeight : 80;
            }

            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    const targetId = this.getAttribute('href');
                    if (!targetId || targetId === '#') return;

                    const targetEl = document.querySelector(targetId);
                    if (targetEl) {
                        e.preventDefault();
                        
                        // Buat target sheet langsung visible saat navigasi diklik
                        targetEl.classList.add('is-visible');
                        const sheet = targetEl.classList.contains('page-sheet-reveal') ? targetEl : targetEl.querySelector('.page-sheet-reveal');
                        if (sheet) sheet.classList.add('is-visible');

                        const navHeight = getNavHeight();
                        const elementTop = targetEl.getBoundingClientRect().top + window.pageYOffset;
                        const offsetPosition = Math.max(0, elementTop - navHeight - 16);

                        window.scrollTo({
                            top: offsetPosition,
                            behavior: 'smooth'
                        });

                        if (window.history && window.history.pushState) {
                            window.history.pushState(null, null, targetId);
                        }
                    }
                });
            });

            // 2. Scroll Reveal: Animasi 2 Arah (Scroll ke Bawah & Scroll ke Atas)
            const sheetElements = document.querySelectorAll('.page-sheet-reveal');
            const staggerCards = document.querySelectorAll('.stagger-card');

            // Set state awal
            sheetElements.forEach(el => {
                if (!el.classList.contains('from-top') && !el.classList.contains('from-bottom')) {
                    el.classList.add('from-bottom');
                }
            });
            staggerCards.forEach(card => {
                if (!card.classList.contains('from-top') && !card.classList.contains('from-bottom')) {
                    card.classList.add('from-bottom');
                }
            });

            let lastScrollY = window.pageYOffset || document.documentElement.scrollTop;
            let isTicking = false;

            function checkScrollAnimations() {
                const currentScrollY = window.pageYOffset || document.documentElement.scrollTop;
                const scrollDirection = currentScrollY >= lastScrollY ? 'down' : 'up';
                lastScrollY = currentScrollY;

                const windowHeight = window.innerHeight || document.documentElement.clientHeight;

                sheetElements.forEach(el => {
                    const rect = el.getBoundingClientRect();

                    // Jika elemen masuk ke area pandang aktif
                    if (rect.top <= windowHeight * 0.88 && rect.bottom >= windowHeight * 0.12) {
                        if (!el.classList.contains('is-visible')) {
                            el.classList.add('is-visible');

                            if ((el.id === 'peta-wilayah' || el.closest('#peta-wilayah')) && window.leafletMapBogor) {
                                setTimeout(() => {
                                    window.leafletMapBogor.invalidateSize();
                                }, 350);
                            }
                        }
                    } 
                    // Jika elemen lewat ke atas (di atas layar), siapkan untuk animasi meluncur turun saat scroll ke atas
                    else if (rect.bottom < -60) {
                        el.classList.remove('is-visible');
                        el.classList.remove('from-bottom');
                        el.classList.add('from-top');
                    } 
                    // Jika elemen lewat ke bawah (di bawah layar), siapkan untuk animasi meluncur naik saat scroll ke bawah
                    else if (rect.top > windowHeight + 60) {
                        el.classList.remove('is-visible');
                        el.classList.remove('from-top');
                        el.classList.add('from-bottom');
                    }
                });

                // Kartu Dokumentasi Stagger Cascade (2 Arah)
                staggerCards.forEach(card => {
                    const rect = card.getBoundingClientRect();

                    if (rect.top <= windowHeight * 0.88 && rect.bottom >= windowHeight * 0.12) {
                        if (!card.classList.contains('is-visible')) {
                            const allCards = Array.from(staggerCards);
                            const index = allCards.indexOf(card);
                            const delay = scrollDirection === 'down' 
                                ? (index % 3) * 110 
                                : ((2 - (index % 3)) * 110);

                            setTimeout(() => {
                                card.classList.add('is-visible');
                            }, delay);
                        }
                    } else if (rect.bottom < -60) {
                        card.classList.remove('is-visible');
                        card.classList.remove('from-bottom');
                        card.classList.add('from-top');
                    } else if (rect.top > windowHeight + 60) {
                        card.classList.remove('is-visible');
                        card.classList.remove('from-top');
                        card.classList.add('from-bottom');
                    }
                });

                isTicking = false;
            }

            function onScroll() {
                if (!isTicking) {
                    window.requestAnimationFrame(checkScrollAnimations);
                    isTicking = true;
                }
            }

            window.addEventListener('scroll', onScroll, { passive: true });
            window.addEventListener('resize', onScroll, { passive: true });

            // Initial check on load
            checkScrollAnimations();
            setTimeout(checkScrollAnimations, 120);

            // 3. Scrollspy Navbar & Tombol Back to Top
            const petaSection = document.getElementById('peta-wilayah');
            const dokSection = document.getElementById('dokumentasi');
            const navLinkPeta = document.getElementById('nav-link-peta');
            const navLinkDok = document.getElementById('nav-link-dokumentasi');
            const mobileLinkPeta = document.getElementById('mobile-link-peta');
            const mobileLinkDok = document.getElementById('mobile-link-dokumentasi');
            const backToTopBtn = document.getElementById('btn-back-to-top');
            const navbar = document.getElementById('main-navbar');

            function handleScroll() {
                const scrollY = window.pageYOffset || document.documentElement.scrollTop;
                const navHeight = getNavHeight();

                // Navbar shadow effect on scroll
                if (navbar) {
                    if (scrollY > 20) {
                        navbar.classList.add('shadow-md');
                    } else {
                        navbar.classList.remove('shadow-md');
                    }
                }

                // Tombol Back to Top
                if (backToTopBtn) {
                    if (scrollY > 350) {
                        backToTopBtn.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
                        backToTopBtn.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
                    } else {
                        backToTopBtn.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
                        backToTopBtn.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
                    }
                }

                // Scrollspy active state
                let activeId = null;
                if (dokSection && dokSection.getBoundingClientRect().top <= navHeight + 200) {
                    activeId = 'dokumentasi';
                } else if (petaSection && petaSection.getBoundingClientRect().top <= navHeight + 200) {
                    activeId = 'peta';
                }

                if (navLinkPeta) {
                    navLinkPeta.classList.toggle('nav-link-active', activeId === 'peta');
                }
                if (navLinkDok) {
                    navLinkDok.classList.toggle('nav-link-active', activeId === 'dokumentasi');
                }
                if (mobileLinkPeta) {
                    mobileLinkPeta.classList.toggle('nav-link-active', activeId === 'peta');
                }
                if (mobileLinkDok) {
                    mobileLinkDok.classList.toggle('nav-link-active', activeId === 'dokumentasi');
                }
            }

            window.addEventListener('scroll', handleScroll, { passive: true });
            handleScroll();

            if (backToTopBtn) {
                backToTopBtn.addEventListener('click', function () {
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                });
            }
        });
    </script>
</body>
</html>
