<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\DataPencariKerjaDiterima;
use App\Models\Pelamar;
use Illuminate\Support\Facades\Auth;

class DataPelamarController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $divisi = $this->resolveManagerDivisi($user);

        $pelamars = collect();

        if ($divisi !== '') {
            $pelamars = Pelamar::query()
                ->where(function ($query) use ($divisi) {
                    $this->applyPelamarDivisiFilter($query, $divisi);
                })
                ->latest()
                ->get();
        }

        return view('manajer.data_pelamar.index', compact('pelamars', 'divisi'));
    }

    public function show(string $pelamar)
    {
        $user = Auth::user();
        $divisi = $this->resolveManagerDivisi($user);

        if ($divisi === '') {
            abort(404);
        }

        $dataPelamar = Pelamar::query()
            ->where(function ($query) use ($pelamar) {
                if (is_numeric($pelamar)) {
                    $query->where('id', $pelamar);
                }

                $query->orWhere('nik', $pelamar);
            })
            ->where(function ($query) use ($divisi) {
                $this->applyPelamarDivisiFilter($query, $divisi);
            })
            ->firstOrFail();

        $pelamar = $dataPelamar;

        return view('manajer.data_pelamar.show', compact('dataPelamar', 'pelamar', 'divisi'));
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