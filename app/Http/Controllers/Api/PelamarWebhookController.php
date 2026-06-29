<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PelamarWebhookController extends Controller
{
    public function store(Request $request)
    {
        Log::info('PELAMAR WEBHOOK MASUK', $request->all());

        $incomingNoTelepon = $this->cleanValue(
            $request->input('no_telepon')
            ?? $request->input('nomor_telepon')
            ?? $request->input('telepon')
            ?? $request->input('hp')
            ?? $request->input('no_hp')
            ?? $request->input('nomor_hp')
            ?? $request->input('no_wa')
            ?? $request->input('nomor_wa')
        );

        if (!$incomingNoTelepon) {
            $incomingNoTelepon = 'Belum diisi';
        }

        $request->merge([
            'no_telepon' => $incomingNoTelepon,
        ]);

        $validated = $request->validate([
            'secret_key' => ['required', 'string'],
            'email' => ['nullable', 'email'],
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', 'string', 'max:50'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tgl_lahir' => ['nullable'],
            'alamat' => ['nullable', 'string'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'pendidikan' => ['nullable', 'string', 'max:255'],
            'posisi_dilamar' => ['nullable', 'string', 'max:255'],
            'scan_ktp' => ['nullable', 'string'],
            'scan_ijazah' => ['nullable', 'string'],
            'foto' => ['nullable', 'string'],
            'cv' => ['nullable', 'string'],
            'tgl_melamar' => ['nullable'],
        ]);

        try {
            if (($validated['secret_key'] ?? null) !== 'rahasia_form_pelamar_123') {
                return response()->json(['message' => 'Secret key tidak valid.'], 403);
            }

            $tglLahir = $this->normalizeDate($validated['tgl_lahir'] ?? null, false);
            $tglMelamar = $this->normalizeDate($validated['tgl_melamar'] ?? null, true);

            $pelamar = Pelamar::updateOrCreate(
                ['nik' => trim($validated['nik'])],
                [
                    'email' => $this->cleanValue($validated['email'] ?? null),
                    'nama' => $this->cleanValue($validated['nama'] ?? null),
                    'jenis_kelamin' => $this->normalizeJenisKelamin($validated['jenis_kelamin'] ?? null),
                    'tempat_lahir' => $this->cleanValue($validated['tempat_lahir'] ?? null),
                    'tgl_lahir' => $tglLahir,
                    'alamat' => $this->cleanValue($validated['alamat'] ?? null),
                    'no_telepon' => $this->cleanValue($validated['no_telepon'] ?? null) ?: 'Belum diisi',
                    'pendidikan' => $this->cleanValue($validated['pendidikan'] ?? null),
                    'posisi_dilamar' => $this->cleanValue($validated['posisi_dilamar'] ?? null),
                    'scan_ktp' => $this->cleanFileValue($validated['scan_ktp'] ?? null),
                    'scan_ijazah' => $this->cleanFileValue($validated['scan_ijazah'] ?? null),
                    'foto' => $this->cleanFileValue($validated['foto'] ?? null),
                    'cv' => $this->cleanFileValue($validated['cv'] ?? null),
                    'tgl_melamar' => $tglMelamar ?? now()->toDateString(),
                    'status_pelamar' => 'diproses',
                ]
            );

            Log::info('PELAMAR WEBHOOK BERHASIL DISIMPAN', [
                'id' => $pelamar->id,
                'nik' => $pelamar->nik,
                'nama' => $pelamar->nama,
            ]);

            return response()->json([
                'message' => 'Data pelamar berhasil disimpan.',
                'data' => $pelamar,
            ], 201);

        } catch (\Throwable $e) {
            Log::error('PELAMAR WEBHOOK GAGAL DISIMPAN', [
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
                'payload' => $request->all(),
            ]);

            return response()->json([
                'message' => 'Webhook gagal diproses.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    private function cleanValue($value): ?string
    {
        if ($value === null) {
            return null;
        }

        $text = trim((string) $value);
        return $text === '' ? null : $text;
    }

    private function cleanFileValue($value): ?string
    {
        $text = $this->cleanValue($value);
        if (!$text) {
            return null;
        }
        return trim(explode(',', $text)[0]);
    }

    private function normalizeJenisKelamin($value): ?string
    {
        $text = $this->cleanValue($value);
        if (!$text) {
            return null;
        }

        $lower = mb_strtolower($text);

        return match ($lower) {
            'l', 'lk', 'laki laki', 'laki-laki', 'pria', 'male' => 'Laki-laki',
            'p', 'pr', 'perempuan', 'wanita', 'female' => 'Perempuan',
            default => $text,
        };
    }

    private function normalizeDate($value, bool $isAppliedDate = false): ?string
    {
        $text = $this->cleanValue($value);

        if (!$text) {
            return $isAppliedDate ? now()->toDateString() : null;
        }

        if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $text)) {
            if ($text === '1970-01-01') {
                return $isAppliedDate ? now()->toDateString() : null;
            }
            return $text;
        }

        if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})$/', $text, $m)) {
            $day = str_pad($m[1], 2, '0', STR_PAD_LEFT);
            $month = str_pad($m[2], 2, '0', STR_PAD_LEFT);
            $year = $m[3];
            return "{$year}-{$month}-{$day}";
        }

        if (preg_match('/^(\d{1,2})[\/\-](\d{1,2})[\/\-](\d{4})(?:\s+\d{1,2}[:.]\d{1,2}(?:[:.]\d{1,2})?)?$/', $text, $m)) {
            $day = str_pad($m[1], 2, '0', STR_PAD_LEFT);
            $month = str_pad($m[2], 2, '0', STR_PAD_LEFT);
            $year = $m[3];
            return "{$year}-{$month}-{$day}";
        }

        return $isAppliedDate ? now()->toDateString() : null;
    }
}