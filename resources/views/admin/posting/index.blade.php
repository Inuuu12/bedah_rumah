@extends('admin.layout')

@section('title', 'Dokumentasi & Berita Progres')
@section('header_title', 'Dokumentasi Publik')
@section('header_subtitle', 'Kelola publikasi foto pengerjaan, RAB, dan progres bedah rumah untuk halaman depan')

@section('content')
<div class="space-y-5">

    {{-- Alert Notifikasi Sukses --}}
    @if (session('status'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-xs font-semibold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('status') }}</span>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-bold">&times;</button>
        </div>
    @endif

    {{-- Alert jika tabel belum dibuat di database --}}
    @if ($tableNotReady)
        <div class="bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-xl text-xs space-y-2 shadow-xs">
            <div class="flex items-center gap-2 font-bold text-amber-900">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>Tabel Database `postings` Belum Diinisialisasi</span>
            </div>
            <p>Jalankan migrasi terlebih dahulu agar fitur dokumentasi dapat menyimpan data ke database.</p>
            <a href="{{ url('/migrate') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-600 hover:bg-amber-700 text-white font-bold transition-all shadow-xs">
                <span>Klik untuk Jalankan Migrasi Otomatis</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    @endif

    {{-- Header Action & Filter --}}
    <div class="bg-white rounded-xl border border-slate-200 p-4 sm:p-5 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        {{-- Search Form --}}
        <form method="GET" action="{{ route('admin.posting.index') }}" class="flex-1 flex flex-wrap sm:flex-nowrap items-center gap-3">
            <div class="relative flex-1 min-w-[200px]">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}" 
                    placeholder="Cari judul berita, keterangan, atau tim pelapor..." 
                    class="w-full text-xs bg-slate-50 border border-slate-300 rounded-lg pl-8 pr-3 py-2 text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500 font-medium"
                >
                <svg class="w-4 h-4 text-slate-400 absolute left-2.5 top-2.5 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <button type="submit" class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-4 py-2 rounded-lg text-xs transition-colors shadow-xs">
                Cari
            </button>
            @if (request()->filled('q'))
                <a href="{{ route('admin.posting.index') }}" class="text-xs text-slate-500 hover:text-slate-800 underline">
                    Reset
                </a>
            @endif
        </form>

        {{-- Tombol Tambah Dokumentasi --}}
        <div>
            <a 
                href="{{ route('admin.posting.create') }}" 
                class="inline-flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2 rounded-lg text-xs shadow-xs hover:shadow-md transition-all active:scale-95"
            >
                <span>Tambah Dokumentasi Baru</span>
            </a>
        </div>
    </div>

    {{-- Tabel Daftar Dokumentasi --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 text-slate-600 border-b border-slate-200 font-bold uppercase tracking-wider text-[11px]">
                        <th class="py-3 px-4 w-12 text-center">No</th>
                        <th class="py-3 px-4">Foto Cuplikan</th>
                        <th class="py-3 px-4 min-w-[220px]">Judul & Keterangan</th>
                        <th class="py-3 px-4 min-w-[180px]">Penerima Usulan BNBA</th>
                        <th class="py-3 px-4 min-w-[150px]">RAB & Tim Pelapor</th>
                        <th class="py-3 px-4">Sosmed</th>
                        <th class="py-3 px-4 text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse ($postings as $index => $item)
                        @php
                            $bnba = $item->bnba;
                            $fotoSampul = $item->foto_selesai_1 
                                ?? $item->foto_pembangunan_1 
                                ?? $item->foto_persiapan_1 
                                ?? null;
                        @endphp
                        <tr class="hover:bg-slate-50/70 transition-colors">
                            {{-- No --}}
                            <td class="py-3 px-4 text-center font-semibold text-slate-500">
                                {{ $postings->firstItem() + $index }}
                            </td>

                            {{-- Foto Cuplikan --}}
                            <td class="py-3 px-4">
                                <div class="w-16 h-14 rounded-lg bg-slate-100 border border-slate-200 overflow-hidden shrink-0 flex items-center justify-center">
                                    @if ($fotoSampul)
                                        <img src="{{ asset($fotoSampul) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    @endif
                                </div>
                                <div class="mt-1 text-[10px] text-slate-400 font-medium">
                                    {{ count($item->fotos_persiapan) + count($item->fotos_pembangunan) + count($item->fotos_selesai) }} Foto
                                </div>
                            </td>

                            {{-- Judul & Keterangan --}}
                            <td class="py-3 px-4">
                                <div class="font-bold text-slate-800 text-xs leading-snug">
                                    {{ $item->judul }}
                                </div>
                                <p class="text-[11px] text-slate-500 line-clamp-2 mt-1 leading-relaxed">
                                    {{ Str::limit($item->keterangan, 120) }}
                                </p>
                                <div class="flex items-center gap-2 mt-1.5 text-[10px] text-slate-400">
                                    <span>📅 {{ $item->tanggal_posting ? $item->tanggal_posting->translatedFormat('d F Y') : '-' }}</span>
                                </div>
                            </td>

                            {{-- Penerima BNBA --}}
                            <td class="py-3 px-4">
                                @if ($bnba)
                                    <div class="font-bold text-slate-800">{{ $bnba->name_bnba }}</div>
                                    <div class="text-[11px] text-emerald-700 font-semibold">{{ $bnba->cat_bnba }}</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">
                                        Desa {{ $bnba->xkel ?? '-' }}, Kec. {{ $bnba->xkec ?? '-' }}
                                    </div>
                                @elseif ($item->id_bnba)
                                    <span class="text-slate-500 font-medium">ID BNBA: #{{ $item->id_bnba }}</span>
                                @else
                                    <span class="text-slate-400 italic">Umum / Tanpa ID BNBA</span>
                                @endif
                            </td>

                            {{-- RAB & Tim Pelapor --}}
                            <td class="py-3 px-4">
                                <div>
                                    <span class="text-[10px] font-bold text-slate-400 uppercase">Pelapor:</span>
                                    <p class="font-semibold text-slate-700">{{ $item->tim_pelapor ?: '-' }}</p>
                                </div>
                                <div class="mt-1">
                                    @if ($item->file_rab)
                                        <a href="{{ asset($item->file_rab) }}" target="_blank" class="inline-flex items-center gap-1 text-[11px] font-bold text-emerald-600 hover:text-emerald-700 hover:underline">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            <span>Lihat File RAB</span>
                                        </a>
                                    @else
                                        <span class="text-[10px] text-slate-400 italic">Tidak ada file RAB</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Sosmed --}}
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1.5">
                                    @if ($item->link_instagram)
                                        <a href="{{ $item->link_instagram }}" target="_blank" title="Instagram" class="w-6 h-6 rounded-full bg-pink-50 text-pink-600 flex items-center justify-center hover:bg-pink-100 transition-colors">
                                            <span class="font-bold text-[10px]">IG</span>
                                        </a>
                                    @endif
                                    @if ($item->link_facebook)
                                        <a href="{{ $item->link_facebook }}" target="_blank" title="Facebook" class="w-6 h-6 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center hover:bg-blue-100 transition-colors">
                                            <span class="font-bold text-[10px]">FB</span>
                                        </a>
                                    @endif
                                    @if ($item->link_tiktok)
                                        <a href="{{ $item->link_tiktok }}" target="_blank" title="TikTok" class="w-6 h-6 rounded-full bg-slate-100 text-slate-900 flex items-center justify-center hover:bg-slate-200 transition-colors">
                                            <span class="font-bold text-[10px]">TT</span>
                                        </a>
                                    @endif
                                    @if ($item->link_youtube)
                                        <a href="{{ $item->link_youtube }}" target="_blank" title="YouTube" class="w-6 h-6 rounded-full bg-red-50 text-red-600 flex items-center justify-center hover:bg-red-100 transition-colors">
                                            <span class="font-bold text-[10px]">YT</span>
                                        </a>
                                    @endif
                                    @if (! $item->link_instagram && ! $item->link_facebook && ! $item->link_tiktok && ! $item->link_youtube)
                                        <span class="text-slate-400 text-[10px] italic">-</span>
                                    @endif
                                </div>
                            </td>

                            {{-- Aksi --}}
                            <td class="py-3 px-4 text-center">
                                <div class="flex items-center justify-center gap-1">
                                    <a 
                                        href="{{ route('admin.posting.edit', $item->id) }}" 
                                        class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-emerald-700 hover:bg-emerald-50 transition-colors"
                                        title="Edit Dokumentasi"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    <form method="POST" action="{{ route('admin.posting.destroy', $item->id) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus dokumentasi ini? Foto dan file terkait akan ikut terhapus.')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="submit" 
                                            class="p-1.5 rounded-lg bg-slate-100 text-slate-600 hover:text-red-700 hover:bg-red-50 transition-colors"
                                            title="Hapus Dokumentasi"
                                        >
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="max-w-sm mx-auto space-y-3">
                                    <div class="w-12 h-12 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <p class="font-bold text-slate-700 text-sm">Belum ada data dokumentasi</p>
                                    <p class="text-xs text-slate-500">Mulai tambahkan publikasi progres pengerjaan bedah rumah, foto renovasi, dan RAB untuk ditampilkan di portal publik.</p>
                                    <div>
                                        <a href="{{ route('admin.posting.create') }}" class="inline-flex items-center gap-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-2 rounded-lg text-xs transition-colors shadow-xs">
                                            <span>Tambah Dokumentasi Pertama</span>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if (! $tableNotReady && $postings->hasPages())
            <div class="p-4 border-t border-slate-200">
                {{ $postings->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

