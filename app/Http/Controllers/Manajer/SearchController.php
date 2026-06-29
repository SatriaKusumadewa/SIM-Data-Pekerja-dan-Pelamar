<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\DataPencariKerjaDiterima;
use App\Models\Pelamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q'));
        $user = Auth::user();
        $divisi = $this->resolveManagerDivisi($user);

        $dataKaryawan = collect();
        $pelamars = collect();

        if ($q !== '' && $divisi !== '') {
            $keyword = strtolower($q);

            $dataKaryawan = DataPencariKerjaDiterima::query()
                ->whereRaw('LOWER(TRIM(CAST(divisi AS TEXT))) = ?', [strtolower(trim($divisi))])
                ->where(function ($query) use ($keyword) {
                    $query->whereRaw('LOWER(CAST(nama_karyawan AS TEXT)) LIKE ?', ['%' . $keyword . '%'])
                        ->orWhereRaw('LOWER(CAST(email AS TEXT)) LIKE ?', ['%' . $keyword . '%'])
                        ->orWhereRaw('LOWER(CAST(nik AS TEXT)) LIKE ?', ['%' . $keyword . '%'])
                        ->orWhereRaw('LOWER(CAST(jabatan AS TEXT)) LIKE ?', ['%' . $keyword . '%'])
                        ->orWhereRaw('LOWER(CAST(divisi AS TEXT)) LIKE ?', ['%' . $keyword . '%']);
                })
                ->latest()
                ->get();

            $pelamars = Pelamar::query()
                ->where(function ($query) use ($divisi) {
                    $this->applyPelamarDivisiFilter($query, $divisi);
                })
                ->where(function ($query) use ($keyword) {
                    $query->whereRaw('LOWER(CAST(nama AS TEXT)) LIKE ?', ['%' . $keyword . '%'])
                        ->orWhereRaw('LOWER(CAST(email AS TEXT)) LIKE ?', ['%' . $keyword . '%'])
                        ->orWhereRaw('LOWER(CAST(nik AS TEXT)) LIKE ?', ['%' . $keyword . '%'])
                        ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%' . $keyword . '%'])
                        ->orWhereRaw('LOWER(CAST(status_pelamar AS TEXT)) LIKE ?', ['%' . $keyword . '%']);
                })
                ->latest()
                ->get();
        }

        return view('manajer.search.index', compact('q', 'dataKaryawan', 'pelamars', 'divisi'));
    }

    private function resolveManagerDivisi($user): string
    {
        $divisi = DataPencariKerjaDiterima::query()
            ->where(function ($query) use ($user) {
                if (! empty($user->nik)) {
                    $query->where('nik', $user->nik);
                }

                if (! empty($user->email)) {
                    $query->orWhere('email', $user->email);
                }
            })
            ->value('divisi');

        if (! $divisi && ! empty($user->divisi)) {
            $divisi = $user->divisi;
        }

        return trim((string) $divisi);
    }

    private function applyPelamarDivisiFilter($query, string $divisi): void
    {
        $divisiLower = strtolower(trim($divisi));

        $query->where(function ($q) use ($divisiLower) {
            if ($divisiLower === 'hr') {
                $q->whereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%hr%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%hrd%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%human resource%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%recruitment%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%personalia%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%administrasi hr%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%staff hr%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%staff administrasi%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%administrasi%']);
            } elseif ($divisiLower === 'it') {
                $q->whereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%it%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%programmer%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%developer%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%teknisi%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%support%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%staff it%'])
                    ->orWhereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%it support%']);
            } else {
                $q->whereRaw('LOWER(CAST(posisi_dilamar AS TEXT)) LIKE ?', ['%' . $divisiLower . '%']);
            }
        });
    }
}