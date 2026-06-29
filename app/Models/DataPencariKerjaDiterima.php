<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPencariKerjaDiterima extends Model
{
    protected $table = 'data_pencari_kerja_diterimas';

    protected $primaryKey = 'nik';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'nik',
        'nama_karyawan',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'alamat',
        'no_telepon',
        'email',
        'jabatan',
        'divisi',
        'tgl_masuk',
        'no_rekening',
        'nama_bank',
        'status_karyawan',
    ];

    public function pelamar()
    {
        return $this->belongsTo(Pelamar::class, 'id_pelamar', 'id');
    }

    public function dokumen()
    {
        return $this->hasOne(DokumenPencariKerjaDiterima::class, 'nik', 'nik');
    }

    public function getRouteKeyName()
    {
        return 'nik';
    }
    protected $casts = [
    'tgl_lahir' => 'date',
    'tgl_masuk' => 'date',
    ];
}