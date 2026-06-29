<?php

namespace App\Http\Controllers\Hrd;

use App\Http\Controllers\Controller;
use App\Models\DataPencariKerjaDiterima;
use App\Models\Pelamar;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        $dataKaryawanQuery = DataPencariKerjaDiterima::query();

        $this->applySearch($dataKaryawanQuery, new DataPencariKerjaDiterima(), [
            'nama_karyawan',
            'nama',
            'nik',
            'email',
            'divisi',
            'jabatan',
            'status_karyawan',
        ], $q);

        $this->applyDefaultOrder($dataKaryawanQuery, new DataPencariKerjaDiterima());

        $dataKaryawan = $dataKaryawanQuery->get()->map(function ($item) {
            $item->status_label = ucfirst($item->status_karyawan ?? 'aktif');
            return $item;
        });

        $pelamarQuery = Pelamar::query();

        $this->applySearch($pelamarQuery, new Pelamar(), [
            'nama',
            'nama_lengkap',
            'nama_pelamar',
            'nik',
            'email',
            'posisi_dilamar',
            'status',
            'status_pelamar',
        ], $q);

        $this->applyDefaultOrder($pelamarQuery, new Pelamar());

        $pelamars = $pelamarQuery->get();

        // Alias untuk view lama yang masih memakai variabel $karyawans
        $karyawans = $dataKaryawan;

        return view('hrd.search.index', compact(
            'q',
            'dataKaryawan',
            'karyawans',
            'pelamars'
        ));
    }

    private function applySearch(Builder $query, $model, array $columns, string $q): void
    {
        if ($q === '') {
            return;
        }

        $table = $model->getTable();

        $availableColumns = array_values(array_filter($columns, function ($column) use ($table) {
            return Schema::hasColumn($table, $column);
        }));

        if (empty($availableColumns)) {
            return;
        }

        $keyword = '%' . strtolower($q) . '%';

        $query->where(function ($subQuery) use ($availableColumns, $keyword) {
            foreach ($availableColumns as $index => $column) {
                $sql = 'LOWER(CAST(' . $column . ' AS TEXT)) LIKE ?';

                if ($index === 0) {
                    $subQuery->whereRaw($sql, [$keyword]);
                } else {
                    $subQuery->orWhereRaw($sql, [$keyword]);
                }
            }
        });
    }

    private function applyDefaultOrder(Builder $query, $model): void
    {
        $table = $model->getTable();

        if (Schema::hasColumn($table, 'created_at')) {
            $query->orderByDesc('created_at');
            return;
        }

        if (Schema::hasColumn($table, 'id')) {
            $query->orderByDesc('id');
        }
    }
}