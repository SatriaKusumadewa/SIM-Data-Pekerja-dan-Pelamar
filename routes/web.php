<?php

use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\SearchController as AdminSearchController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Hrd\PelamarController;
use App\Http\Controllers\Hrd\DataPencariKerjaDiterimaController;
use App\Http\Controllers\Hrd\DokumenPencariKerjaDiterimaController;
use App\Http\Controllers\Hrd\SearchController as HrdSearchController;
use App\Http\Controllers\Hrd\DashboardController as HrdDashboardController;
use App\Http\Controllers\Manajer\DataKaryawanController as ManajerDataKaryawanController;
use App\Http\Controllers\Manajer\DataPelamarController as ManajerDataPelamarController;
use App\Http\Controllers\Manajer\DashboardController as ManajerDashboardController;
use App\Http\Controllers\Manajer\SearchController as ManajerSearchController;
use App\Http\Controllers\Karyawan\KaryawanController;

Route::redirect('/', '/login');

// route lain di bawah...
require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('hrd')) {
        return redirect()->route('hrd.dashboard');
    }

    if ($user->hasRole('manajer')) {
        return redirect()->route('manajer.dashboard');
    }

    if ($user->hasRole('karyawan')) {
        return redirect()->route('karyawan.dashboard');
    }

    abort(403, 'Role tidak dikenali.');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/search', [AdminSearchController::class, 'index'])->name('search');

    Route::resource('/users', UserController::class)->except(['show']);
    Route::resource('/roles', RoleController::class)->only(['index', 'create', 'store', 'destroy']);
});

Route::middleware(['auth', 'role:hrd'])->group(function () {
    Route::get('/hrd/dashboard', [HrdDashboardController::class, 'index'])
        ->name('hrd.dashboard');

    Route::get('/hrd/search', [HrdSearchController::class, 'index'])
        ->name('hrd.search');

    Route::resource('/hrd/pelamars', PelamarController::class)->names('hrd.pelamars');

    Route::get('/hrd/data-karyawan', [DataPencariKerjaDiterimaController::class, 'index'])
        ->name('hrd.data-karyawan.index');

    Route::get('/hrd/data-karyawan/create', [DataPencariKerjaDiterimaController::class, 'create'])
        ->name('hrd.data-karyawan.create');

    Route::post('/hrd/data-karyawan', [DataPencariKerjaDiterimaController::class, 'store'])
        ->name('hrd.data-karyawan.store');

    Route::get('/hrd/data-karyawan/{nik}/edit', [DataPencariKerjaDiterimaController::class, 'edit'])
        ->name('hrd.data-karyawan.edit');

    Route::put('/hrd/data-karyawan/{nik}', [DataPencariKerjaDiterimaController::class, 'update'])
        ->name('hrd.data-karyawan.update');

    Route::get('/hrd/pelamars/{pelamar}/proses', [DataPencariKerjaDiterimaController::class, 'createFromPelamar'])
        ->name('hrd.pelamars.proses.create');

    Route::post('/hrd/pelamars/{pelamar}/proses', [DataPencariKerjaDiterimaController::class, 'storeFromPelamar'])
        ->name('hrd.pelamars.proses.store');

    Route::get('/hrd/data-karyawan/{nik}/cetak', [DataPencariKerjaDiterimaController::class, 'cetak'])
        ->name('hrd.data-karyawan.cetak');

    Route::get('/hrd/data-karyawan/{nik}/pdf', [DataPencariKerjaDiterimaController::class, 'downloadPdf'])
        ->name('hrd.data-karyawan.pdf');

    Route::get('/hrd/pelamars/{pelamar}/dokumen/{jenis}/preview', [PelamarController::class, 'previewDokumen'])
        ->name('hrd.pelamars.dokumen.preview');

    Route::get('/hrd/pelamars/{pelamar}/dokumen/{jenis}/download', [PelamarController::class, 'downloadDokumen'])
        ->name('hrd.pelamars.dokumen.download');

    Route::get('/hrd/dokumen-karyawan', [DokumenPencariKerjaDiterimaController::class, 'index'])
        ->name('hrd.dokumen-karyawan.index');

    Route::get('/hrd/data-karyawan/{karyawan}/dokumen/create', [DokumenPencariKerjaDiterimaController::class, 'create'])
        ->name('hrd.data-karyawan.dokumen.create');

    Route::post('/hrd/data-karyawan/{karyawan}/dokumen', [DokumenPencariKerjaDiterimaController::class, 'store'])
        ->name('hrd.data-karyawan.dokumen.store');

    Route::get('/hrd/dokumen-karyawan/{karyawan}/preview/{jenis}', [DokumenPencariKerjaDiterimaController::class, 'preview'])
        ->name('hrd.dokumen-karyawan.preview');

    Route::get('/hrd/dokumen-karyawan/{karyawan}/preview-file/{jenis}', [DokumenPencariKerjaDiterimaController::class, 'previewFile'])
        ->name('hrd.dokumen-karyawan.preview-file');

    Route::get('/hrd/dokumen-karyawan/{dokumen}/download/{jenis}', [DokumenPencariKerjaDiterimaController::class, 'download'])
        ->name('hrd.dokumen-karyawan.download');

    Route::post('/hrd/pelamars/{pelamar}/arsip', [PelamarController::class, 'arsip'])
        ->name('hrd.pelamars.arsip');

    Route::post('/hrd/pelamars/{pelamar}/pulihkan', [PelamarController::class, 'pulihkan'])
        ->name('hrd.pelamars.pulihkan');

    Route::post('/hrd/data-karyawan/{karyawan}/status', [DataPencariKerjaDiterimaController::class, 'ubahStatus'])
        ->name('hrd.data-karyawan.status');
});

