<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Siswa</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        .kop-surat { border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .kop-surat h3 { margin: 0; uppercase; font-size: 14px; }
        .kop-surat h2 { margin: 2px 0; font-size: 18px; font-weight: bold; }
        .kop-surat p { margin: 0; font-size: 10px; font-style: italic; color: #666; }

        .judul-laporan { text-align: center; font-size: 13px; font-weight: bold; uppercase; margin-bottom: 15px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { bg-color: #f2f2f2; border: 1px solid #999; padding: 6px; font-weight: bold; text-align: left; text-transform: uppercase; font-size: 10px; }
        td { border: 1px solid #999; padding: 6px; }
        .text-center { text-align: center; }

        .ttd-container { margin-top: 40px; float: right; width: 200px; text-align: center; }
        .ttd-space { height: 50px; }
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
                <th width="5%" class="text-center">No</th>
                <th width="15%">NISN</th>
                <th width="45%">Nama Lengkap Siswa</th>
                <th width="15%" class="text-center">Kelas</th>
                <th width="20%" class="text-center">Jenis Kelamin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $siswa)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $siswa->nisn }}</td>
                <td><strong>{{ $siswa->nama_lengkap }}</strong></td>
                <td class="text-center">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                <td class="text-center">{{ $siswa->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
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
