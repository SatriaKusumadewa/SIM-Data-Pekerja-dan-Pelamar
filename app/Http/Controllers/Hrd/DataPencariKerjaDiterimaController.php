<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\DataPencariKerjaDiterima;
use App\Models\Pelamar;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class DataPencariKerjaDiterimaController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'aktif');

        $query = DataPencariKerjaDiterima::query();

        if ($filter !== 'semua') {
            $query->where('status_karyawan', $filter);
        }

        $dataKaryawan = $query->latest('tgl_masuk')->get();

        return view('hrd.data_karyawan.index', compact('dataKaryawan', 'filter'));
    }

    public function ubahStatus(Request $request, DataPencariKerjaDiterima $karyawan)
    {
        $request->validate([
            'status_karyawan' => ['required', 'in:aktif,resign'],
        ]);

        $karyawan->update([
            'status_karyawan' => $request->status_karyawan,
        ]);

        return redirect()
            ->route('hrd.data-karyawan.index')
            ->with('success', 'Status karyawan berhasil diperbarui.');
    }

    public function create()
    {
        return redirect()
            ->route('hrd.pelamars.index')
            ->with('error', 'Tambah karyawan dilakukan dari pelamar yang sudah diterima.');
    }

    public function store(Request $request)
    {
        return redirect()
            ->route('hrd.pelamars.index')
            ->with('error', 'Gunakan menu Proses pada data pelamar yang sudah diterima.');
    }

    public function createFromPelamar(Pelamar $pelamar)
    {
        if ($pelamar->status_pelamar !== 'diterima') {
            return redirect()
                ->route('hrd.pelamars.show', $pelamar)
                ->with('error', 'Pelamar belum berstatus diterima.');
        }

        $cekKaryawan = DataPencariKerjaDiterima::where('nik', $pelamar->nik)->first();

        if ($cekKaryawan) {
            return redirect()
                ->route('hrd.data-karyawan.index')
                ->with('error', 'Pelamar ini sudah diproses menjadi karyawan.');
        }

        return view('hrd.data_karyawan.proses', compact('pelamar'));
    }

    public function storeFromPelamar(Request $request, Pelamar $pelamar)
    {
        if ($pelamar->status_pelamar !== 'diterima') {
            return redirect()
                ->route('hrd.pelamars.show', $pelamar)
                ->with('error', 'Pelamar belum berstatus diterima.');
        }

        $cekKaryawan = DataPencariKerjaDiterima::where('nik', $pelamar->nik)->first();

        if ($cekKaryawan) {
            return redirect()
                ->route('hrd.data-karyawan.index')
                ->with('success', 'Pelamar ini sudah diproses menjadi karyawan.');
        }

        $validated = $request->validate(
            $this->karyawanRules(),
            $this->karyawanValidationMessages()
        );

        $validated['status_karyawan'] = 'aktif';

        DataPencariKerjaDiterima::create($validated);

        return redirect()
            ->route('hrd.data-karyawan.index')
            ->with('success', 'Pelamar berhasil diproses menjadi karyawan.');
    }

    public function edit(string $nik)
    {
        $karyawan = DataPencariKerjaDiterima::where('nik', $nik)->firstOrFail();

        return view('hrd.data_karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, string $nik)
    {
        $karyawan = DataPencariKerjaDiterima::where('nik', $nik)->firstOrFail();

        $oldNik = $karyawan->nik;

        $validated = $request->validate(
            $this->karyawanRules($oldNik),
            $this->karyawanValidationMessages()
        );

        DB::transaction(function () use ($karyawan, $validated, $oldNik) {
            $karyawan->update($validated);

            if ($oldNik !== $validated['nik']) {
                DB::table('dokumen_pencari_kerja_diterimas')
                    ->where('nik', $oldNik)
                    ->update(['nik' => $validated['nik']]);

                DB::table('users')
                    ->where('nik', $oldNik)
                    ->update(['nik' => $validated['nik']]);
            }
        });

        return redirect()
            ->route('hrd.data-karyawan.index')
            ->with('success', 'Data karyawan berhasil diperbarui.');
    }

    private function getKaryawanUntukReport(string $nik)
    {
        return DataPencariKerjaDiterima::with('dokumen')
            ->where('nik', $nik)
            ->firstOrFail();
    }

    public function cetak(string $nik)
    {
        $karyawan = $this->getKaryawanUntukReport($nik);
        $isPdf = false;

        return view('hrd.data_karyawan.cetak', compact('karyawan', 'isPdf'));
    }

    public function downloadPdf(string $nik)
    {
        $karyawan = $this->getKaryawanUntukReport($nik);
        $isPdf = true;

        $fileName = 'report-karyawan-' . $karyawan->nik . '.pdf';

        return Pdf::loadView('hrd.data_karyawan.cetak', compact('karyawan', 'isPdf'))
            ->setPaper('a4', 'portrait')
            ->download($fileName);
    }

    private function karyawanRules(?string $ignoreNik = null): array
    {
        $nikRule = Rule::unique('data_pencari_kerja_diterimas', 'nik');

        if ($ignoreNik !== null) {
            $nikRule->ignore($ignoreNik, 'nik');
        }

        return [
            'nik' => [
                'required',
                'digits:16',
                $nikRule,
            ],
            'nama_karyawan' => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'string', 'max:20'],
            'tempat_lahir' => ['nullable', 'string', 'max:100'],
            'tgl_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'no_telepon' => ['required', 'digits_between:10,15'],
            'email' => ['nullable', 'email', 'max:100'],
            'jabatan' => ['required', 'string', 'max:100'],
            'divisi' => ['required', 'string', 'max:100'],
            'tgl_masuk' => ['required', 'date'],
            'no_rekening' => ['required', 'digits_between:6,18'],
            'nama_bank' => ['required', 'string', 'max:50'],
        ];
    }

    private function karyawanValidationMessages(): array
    {
        return [
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus berupa angka sebanyak 16 digit.',
            'nik.unique' => 'NIK sudah digunakan oleh karyawan lain.',

            'nama_karyawan.required' => 'Nama karyawan wajib diisi.',
            'nama_karyawan.max' => 'Nama karyawan maksimal 100 karakter.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi.',
            'jenis_kelamin.max' => 'Jenis kelamin maksimal 20 karakter.',

            'tempat_lahir.max' => 'Tempat lahir maksimal 100 karakter.',

            'alamat.max' => 'Alamat maksimal 255 karakter.',

            'no_telepon.required' => 'No telepon wajib diisi.',
            'no_telepon.digits_between' => 'No telepon harus berupa angka dengan panjang 10 sampai 15 digit.',

            'email.email' => 'Format email tidak valid.',
            'email.max' => 'Email maksimal 100 karakter.',

            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.max' => 'Jabatan maksimal 100 karakter.',

            'divisi.required' => 'Divisi wajib diisi.',
            'divisi.max' => 'Divisi maksimal 100 karakter.',

            'tgl_masuk.required' => 'Tanggal masuk wajib diisi.',

            'no_rekening.required' => 'Nomor rekening wajib diisi.',
            'no_rekening.digits_between' => 'Nomor rekening harus berupa angka dengan panjang 6 sampai 18 digit.',

            'nama_bank.required' => 'Nama bank wajib diisi.',
            'nama_bank.max' => 'Nama bank maksimal 50 karakter.',
        ];
    }
}