{{-- Rekapitulasi Sebaran per Kecamatan Persis Sesuai Desain (2 Tabel Kiri-Kanan) --}}
<section class="w-full max-w-7xl mx-auto px-6 sm:px-10 lg:px-16 xl:px-20 pb-20" id="rekap-sebaran-wilayah">
    <div class="bg-white rounded-2xl shadow-xl border border-slate-100 p-4 sm:p-6 lg:p-8">
        
        @php
            $dataKiri = [
                ['no' => 1, 'nama' => 'CIBINONG', 'desa' => 0, 'kel' => 13, 'jumlah' => 13],
                ['no' => 2, 'nama' => 'GUNUNG PUTRI', 'desa' => 10, 'kel' => 0, 'jumlah' => 10],
                ['no' => 3, 'nama' => 'CITEUREUP', 'desa' => 12, 'kel' => 2, 'jumlah' => 14],
                ['no' => 4, 'nama' => 'SUKARAJA', 'desa' => 13, 'kel' => 0, 'jumlah' => 13],
                ['no' => 5, 'nama' => 'BABAKAN MADANG', 'desa' => 9, 'kel' => 0, 'jumlah' => 9],
                ['no' => 6, 'nama' => 'JONGGOL', 'desa' => 14, 'kel' => 0, 'jumlah' => 14],
                ['no' => 7, 'nama' => 'CILEUNGSI', 'desa' => 12, 'kel' => 0, 'jumlah' => 12],
                ['no' => 8, 'nama' => 'CARIU', 'desa' => 10, 'kel' => 0, 'jumlah' => 10],
                ['no' => 9, 'nama' => 'SUKAMAKMUR', 'desa' => 10, 'kel' => 0, 'jumlah' => 10],
                ['no' => 10, 'nama' => 'PARUNG', 'desa' => 9, 'kel' => 0, 'jumlah' => 9],
                ['no' => 11, 'nama' => 'GUNUNG SINDUR', 'desa' => 10, 'kel' => 0, 'jumlah' => 10],
                ['no' => 12, 'nama' => 'KEMANG', 'desa' => 8, 'kel' => 1, 'jumlah' => 9],
                ['no' => 13, 'nama' => 'BOJONG GEDE', 'desa' => 8, 'kel' => 1, 'jumlah' => 9],
                ['no' => 14, 'nama' => 'LEUWILIANG', 'desa' => 11, 'kel' => 0, 'jumlah' => 11],
                ['no' => 15, 'nama' => 'CIAMPEA', 'desa' => 13, 'kel' => 0, 'jumlah' => 13],
                ['no' => 16, 'nama' => 'CIBUNGBULANG', 'desa' => 15, 'kel' => 0, 'jumlah' => 15],
                ['no' => 17, 'nama' => 'PAMIJAHAN', 'desa' => 15, 'kel' => 0, 'jumlah' => 15],
                ['no' => 18, 'nama' => 'RUMPIN', 'desa' => 14, 'kel' => 0, 'jumlah' => 14],
                ['no' => 19, 'nama' => 'JASINGA', 'desa' => 16, 'kel' => 0, 'jumlah' => 16],
                ['no' => 20, 'nama' => 'PARUNG PANJANG', 'desa' => 11, 'kel' => 0, 'jumlah' => 11],
            ];

            $dataKanan = [
                ['no' => 21, 'nama' => 'NANGGUNG', 'desa' => 11, 'kel' => 0, 'jumlah' => 11],
                ['no' => 22, 'nama' => 'CIGUDEG', 'desa' => 15, 'kel' => 0, 'jumlah' => 15],
                ['no' => 23, 'nama' => 'TENJO', 'desa' => 9, 'kel' => 0, 'jumlah' => 9],
                ['no' => 24, 'nama' => 'CIAWI', 'desa' => 13, 'kel' => 0, 'jumlah' => 13],
                ['no' => 25, 'nama' => 'CISARUA', 'desa' => 9, 'kel' => 1, 'jumlah' => 10],
                ['no' => 26, 'nama' => 'MEGAMENDUNG', 'desa' => 12, 'kel' => 0, 'jumlah' => 12],
                ['no' => 27, 'nama' => 'CARINGIN', 'desa' => 12, 'kel' => 0, 'jumlah' => 12],
                ['no' => 28, 'nama' => 'CIJERUK', 'desa' => 9, 'kel' => 0, 'jumlah' => 9],
                ['no' => 29, 'nama' => 'CIOMAS', 'desa' => 10, 'kel' => 1, 'jumlah' => 11],
                ['no' => 30, 'nama' => 'DRAMAGA', 'desa' => 10, 'kel' => 0, 'jumlah' => 10],
                ['no' => 31, 'nama' => 'TAMANSARI', 'desa' => 8, 'kel' => 0, 'jumlah' => 8],
                ['no' => 32, 'nama' => 'KLAPANUNGGAL', 'desa' => 9, 'kel' => 0, 'jumlah' => 9],
                ['no' => 33, 'nama' => 'CISEENG', 'desa' => 10, 'kel' => 0, 'jumlah' => 10],
                ['no' => 34, 'nama' => 'RANCABUNGUR', 'desa' => 7, 'kel' => 0, 'jumlah' => 7],
                ['no' => 35, 'nama' => 'SUKAJAYA', 'desa' => 11, 'kel' => 0, 'jumlah' => 11],
                ['no' => 36, 'nama' => 'TANJUNGSARI', 'desa' => 10, 'kel' => 0, 'jumlah' => 10],
                ['no' => 37, 'nama' => 'TAJURHALANG', 'desa' => 7, 'kel' => 0, 'jumlah' => 7],
                ['no' => 38, 'nama' => 'CIGOMBONG', 'desa' => 9, 'kel' => 0, 'jumlah' => 9],
                ['no' => 39, 'nama' => 'LEUWISADENG', 'desa' => 8, 'kel' => 0, 'jumlah' => 8],
                ['no' => 40, 'nama' => 'TENJOLAYA', 'desa' => 7, 'kel' => 0, 'jumlah' => 7],
            ];
        @endphp

        {{-- Grid 2 Kolom Kiri & Kanan --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">
            
            {{-- TABEL 1 (KIRI: No 1 - 20) --}}
            <div class="overflow-x-auto rounded-xl border border-slate-100 bg-white shadow-xs">
                <table class="w-full text-left text-xs sm:text-sm text-slate-700">
                    <thead class="bg-slate-50/90 text-xs font-bold text-slate-700 uppercase tracking-wider border-b border-slate-100">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 sm:px-5 text-center w-14 font-bold">#</th>
                            <th scope="col" class="py-3.5 px-4 sm:px-5 font-bold">KECAMATAN</th>
                            <th scope="col" class="py-3.5 px-3 sm:px-4 text-center font-bold">KOP. DESA</th>
                            <th scope="col" class="py-3.5 px-3 sm:px-4 text-center font-bold">KOP. KEL</th>
                            <th scope="col" class="py-3.5 px-4 sm:px-5 text-center font-bold">JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($dataKiri as $row)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4 sm:px-5 text-center font-semibold text-slate-500">
                                    {{ $row['no'] }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 font-extrabold text-slate-800 tracking-wide text-xs sm:text-sm">
                                    {{ $row['nama'] }}
                                </td>
                                <td class="py-3 px-3 sm:px-4 text-center font-medium text-slate-600">
                                    {{ $row['desa'] }}
                                </td>
                                <td class="py-3 px-3 sm:px-4 text-center font-medium text-slate-600">
                                    {{ $row['kel'] }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 text-center font-black text-slate-900">
                                    {{ $row['jumlah'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- TABEL 2 (KANAN: No 21 - 40) --}}
            <div class="overflow-x-auto rounded-xl border border-slate-100 bg-white shadow-xs">
                <table class="w-full text-left text-xs sm:text-sm text-slate-700">
                    <thead class="bg-slate-50/90 text-xs font-bold text-slate-700 uppercase tracking-wider border-b border-slate-100">
                        <tr>
                            <th scope="col" class="py-3.5 px-4 sm:px-5 text-center w-14 font-bold">#</th>
                            <th scope="col" class="py-3.5 px-4 sm:px-5 font-bold">KECAMATAN</th>
                            <th scope="col" class="py-3.5 px-3 sm:px-4 text-center font-bold">KOP. DESA</th>
                            <th scope="col" class="py-3.5 px-3 sm:px-4 text-center font-bold">KOP. KEL</th>
                            <th scope="col" class="py-3.5 px-4 sm:px-5 text-center font-bold">JUMLAH</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($dataKanan as $row)
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-3 px-4 sm:px-5 text-center font-semibold text-slate-500">
                                    {{ $row['no'] }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 font-extrabold text-slate-800 tracking-wide text-xs sm:text-sm">
                                    {{ $row['nama'] }}
                                </td>
                                <td class="py-3 px-3 sm:px-4 text-center font-medium text-slate-600">
                                    {{ $row['desa'] }}
                                </td>
                                <td class="py-3 px-3 sm:px-4 text-center font-medium text-slate-600">
                                    {{ $row['kel'] }}
                                </td>
                                <td class="py-3 px-4 sm:px-5 text-center font-black text-slate-900">
                                    {{ $row['jumlah'] }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</section>
