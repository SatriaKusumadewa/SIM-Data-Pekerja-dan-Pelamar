<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DokumenPencariKerjaDiterima extends Model
{
    protected $table = 'dokumen_pencari_kerja_diterimas';

    protected $primaryKey = 'id_dokumen';

    protected $fillable = [
        'nik',

        'ktp_path',
        'ktp_original_name',
        'ktp_mime',

        'ijazah_path',
        'ijazah_original_name',
        'ijazah_mime',

        'foto_path',
        'foto_original_name',
        'foto_mime',

        'buku_rekening_path',
        'buku_rekening_original_name',
        'buku_rekening_mime',
    ];

    public function dataKaryawan()
    {
        return $this->belongsTo(DataPencariKerjaDiterima::class, 'nik', 'nik');
    }
}