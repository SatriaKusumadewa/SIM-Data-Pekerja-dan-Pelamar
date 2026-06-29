<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Pelamar;
use App\Models\DataPencariKerjaDiterima;
use Spatie\Permission\Models\Role;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUser = User::count();
        $totalKaryawan = DataPencariKerjaDiterima::count();
        $totalPelamar = Pelamar::count();
        $totalRole = Role::count();

        return view('admin.dashboard', compact(
            'totalUser',
            'totalKaryawan',
            'totalPelamar',
            'totalRole'
        ));
    }
}