<!DOCTYPE html>
<html>
<head>
    <title>Laporan Data Pimpinan</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11px; color: #333; line-height: 1.4; }
        .kop-surat { border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .kop-surat h3 { margin: 0; text-transform: uppercase; font-size: 14px; letter-spacing: 1px; }
        .kop-surat h2 { margin: 2px 0; font-size: 18px; font-weight: bold; }
        .kop-surat p { margin: 0; font-size: 10px; font-style: italic; color: #666; }
        .judul-laporan { text-align: center; font-size: 13px; font-weight: bold; text-transform: uppercase; margin-bottom: 15px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f2f2f2; border: 1px solid #999; padding: 6px; font-weight: bold; text-align: left; text-transform: uppercase; font-size: 10px; }
        td { border: 1px solid #999; padding: 6px; vertical-align: top; }
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

    <div class="judul-laporan">Daftar Susunan Pimpinan Sekolah</div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="30%">Nama Lengkap & Gelar</th>
                <th width="25%">NIP</th>
                <th width="10%" class="text-center">L/P</th>
                <th width="30%">Kontak & Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $pimpinan)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ $pimpinan->gelar_depan }} {{ $pimpinan->nama_lengkap }} {{ $pimpinan->gelar_belakang }}</strong></td>
                <td><code style="font-size: 11px;">{{ $pimpinan->nip_format }}</code></td>
                <td class="text-center">{{ $pimpinan->jenis_kelamin }}</td>
                <td>{{ $pimpinan->no_hp ?? '-' }} <br> <em>{{ $pimpinan->status_aktif }}</em></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="ttd-container">
        <p>Palu, {{ date('d F Y') }}</p>
        <p>Kepala Dinas Pendidikan & Kebudayaan,</p>
        <div class="ttd-space"></div>
        <p style="text-decoration: underline; font-weight: bold;">Hardi, S.Pd., M.Pd.</p>
        <p>NIP. 19710315 199802 1 004</p>
    </div>

</body>
</html>
