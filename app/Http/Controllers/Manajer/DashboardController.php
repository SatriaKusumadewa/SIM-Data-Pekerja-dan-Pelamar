<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\DataPencariKerjaDiterima;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $divisi = DataPencariKerjaDiterima::query()
            ->when($user->nik, function ($query) use ($user) {
                $query->where('nik', $user->nik);
            }, function ($query) use ($user) {
                $query->where('email', $user->email);
            })
            ->value('divisi');

        $divisi = trim((string) $divisi);

        if ($divisi === '') {
            $dataKaryawan = collect();
        } else {
            $dataKaryawan = DataPencariKerjaDiterima::query()
                ->whereRaw('LOWER(TRIM(divisi)) = ?', [strtolower($divisi)])
                ->orderBy('nama_karyawan')
                ->get()
                ->map(function ($item) {
                    $item->status_label = ucfirst($item->status_karyawan ?? 'aktif');

                    $jabatan = strtolower(trim($item->jabatan ?? ''));

                    if ($jabatan === 'manajer') {
                        $item->nama_role = 'Manajer';
                    } elseif ($jabatan === 'hrd') {
                        $item->nama_role = 'HRD';
                    } else {
                        $item->nama_role = 'Karyawan';
                    }

                    return $item;
                });
        }

        return view('manajer.dashboard', compact('dataKaryawan', 'divisi'));
    }
}