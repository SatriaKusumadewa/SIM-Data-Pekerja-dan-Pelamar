<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Tambah Pelamar
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('pelamars.store') }}" method="POST">
                    @csrf

                    <div class="mb-4"><label>NIK</label><input type="text" name="nik" class="w-full border rounded p-2"></div>
                    <div class="mb-4"><label>Nama</label><input type="text" name="nama" class="w-full border rounded p-2"></div>
                    <div class="mb-4"><label>Alamat</label><textarea name="alamat" class="w-full border rounded p-2"></textarea></div>
                    <div class="mb-4"><label>No Telepon</label><input type="text" name="no_telepon" class="w-full border rounded p-2"></div>
                    <div class="mb-4"><label>Email</label><input type="email" name="email" class="w-full border rounded p-2"></div>
                    <div class="mb-4"><label>Pendidikan</label><input type="text" name="pendidikan" class="w-full border rounded p-2"></div>
                    <div class="mb-4"><label>Posisi Dilamar</label><input type="text" name="posisi_dilamar" class="w-full border rounded p-2"></div>
                    <div class="mb-4"><label>Tanggal Melamar</label><input type="date" name="tgl_melamar" class="w-full border rounded p-2"></div>
                    <div class="mb-4"><label>CV</label><input type="text" name="cv" class="w-full border rounded p-2"></div>
                    <div class="mb-4">
                        <label>Status Pelamar</label>
                        <select name="status_pelamar" class="w-full border rounded p-2">
                            <option value="diproses">Diproses</option>
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>