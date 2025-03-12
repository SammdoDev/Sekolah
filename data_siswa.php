<?php
require_once "koneksi.php";
$db = new Database();
$data_siswa = $db->tampil_data_siswa();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-5 bg-gray-100">

    <div class="max-w-5xl mx-auto bg-white p-5 rounded-lg shadow-lg mt-5">
        <!-- Tombol Navigasi -->
        <div class="flex justify-between mb-3">
            <h2 class="text-xl font-bold">Data Siswa</h2>
            <div class="space-x-2">
                <a href="data_agama.php" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">Data Agama</a>
                <a href="data_jurusan.php" class="bg-purple-500 text-white px-4 py-2 rounded hover:bg-purple-600">Data Jurusan</a>
                <a href="tambah_siswa.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah Siswa</a>
            </div>
        </div>

        <!-- Tabel Data Siswa -->
        <table class="w-full border-collapse border border-gray-300 text-sm">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="border border-gray-300 px-4 py-2">NISN</th>
                    <th class="border border-gray-300 px-4 py-2">Nama</th>
                    <th class="border border-gray-300 px-4 py-2">Jenis Kelamin</th>
                    <th class="border border-gray-300 px-4 py-2">Jurusan</th>
                    <th class="border border-gray-300 px-4 py-2">Kelas</th>
                    <th class="border border-gray-300 px-4 py-2">Alamat</th>
                    <th class="border border-gray-300 px-4 py-2">Agama</th>
                    <th class="border border-gray-300 px-4 py-2">No HP</th>
                    <th class="border border-gray-300 px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_siswa as $siswa) : ?>
                    <tr class="hover:bg-gray-100">
                        <td class="border border-gray-300 px-4 py-2"><?= $siswa['nisn'] ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $siswa['nama'] ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $siswa['jeniskelamin'] == 'L' ? 'Laki-laki' : 'Perempuan' ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $siswa['jurusan'] ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $siswa['kelas'] ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $siswa['alamat'] ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $siswa['agama'] ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $siswa['nohp'] ?></td>
                        <td class="border border-gray-300 px-4 py-2 flex gap-2">
                            <a href="edit_siswa.php?nisn=<?= $siswa['nisn'] ?>" class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">Edit</a>
                            <a href="hapus_siswa.php?nisn=<?= $siswa['nisn'] ?>" onclick="return confirm('Yakin ingin menghapus?');" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
