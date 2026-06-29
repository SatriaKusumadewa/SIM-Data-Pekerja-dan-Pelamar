<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\DataPencariKerjaDiterima;
use Illuminate\Support\Facades\Auth;

class DataKaryawanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $divisi = $this->getDivisiManajer($user);

        if ($divisi === '') {
            $dataKaryawan = collect();
        } else {
            $dataKaryawan = DataPencariKerjaDiterima::query()
                ->whereRaw('LOWER(TRIM(divisi)) = ?', [strtolower($divisi)])
                ->latest()
                ->get()
                ->map(function ($item) {
                    $item->status_label = ucfirst($item->status_karyawan ?? 'aktif');
                    return $item;
                });
        }

        return view('manajer.data_karyawan.index', compact('dataKaryawan', 'divisi'));
    }

    public function show(string $karyawan)
    {
        $user = Auth::user();

        $divisi = $this->getDivisiManajer($user);

        if ($divisi === '') {
            abort(404);
        }

        $dataKaryawan = DataPencariKerjaDiterima::query()
            ->where('nik', $karyawan)
            ->whereRaw('LOWER(TRIM(divisi)) = ?', [strtolower($divisi)])
            ->firstOrFail();

        $dataKaryawan->status_label = ucfirst($dataKaryawan->status_karyawan ?? 'aktif');

        return view('manajer.data_karyawan.show', compact('dataKaryawan', 'divisi'));
    }

    private function getDivisiManajer($user): string
    {
        $divisi = DataPencariKerjaDiterima::query()
            ->when($user->nik, function ($query) use ($user) {
                $query->where('nik', $user->nik);
            }, function ($query) use ($user) {
                $query->where('email', $user->email);
            })
            ->value('divisi');

        if (! $divisi && isset($user->divisi)) {
            $divisi = $user->divisi;
        }

        return trim((string) $divisi);
    }
}