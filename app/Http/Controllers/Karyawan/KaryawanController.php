<?php

namespace App\Http\Controllers\Karyawan;

use App\Http\Controllers\Controller;
use App\Models\DataPencariKerjaDiterima;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class KaryawanController extends Controller
{
    public function profil()
    {
        $user = Auth::user();

        $karyawan = $this->getKaryawanLogin(false);

        return view('karyawan.profil', compact('karyawan', 'user'));
    }

    public function dokumen()
    {
        $karyawan = $this->getKaryawanLogin(false);
        $dokumen = $karyawan?->dokumen;

        $items = [
            [
                'no' => '01',
                'label' => 'KTP',
                'jenis' => 'ktp',
                'ada' => $this->hasDocument($dokumen, 'ktp_path'),
            ],
            [
                'no' => '02',
                'label' => 'Ijazah',
                'jenis' => 'ijazah',
                'ada' => $this->hasDocument($dokumen, 'ijazah_path'),
            ],
            [
                'no' => '03',
                'label' => 'Foto',
                'jenis' => 'foto',
                'ada' => $this->hasDocument($dokumen, 'foto_path'),
            ],
            [
                'no' => '04',
                'label' => 'Buku Rekening',
                'jenis' => 'buku_rekening',
                'ada' => $this->hasDocument($dokumen, 'buku_rekening_path'),
            ],
        ];

        return view('karyawan.dokumen', compact('karyawan', 'dokumen', 'items'));
    }

    public function preview(string $jenis)
    {
        [$path, $fileName, $mimeType, $downloadName, $label] = $this->resolveDokumenPath($jenis);

        $fileContent = Storage::disk('karyawan_private')->get($path);
        $base64 = base64_encode($fileContent);

        $isPdf = $mimeType === 'application/pdf';
        $isImage = Str::startsWith($mimeType, 'image/');

        return view('karyawan.preview-dokumen', [
            'jenis' => $jenis,
            'label' => $label,
            'fileName' => $fileName,
            'downloadName' => $downloadName,
            'mimeType' => $mimeType,
            'base64' => $base64,
            'isPdf' => $isPdf,
            'isImage' => $isImage,
        ]);
    }

    public function download(string $jenis)
    {
        [$path, $fileName, $mimeType, $downloadName] = $this->resolveDokumenPath($jenis);

        $fullPath = Storage::disk('karyawan_private')->path($path);

        return response()->download($fullPath, $downloadName, [
            'Content-Type' => $mimeType,
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    private function getKaryawanLogin(bool $abortIfMissing = true): ?DataPencariKerjaDiterima
    {
        $user = Auth::user();

        $query = DataPencariKerjaDiterima::with('dokumen');

        if (! empty($user->nik) || ! empty($user->email)) {
            $query->where(function ($q) use ($user) {
                if (! empty($user->nik)) {
                    $q->where('nik', $user->nik);
                }

                if (! empty($user->email)) {
                    $q->orWhere('email', $user->email);
                }
            });
        } else {
            $query->whereRaw('1 = 0');
        }

        $karyawan = $query->first();

        if (! $karyawan && $abortIfMissing) {
            abort(Response::HTTP_NOT_FOUND, 'Data karyawan untuk akun ini tidak ditemukan.');
        }

        return $karyawan;
    }

    private function documentFields(): array
    {
        return [
            'ktp' => 'ktp_path',
            'ijazah' => 'ijazah_path',
            'foto' => 'foto_path',
            'buku_rekening' => 'buku_rekening_path',
        ];
    }

    private function documentLabels(): array
    {
        return [
            'ktp' => 'KTP',
            'ijazah' => 'Ijazah',
            'foto' => 'Foto',
            'buku_rekening' => 'Buku Rekening',
        ];
    }

    private function hasDocument($dokumen, string $field): bool
    {
        if (! $dokumen || empty($dokumen->{$field})) {
            return false;
        }

        $path = $this->normalizePrivatePath((string) $dokumen->{$field});

        return Storage::disk('karyawan_private')->exists($path);
    }

    private function resolveDokumenPath(string $jenis): array
    {
        $karyawan = $this->getKaryawanLogin(true);
        $dokumen = $karyawan->dokumen;

        if (! $dokumen) {
            abort(Response::HTTP_NOT_FOUND, 'Dokumen karyawan belum tersedia.');
        }

        $fields = $this->documentFields();

        if (! array_key_exists($jenis, $fields)) {
            abort(Response::HTTP_NOT_FOUND, 'Jenis dokumen tidak valid.');
        }

        $field = $fields[$jenis];
        $storedPath = $dokumen->{$field} ?? null;

        if (! $storedPath) {
            abort(Response::HTTP_NOT_FOUND, 'File dokumen belum tersedia.');
        }

        $path = $this->normalizePrivatePath((string) $storedPath);

        if (! Storage::disk('karyawan_private')->exists($path)) {
            abort(Response::HTTP_NOT_FOUND, 'File dokumen tidak ditemukan.');
        }

        $mimeType = Storage::disk('karyawan_private')->mimeType($path) ?: 'application/octet-stream';
        $fileName = basename($path);
        $label = $this->documentLabels()[$jenis] ?? 'Dokumen';
        $downloadName = $this->safeDownloadName($karyawan, $label, $fileName, $mimeType);

        return [$path, $fileName, $mimeType, $downloadName, $label];
    }

    private function normalizePrivatePath(string $path): string
    {
        $path = trim($path);

        if ($path === '') {
            abort(Response::HTTP_NOT_FOUND, 'Path dokumen kosong.');
        }

        /*
         * Jangan membuka URL external/public langsung.
         * Ini menjaga dokumen tetap lewat route auth + role.
         */
        if (Str::startsWith($path, ['http://', 'https://'])) {
            abort(Response::HTTP_NOT_FOUND, 'Path dokumen tidak valid.');
        }

        $path = ltrim($path, '/');

        if (Str::startsWith($path, 'storage/')) {
            $path = Str::after($path, 'storage/');
        }

        if (Str::startsWith($path, 'karyawan_private/')) {
            $path = Str::after($path, 'karyawan_private/');
        }

        if (Str::startsWith($path, 'private/')) {
            $path = Str::after($path, 'private/');
        }

        return $path;
    }

    private function safeDownloadName($karyawan, string $label, string $fileName, string $mimeType): string
    {
        $employeeName = Str::slug($karyawan->nama_karyawan ?? Auth::user()->name ?? 'karyawan');
        $labelName = Str::slug($label);

        $extension = pathinfo($fileName, PATHINFO_EXTENSION);

        if (! $extension) {
            $extension = $this->extensionFromMime($mimeType);
        }

        if ($extension) {
            return $labelName . '-' . $employeeName . '.' . $extension;
        }

        return $labelName . '-' . $employeeName;
    }

    private function extensionFromMime(string $mimeType): ?string
    {
        return match ($mimeType) {
            'application/pdf' => 'pdf',
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'application/msword' => 'doc',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
            default => null,
        };
    }
}