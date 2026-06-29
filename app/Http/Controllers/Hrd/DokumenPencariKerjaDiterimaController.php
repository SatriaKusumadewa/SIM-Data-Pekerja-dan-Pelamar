<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\DataPencariKerjaDiterima;
use App\Models\DokumenPencariKerjaDiterima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenPencariKerjaDiterimaController extends Controller
{
    public function index()
    {
        $dataKaryawan = DataPencariKerjaDiterima::with('dokumen')->latest()->get();

        return view('hrd.dokumen_karyawan.index', compact('dataKaryawan'));
    }

    public function create(DataPencariKerjaDiterima $karyawan)
    {
        $dokumen = $karyawan->dokumen;

        return view('hrd.dokumen_karyawan.create', compact('karyawan', 'dokumen'));
    }

    public function store(Request $request, DataPencariKerjaDiterima $karyawan)
    {
        $request->validate([
            'ktp' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'ijazah' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
            'foto' => ['nullable', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
            'buku_rekening' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'],
        ], [
            'ktp.mimes' => 'File KTP harus berformat jpg, jpeg, png, atau pdf.',
            'ijazah.mimes' => 'File ijazah harus berformat jpg, jpeg, png, atau pdf.',
            'foto.mimes' => 'File foto harus berformat jpg, jpeg, atau png.',
            'buku_rekening.mimes' => 'File buku rekening harus berformat jpg, jpeg, png, atau pdf.',
            'ktp.max' => 'Ukuran file KTP maksimal 5 MB.',
            'ijazah.max' => 'Ukuran file ijazah maksimal 5 MB.',
            'foto.max' => 'Ukuran file foto maksimal 5 MB.',
            'buku_rekening.max' => 'Ukuran file buku rekening maksimal 5 MB.',
        ]);

        $dokumen = DokumenPencariKerjaDiterima::firstOrCreate([
            'nik' => $karyawan->nik,
        ]);

        $this->handleUpload($request, $dokumen, 'ktp', $karyawan->nik);
        $this->handleUpload($request, $dokumen, 'ijazah', $karyawan->nik);
        $this->handleUpload($request, $dokumen, 'foto', $karyawan->nik);
        $this->handleUpload($request, $dokumen, 'buku_rekening', $karyawan->nik);

        $dokumen->save();

        return redirect()
            ->route('hrd.dokumen-karyawan.index')
            ->with('success', 'Dokumen karyawan berhasil disimpan.');
    }

    public function preview(string $karyawan, string $jenis)
    {
        [$dokumen, $path, $label, $mimeType, $dataKaryawan] = $this->resolveDokumenPath($karyawan, $jenis);

        return view('hrd.dokumen_karyawan.preview', compact(
            'dokumen',
            'karyawan',
            'jenis',
            'path',
            'label',
            'mimeType',
            'dataKaryawan'
        ));
    }

    public function previewFile(string $karyawan, string $jenis)
    {
        [$dokumen, $path, $label, $mimeType] = $this->resolveDokumenPath($karyawan, $jenis);

        $fullPath = Storage::disk('karyawan_private')->path($path);

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . basename($path) . '"',
        ]);
    }

    private function resolveDokumenPath(string $nikKaryawan, string $jenis): array
    {
        $dataKaryawan = DataPencariKerjaDiterima::with('dokumen')
            ->where('nik', $nikKaryawan)
            ->firstOrFail();

        $dokumen = $dataKaryawan->dokumen;

        if (! $dokumen) {
            abort(404, 'Data dokumen karyawan belum tersedia.');
        }

        $allowedJenis = [
            'ktp' => [
                'field' => 'ktp_path',
                'label' => 'KTP',
            ],
            'ijazah' => [
                'field' => 'ijazah_path',
                'label' => 'Ijazah',
            ],
            'foto' => [
                'field' => 'foto_path',
                'label' => 'Foto',
            ],
            'buku_rekening' => [
                'field' => 'buku_rekening_path',
                'label' => 'Buku Rekening',
            ],
        ];

        if (! array_key_exists($jenis, $allowedJenis)) {
            abort(404, 'Jenis dokumen tidak valid.');
        }

        $field = $allowedJenis[$jenis]['field'];
        $label = $allowedJenis[$jenis]['label'];

        $path = $dokumen->{$field};

        if (empty($path)) {
            abort(404, 'Dokumen belum tersedia.');
        }

        $path = str_replace('\\', '/', $path);
        $path = str_replace('storage/', '', $path);
        $path = str_replace('public/', '', $path);
        $path = ltrim($path, '/');

        if (! Storage::disk('karyawan_private')->exists($path)) {
            abort(404, 'File dokumen tidak ditemukan di storage private karyawan.');
        }

        $mimeType = Storage::disk('karyawan_private')->mimeType($path);

        return [$dokumen, $path, $label, $mimeType, $dataKaryawan];
    }

    public function download(DokumenPencariKerjaDiterima $dokumen, string $jenis)
    {
        $allowed = ['ktp', 'ijazah', 'foto', 'buku_rekening'];

        if (! in_array($jenis, $allowed, true)) {
            abort(404, 'Jenis dokumen tidak valid.');
        }

        $pathField = $jenis . '_path';
        $nameField = $jenis . '_original_name';

        $path = $dokumen->{$pathField};

        if (! $path || ! Storage::disk('karyawan_private')->exists($path)) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        return Storage::disk('karyawan_private')->download(
            $path,
            $dokumen->{$nameField} ?? basename($path)
        );
    }

    private function handleUpload(Request $request, DokumenPencariKerjaDiterima $dokumen, string $field, string $folderKey): void
    {
        if (! $request->hasFile($field)) {
            return;
        }

        $oldPathField = $field . '_path';

        if ($dokumen->{$oldPathField} && Storage::disk('karyawan_private')->exists($dokumen->{$oldPathField})) {
            Storage::disk('karyawan_private')->delete($dokumen->{$oldPathField});
        }

        $file = $request->file($field);

        $path = $file->store("{$folderKey}/{$field}", 'karyawan_private');

        $dokumen->{$field . '_path'} = $path;
        $dokumen->{$field . '_original_name'} = $file->getClientOriginalName();
        $dokumen->{$field . '_mime'} = $file->getClientMimeType();
    }
}