<?php
include "koneksi.php";
$db = new Database();
$koneksi = $db->getKoneksi();

// Ambil data jurusan
$queryJurusan = "SELECT * FROM jurusan";
$resultJurusan = mysqli_query($koneksi, $queryJurusan);

// Proses penambahan jurusan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tambah_jurusan'])) {
    $namaJurusan = trim($_POST['nama_jurusan']);

    if (!empty($namaJurusan)) {
        $insertQuery = "INSERT INTO jurusan (namajurusan) VALUES ('$namaJurusan')";
        if (mysqli_query($koneksi, $insertQuery)) {
            header("Location: " . $_SERVER['PHP_SELF']); // Refresh halaman setelah insert
            exit();
        } else {
            echo "Error: " . mysqli_error($koneksi);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jurusan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex flex-col items-center min-h-screen p-5">

    <h2 class="text-2xl font-bold text-gray-700 mb-6">Data Jurusan</h2>

    <div class="w-full max-w-lg bg-white shadow-md rounded-lg p-4">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-blue-500 text-white">
                    <th class="p-3 text-left">Kode Jurusan</th>
                    <th class="p-3 text-left">Nama Jurusan</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultJurusan)): ?>
                    <tr class="border-b hover:bg-gray-100">
                        <td class="p-3"><?= htmlspecialchars($row['kodejurusan']); ?></td>
                        <td class="p-3"><?= htmlspecialchars($row['namajurusan']); ?></td>
                        <td class="p-3 text-center">
                            <a href="hapus_jurusan.php?kodejurusan=<?= $row['kodejurusan']; ?>"
                                onclick="return confirm('Yakin ingin menghapus jurusan ini?');"
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                Hapus
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <div class="w-full max-w-lg bg-white shadow-md rounded-lg p-6 mt-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Tambah Jurusan</h2>
        <form method="POST">
            <label class="block text-gray-600 font-medium mb-1">Nama Jurusan:</label>
            <input type="text" name="nama_jurusan" placeholder="Masukkan Nama Jurusan" required
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

            <button type="submit" name="tambah_jurusan"
                class="w-full mt-4 bg-green-500 text-white font-bold py-2 rounded-lg hover:bg-green-600 transition-all">
                Tambah
            </button>
        </form>
        <div class="text-center mt-4">
            <a href="index.php" class="text-blue-500 hover:underline">Kembali ke Data Siswa</a>
        </div>
    </div>

</body>

</html>