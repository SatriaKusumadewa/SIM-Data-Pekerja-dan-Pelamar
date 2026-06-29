<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Report Karyawan - {{ $karyawan->nama_karyawan ?? '-' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        @page {
            size: A4 portrait;
            margin: 8mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #e5e7eb;
            color: #111827;
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        .action-bar {
            width: 190mm;
            max-width: calc(100% - 32px);
            margin: 20px auto 16px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
        }

        .action-group {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 6px;
            color: #ffffff;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            line-height: 1;
        }

        .btn-gray {
            background: #4b5563;
        }

        .btn-green {
            background: #16a34a;
        }

        .btn-blue {
            background: #2563eb;
        }

        .sheet {
            width: 190mm;
            min-height: auto;
            margin: 0 auto 24px auto;
            background: #ffffff;
            padding: 10mm;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .report-header {
            text-align: center;
            border-bottom: 2px solid #111827;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }

        .report-header h1 {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .report-header p {
            margin: 3px 0 0 0;
            font-size: 10px;
        }

        .report-header h2 {
            margin: 10px 0 0 0;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .print-info {
            width: 100%;
            margin-bottom: 8px;
            font-size: 10px;
        }

        .print-info td {
            padding: 1px 0;
            vertical-align: top;
        }

        .section-title {
            margin-top: 8px;
            margin-bottom: 4px;
            font-size: 11px;
            font-weight: 700;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #d1d5db;
            padding: 3px 5px;
            font-size: 10px;
            line-height: 1.15;
            vertical-align: top;
        }

        .report-table th {
            width: 32%;
            background: #f3f4f6;
            text-align: left;
            font-weight: 700;
        }

        .report-table thead th {
            width: auto;
        }

        .signature {
            margin-top: 10px;
            display: flex;
            justify-content: flex-end;
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .signature-box {
            width: 160px;
            text-align: center;
            font-size: 10px;
        }

        .signature-space {
            height: 24px;
        }

        .pdf-mode {
            background: #ffffff;
            font-size: 10px;
        }

        .pdf-mode .sheet {
            width: 100%;
            min-height: auto;
            margin: 0;
            padding: 0;
            box-shadow: none;
        }

        .pdf-mode .report-table th,
        .pdf-mode .report-table td {
            padding: 3px 5px;
            font-size: 9.5px;
            line-height: 1.1;
        }

        .pdf-mode .section-title {
            margin-top: 7px;
            margin-bottom: 3px;
        }

        .pdf-mode .signature {
            margin-top: 8px;
        }

        .pdf-mode .signature-space {
            height: 20px;
        }

        @media print {
            body {
                background: #ffffff;
            }

            .no-print {
                display: none !important;
            }

            .sheet {
                width: auto;
                min-height: auto;
                margin: 0;
                padding: 0;
                box-shadow: none;
            }

            .report-table th,
            .report-table td {
                padding: 3px 5px;
                font-size: 9.5px;
                line-height: 1.1;
            }

            .section-title {
                margin-top: 7px;
                margin-bottom: 3px;
            }

            .signature {
                margin-top: 8px;
            }

            .signature-space {
                height: 20px;
            }
        }
    </style>
</head>

<body class="{{ ($isPdf ?? false) ? 'pdf-mode' : '' }}">
    @php
        $isPdf = $isPdf ?? false;

        $dokumen = $karyawan->dokumen ?? null;

        $dokumenItems = [
            'KTP' => $dokumen?->ktp_path,
            'Ijazah' => $dokumen?->ijazah_path,
            'Foto' => $dokumen?->foto_path,
            'Buku Rekening' => $dokumen?->buku_rekening_path,
        ];

        $tanggalCetak = now('Asia/Jakarta')->format('d-m-Y H:i');

        $tanggalLahir = $karyawan->tgl_lahir
            ? \Carbon\Carbon::parse($karyawan->tgl_lahir)->format('d-m-Y')
            : '-';

        $tanggalMasuk = $karyawan->tgl_masuk
            ? \Carbon\Carbon::parse($karyawan->tgl_masuk)->format('d-m-Y')
            : '-';

        $dicetakOleh = Auth::user()->name ?? 'HRD';
    @endphp

    @if(! $isPdf)
        <div class="action-bar no-print">
            <a href="{{ route('hrd.data-karyawan.index') }}" class="btn btn-gray">
                Kembali
            </a>

            <div class="action-group">
                <a href="{{ route('hrd.data-karyawan.pdf', $karyawan->nik) }}" class="btn btn-blue">
                    Download PDF
                </a>

                <button type="button" onclick="window.print()" class="btn btn-green">
                    Print Out
                </button>
            </div>
        </div>
    @endif

    <div class="sheet">
        <div class="report-header">
            <h1>Sistem Informasi Sumber Daya Manusia</h1>
            <p>Pelamar dan Pekerja</p>
            <h2>Report Data Karyawan</h2>
        </div>

        <table class="print-info">
            <tr>
                <td style="width: 110px;">Tanggal Cetak</td>
                <td style="width: 12px;">:</td>
                <td>{{ $tanggalCetak }}</td>
            </tr>
            <tr>
                <td>Dicetak Oleh</td>
                <td>:</td>
                <td>{{ $dicetakOleh }}</td>
            </tr>
        </table>

        <div class="section-title">A. Data Identitas Karyawan</div>

        <table class="report-table">
            <tr>
                <th>NIK</th>
                <td>{{ $karyawan->nik ?? '-' }}</td>
            </tr>
            <tr>
                <th>Nama Karyawan</th>
                <td>{{ $karyawan->nama_karyawan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Jenis Kelamin</th>
                <td>{{ $karyawan->jenis_kelamin ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tempat / Tanggal Lahir</th>
                <td>{{ ($karyawan->tempat_lahir ?? '-') . ' / ' . $tanggalLahir }}</td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td>{{ $karyawan->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <th>No Telepon</th>
                <td>{{ $karyawan->no_telepon ?? '-' }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $karyawan->email ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">B. Data Pekerjaan</div>

        <table class="report-table">
            <tr>
                <th>Jabatan</th>
                <td>{{ $karyawan->jabatan ?? '-' }}</td>
            </tr>
            <tr>
                <th>Divisi</th>
                <td>{{ $karyawan->divisi ?? '-' }}</td>
            </tr>
            <tr>
                <th>Tanggal Masuk</th>
                <td>{{ $tanggalMasuk }}</td>
            </tr>
        </table>

        <div class="section-title">C. Data Rekening</div>

        <table class="report-table">
            <tr>
                <th>Nama Bank</th>
                <td>{{ $karyawan->nama_bank ?? '-' }}</td>
            </tr>
            <tr>
                <th>No Rekening</th>
                <td>{{ $karyawan->no_rekening ?? '-' }}</td>
            </tr>
        </table>

        <div class="section-title">D. Kelengkapan Dokumen</div>

        <table class="report-table">
            <thead>
                <tr>
                    <th style="width: 10%;">No</th>
                    <th>Jenis Dokumen</th>
                    <th style="width: 28%;">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dokumenItems as $label => $path)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $label }}</td>
                        <td>{{ !empty($path) ? 'Ada' : 'Belum Ada' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div style="width: 100%; margin-top: 70px;">
            <div style="width: 220px; margin-left: auto; text-align: center;">
                <div style="margin-bottom: 85px;">
                    HRD,
                </div>

                <div style="border-top: 1px solid #000; padding-top: 6px; font-weight: 600;">
                    {{ auth()->user()->name ?? 'hrd' }}
                </div>
            </div>
        </div>
    </div>
</body>
</html>