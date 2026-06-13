<!DOCTYPE html>
<html>
<head>
    <title>{{ $judulLaporan ?? 'Laporan Data Pegawai' }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 10px; color: #333; line-height: 1.4; }
        
        .kop-surat { border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; text-align: center; }
        .kop-surat h3 { margin: 0; text-transform: uppercase; font-size: 14px; letter-spacing: 1px; }
        .kop-surat h2 { margin: 2px 0; font-size: 18px; font-weight: bold; }
        .kop-surat p { margin: 0; font-size: 10px; font-style: italic; color: #666; }

        .judul-laporan { text-align: center; font-size: 12px; font-weight: bold; text-transform: uppercase; margin-bottom: 15px; }

        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background-color: #f2f2f2; border: 1px solid #999; padding: 5px; font-weight: bold; text-align: left; text-transform: uppercase; font-size: 9px; }
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

    <div class="judul-laporan">{{ $judulLaporan ?? 'Laporan Data Pegawai' }}</div>

    <table>
        <thead>
            <tr>
                <th width="3%" class="text-center">No</th>
                <th width="20%">Nama Lengkap</th>
                <th width="14%">NIP</th>
                <th width="10%">Pangkat/Gol</th>
                <th width="15%">Jabatan</th>
                <th width="9%" class="text-center">Status</th>
                <th width="4%" class="text-center">L/P</th>
                <th width="25%">Alamat / Kontak</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $pegawai)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td><strong>{{ $pegawai->nama_final }}</strong></td>
                <td><span class="font-mono">{{ $pegawai->nip_format }}</span></td>
                <td>{{ $pegawai->pangkat_gol ?? '-' }}</td>
                <td>{{ $pegawai->jabatan ?? '-' }}</td>
                <td class="text-center">{{ $pegawai->status_pegawai ?? '-' }}</td>
                <td class="text-center">{{ $pegawai->jenis_kelamin ?? '-' }}</td>
                <td>
                    {{ $pegawai->alamat ?? '-' }}<br>
                    <span style="font-size: 8px; color: #555;">HP: {{ $pegawai->no_hp ?? '-' }}</span>
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