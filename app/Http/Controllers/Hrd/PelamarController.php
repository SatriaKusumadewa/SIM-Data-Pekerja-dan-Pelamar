<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PelamarController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'aktif');

        $query = Pelamar::query();

        if ($filter === 'arsip') {
            $query->where('is_arsip', true);
        } else {
            $query->where('is_arsip', false);
        }

        $pelamars = $query->latest()->get();

        return view('hrd.pelamars.index', compact('pelamars', 'filter'));
    }

    public function arsip(Pelamar $pelamar)
    {
        $pelamar->update([
            'is_arsip' => true,
        ]);

        return redirect()
            ->route('hrd.pelamars.index')
            ->with('success', 'Data pelamar berhasil diarsipkan.');
    }

    public function pulihkan(Pelamar $pelamar)
    {
        $pelamar->update([
            'is_arsip' => false,
        ]);

        return redirect()
            ->route('hrd.pelamars.index', ['filter' => 'arsip'])
            ->with('success', 'Data pelamar berhasil dipulihkan.');
    }

    public function show(Pelamar $pelamar)
    {
        return view('hrd.pelamars.show', compact('pelamar'));
    }

    public function edit(Pelamar $pelamar)
    {
        return view('hrd.pelamars.edit', compact('pelamar'));
    }

    public function update(Request $request, Pelamar $pelamar)
    {
        $validated = $request->validate([
            'nik' => ['required', 'string', 'max:255'],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['nullable', 'string', 'max:50'],
            'tempat_lahir' => ['nullable', 'string', 'max:255'],
            'tgl_lahir' => ['nullable', 'date'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'pendidikan' => ['required', 'string', 'max:255'],
            'posisi_dilamar' => ['required', 'string', 'max:255'],
            'tgl_melamar' => ['nullable', 'date'],
            'status_pelamar' => ['required', 'in:diproses,diterima,ditolak'],
        ]);

        $pelamar->update($validated);

        return redirect()
            ->route('hrd.pelamars.show', $pelamar)
            ->with('success', 'Data pelamar berhasil diperbarui.');
    }

    public function previewDokumen(Pelamar $pelamar, string $jenis)
    {
        $field = $this->mapDokumenField($jenis);
        $value = $pelamar->{$field} ?? null;

        if (!$value) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        if ($this->isExternalUrl($value)) {
            return redirect()->away($this->buildPreviewUrl($value));
        }

        if (!Storage::disk('public')->exists($value)) {
            abort(404, 'File dokumen tidak ditemukan.');
        }

        return response()->file(Storage::disk('public')->path($value));
    }

    public function downloadDokumen(Pelamar $pelamar, string $jenis)
    {
        $field = $this->mapDokumenField($jenis);
        $value = $pelamar->{$field} ?? null;

        if (!$value) {
            abort(404, 'Dokumen tidak ditemukan.');
        }

        if ($this->isExternalUrl($value)) {
            return redirect()->away($this->buildDownloadUrl($value));
        }

        if (!Storage::disk('public')->exists($value)) {
            abort(404, 'File dokumen tidak ditemukan.');
        }

        return Storage::disk('public')->download($value, basename($value));
    }

    private function mapDokumenField(string $jenis): string
    {
        return match ($jenis) {
            'ktp' => 'scan_ktp',
            'ijazah' => 'scan_ijazah',
            'foto' => 'foto',
            'cv' => 'cv',
            default => abort(404, 'Jenis dokumen tidak valid.'),
        };
    }

    private function isExternalUrl(?string $value): bool
    {
        return filled($value) && filter_var($value, FILTER_VALIDATE_URL);
    }

    private function buildPreviewUrl(string $url): string
    {
        $id = $this->extractGoogleDriveId($url);

        if ($id) {
            return "https://drive.google.com/file/d/{$id}/view";
        }

        return $url;
    }

    private function buildDownloadUrl(string $url): string
    {
        $id = $this->extractGoogleDriveId($url);

        if ($id) {
            return "https://drive.google.com/uc?export=download&id={$id}";
        }

        return $url;
    }

    private function extractGoogleDriveId(string $url): ?string
    {
        if (preg_match('#/file/d/([^/]+)#', $url, $matches)) {
            return $matches[1];
        }

        if (preg_match('/[?&]id=([^&]+)/', $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}