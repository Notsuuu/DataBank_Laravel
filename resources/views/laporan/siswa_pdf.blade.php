<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Siswa</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; color: #333; line-height: 1.4; }
        
        .kop-surat { border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .kop-surat h3 { margin: 0; text-transform: uppercase; font-size: 14px; letter-spacing: 1px; }
        .kop-surat h2 { margin: 2px 0; font-size: 18px; font-weight: bold; }
        .kop-surat p { margin: 0; font-size: 10px; font-style: italic; color: #666; }

        .judul-laporan { text-align: center; font-size: 12px; font-weight: bold; text-transform: uppercase; margin-bottom: 15px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f2f2f2; border: 1px solid #999; padding: 5px; font-weight: bold; text-align: center; text-transform: uppercase; font-size: 9px; }
        td { border: 1px solid #999; padding: 5px; vertical-align: top; }
        .text-center { text-align: center; }

        .ttd-container { margin-top: 40px; float: right; width: 200px; text-align: center; }
        .ttd-space { height: 50px; }
        
        .font-mono { font-family: monospace; font-size: 9px; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <h3>Pemerintah Kota Palu</h3>
        <h2>SMP Negeri 4 Palu</h2>
        <p>Jl. Cinta Nomor 4, Palu, Sulawesi Tengah. Telp: (0451) 123456</p>
    </div>

    <div class="judul-laporan">Daftar Rekapitulasi Data Siswa Aktif</div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="12%">NIS / NISN</th>
                <th width="20%">Nama Lengkap</th>
                <th width="5%">L/P</th>
                <th width="8%">Kelas</th>
                <th width="17%">Tempat, Tgl Lahir</th>
                <th width="18%">Kontak & Alamat</th>
                <th width="17%">Orang Tua / Wali</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $siswa)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <span class="font-mono">NIS: {{ $siswa->nis ?? '-' }}</span><br>
                    <span class="font-mono">NISN: {{ $siswa->nisn ?? '-' }}</span>
                </td>
                <td><strong>{{ $siswa->nama_lengkap }}</strong></td>
                <td class="text-center">{{ $siswa->jenis_kelamin }}</td>
                <td class="text-center">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>
                    {{ $siswa->tempat_lahir ?? '-' }},<br>
                    {{ $siswa->tanggal_lahir ? \Carbon\Carbon::parse($siswa->tanggal_lahir)->format('d-m-Y') : '-' }}
                </td>
                <td>
                    HP: {{ $siswa->no_hp_siswa ?? $siswa->no_hp_wali ?? '-' }}<br>
                    <span style="font-size: 8px; color: #555;">{{ $siswa->alamat ?? '-' }}</span>
                </td>
                <td>
                    <span style="font-size: 8px;">
                        A: {{ $siswa->nama_ayah ?? '-' }}<br>
                        I: {{ $siswa->nama_ibu ?? '-' }}<br>
                        W: {{ $siswa->nama_wali ?? '-' }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd-container">
        <p>Palu, {{ date('d F Y') }}</p>
        <p>Kepala Sekolah,</p>
        <div class="ttd-space"></div>
        <p style="text-decoration: underline; font-weight: bold;">Nama Kepala Sekolah, M.Pd</p>
        <p>NIP. 19800101 200501 1 001</p>
    </div>

</body>
</html>