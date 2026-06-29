<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelamar extends Model
{
    protected $table = 'pelamars';

    protected $fillable = [
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'alamat',
        'no_telepon',
        'email',
        'pendidikan',
        'posisi_dilamar',
        'tgl_melamar',
        'status_pelamar',
        'is_arsip',

        // field lama
        'cv',
        'scan_ktp',
        'scan_ijazah',
        'foto',

        // field baru
        'cv_path',
        'ktp_path',
        'ijazah_path',
        'foto_path',

        'cv_mime',
        'ktp_mime',
        'ijazah_mime',
        'foto_mime',

        'cv_original_name',
        'ktp_original_name',
        'ijazah_original_name',
        'foto_original_name',

        'cv_drive_file_id',
        'ktp_drive_file_id',
        'ijazah_drive_file_id',
        'foto_drive_file_id',

        'cv_size',
        'ktp_size',
        'ijazah_size',
        'foto_size',
    ];

    protected $casts = [
        'tgl_lahir' => 'date',
        'tgl_melamar' => 'date',
        'is_arsip' => 'boolean',
    ];
}