Route::middleware(['auth', 'role:manajer'])->group(function () {
    Route::get('/manajer/dashboard', [ManajerDashboardController::class, 'index'])
        ->name('manajer.dashboard');

    Route::get('/manajer/search', [ManajerSearchController::class, 'index'])
        ->name('manajer.search');

    Route::get('/manajer/data-karyawan', [ManajerDataKaryawanController::class, 'index'])
        ->name('manajer.data-karyawan.index');

    Route::get('/manajer/data-karyawan/{karyawan}', [ManajerDataKaryawanController::class, 'show'])
        ->name('manajer.data-karyawan.show');

    Route::get('/manajer/data-pelamar', [ManajerDataPelamarController::class, 'index'])
        ->name('manajer.data-pelamar.index');

    Route::get('/manajer/data-pelamar/{pelamar}', [ManajerDataPelamarController::class, 'show'])
        ->name('manajer.data-pelamar.show');
});

Route::middleware(['auth', 'role:karyawan'])->group(function () {
    Route::redirect('/karyawan/dashboard', '/karyawan/profil')
        ->name('karyawan.dashboard');

    Route::get('/karyawan/profil', [KaryawanController::class, 'profil'])
        ->name('karyawan.profil');

    Route::get('/karyawan/dokumen', [KaryawanController::class, 'dokumen'])
        ->name('karyawan.dokumen');

    Route::get('/karyawan/dokumen/{jenis}/preview', [KaryawanController::class, 'preview'])
        ->name('karyawan.dokumen.preview');

    Route::get('/karyawan/dokumen/{jenis}/download', [KaryawanController::class, 'download'])
        ->name('karyawan.dokumen.download');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/session-test', function () {
    session(['test' => 'berhasil']);
    return response()->json([
        'session_write' => session('test'),
        'roles' => \Spatie\Permission\Models\Role::all(['id', 'name', 'guard_name']),
        'users_with_roles' => \App\Models\User::with('roles')->get()->map(fn($u) => [
            'id' => $u->id,
            'email' => $u->email,
            'roles' => $u->roles->pluck('name'),
        ]),
    ]);
});

require __DIR__ . '/auth.php';