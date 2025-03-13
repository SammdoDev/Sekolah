<?php
require_once "koneksi.php";
$db = new Database();
$koneksi = $db->getKoneksi();

// Ambil daftar jurusan dan agama
$queryJurusan = "SELECT * FROM jurusan";
$resultJurusan = mysqli_query($koneksi, $queryJurusan);

$queryAgama = "SELECT * FROM agama";
$resultAgama = mysqli_query($koneksi, $queryAgama);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nisn = $_POST['nisn'];
    $nama = $_POST['nama'];
    $jeniskelamin = $_POST['jeniskelamin'];
    $kodejurusan = $_POST['kodejurusan'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $agama = $_POST['agama']; // Pastikan ini angka, bukan nama agama!
    $nohp = $_POST['nohp'];

    $db = new Database();
    if ($db->tambah_siswa($nisn, $nama, $jeniskelamin, $kodejurusan, $kelas, $alamat, $agama, $nohp)) {
        // Redirect ke index.php setelah berhasil simpan
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Gagal menambahkan data siswa!";
    }
}


?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa - Liekuang Academy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-5 bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="max-w-4xl w-full bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center text-blue-600 mb-6">Tambah Data Siswa</h2>

        <?php if (isset($error_message)): ?>
            <p class="text-red-500 text-center mb-4"><?= htmlspecialchars($error_message); ?></p>
        <?php endif; ?>

        <form action="tambah_siswa.php" method="post">
            <div class="grid grid-cols-2 gap-4">
                <!-- Kolom 1 -->
                <div>
                    <label class="block mb-2 font-semibold">NISN</label>
                    <input class="border p-2 w-full mb-3 rounded" type="text" name="nisn" placeholder="Masukkan NISN"
                        required>

                    <label class="block mb-2 font-semibold">Nama</label>
                    <input class="border p-2 w-full mb-3 rounded" type="text" name="nama" placeholder="Masukkan Nama"
                        required>

                    <label class="block mb-2 font-semibold">Jenis Kelamin</label>
                    <select class="border p-2 w-full mb-3 rounded" name="jeniskelamin" required>
                        <option value="L">Laki-laki</option>
                        <option value="P">Perempuan</option>
                    </select>

                    <label class="block mb-2 font-semibold">Kode Jurusan</label>
                    <select class="border p-2 w-full mb-3 rounded" name="kodejurusan" required>
                        <?php while ($row = mysqli_fetch_assoc($resultJurusan)): ?>
                            <option value="<?= $row['kodejurusan']; ?>">
                                <?= $row['kodejurusan']; ?> - <?= $row['namajurusan']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <!-- Kolom 2 -->
                <div>
                    <label class="block mb-2 font-semibold">Kelas</label>
                    <input class="border p-2 w-full mb-3 rounded" type="text" name="kelas" placeholder="Masukkan Kelas"
                        required>

                    <label class="block mb-2 font-semibold">Alamat</label>
                    <input class="border p-2 w-full mb-3 rounded" type="text" name="alamat"
                        placeholder="Masukkan Alamat" required>

                    <label class="block mb-2 font-semibold">Agama</label>
                    <select class="border p-2 w-full mb-3 rounded" name="agama" required>
                        <?php while ($row = mysqli_fetch_assoc($resultAgama)): ?>
                            <option value="<?= $row['kodeagama']; ?>">
                                <?= $row['agama']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>


                    <label class="block mb-2 font-semibold">No HP</label>
                    <input class="border p-2 w-full mb-3 rounded" type="text" name="nohp" placeholder="Masukkan No HP"
                        required>
                </div>
            </div>

            <button class="bg-blue-500 text-white px-4 py-2 rounded w-full hover:bg-blue-600 transition-all mt-4">
                Simpan
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="index.php" class="text-blue-500 hover:underline">Kembali ke Data Siswa</a>
        </div>
    </div>

</body>

</html>