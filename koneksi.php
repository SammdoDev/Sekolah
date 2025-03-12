<?php
class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "sekolah";
    private $koneksi;

    function __construct()
    {
        // Koneksi ke MySQL tanpa memilih database dulu
        $this->koneksi = new mysqli($this->host, $this->username, $this->password);

        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }

        // Inisialisasi database dan tabel jika belum ada
        $this->initDatabase();

        // Pilih database yang telah dibuat
        $this->koneksi->select_db($this->database);
    }

    private function initDatabase()
    {
        // Membuat database jika belum ada
        $queryDB = "CREATE DATABASE IF NOT EXISTS {$this->database}";
        $this->koneksi->query($queryDB);

        // Pilih database
        $this->koneksi->select_db($this->database);

        // Membuat tabel jurusan
        $queryJurusan = "CREATE TABLE IF NOT EXISTS jurusan (
            kodejurusan INT PRIMARY KEY AUTO_INCREMENT,
            namajurusan VARCHAR(50) NOT NULL
        )";
        $this->koneksi->query($queryJurusan);

        // Membuat tabel agama
        $queryAgama = "CREATE TABLE IF NOT EXISTS agama (
            kodeagama INT PRIMARY KEY AUTO_INCREMENT,
            agama VARCHAR(50) NOT NULL
        )";
        $this->koneksi->query($queryAgama);

        // Membuat tabel siswa
// Membuat tabel siswa (dengan tipe data yang benar untuk foreign key)
        $querySiswa = "CREATE TABLE IF NOT EXISTS siswa (
    nisn VARCHAR(15) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    jeniskelamin ENUM('L', 'P') NOT NULL,
    kodejurusan INT NOT NULL,  -- Ubah dari VARCHAR(10) ke INT agar cocok dengan jurusan
    kelas VARCHAR(10) NOT NULL,
    alamat TEXT NOT NULL,
    agama INT NOT NULL,
    nohp VARCHAR(15) NOT NULL,
    FOREIGN KEY (kodejurusan) REFERENCES jurusan(kodejurusan) ON DELETE CASCADE,
    FOREIGN KEY (agama) REFERENCES agama(kodeagama) ON DELETE CASCADE
    )";

        $this->koneksi->query($querySiswa);
    }

    public function getKoneksi()
    {
        return $this->koneksi;
    }

    function tampil_data_siswa()
    {
        $query = "SELECT 
                    s.nisn, 
                    s.nama, 
                    s.jeniskelamin, 
                    j.namajurusan AS jurusan,
                    s.kelas, 
                    s.alamat, 
                    a.agama AS agama,
                    s.nohp
                  FROM siswa s
                  INNER JOIN jurusan j ON s.kodejurusan = j.kodejurusan
                  INNER JOIN agama a ON s.agama = a.kodeagama";

        $result = $this->koneksi->query($query);

        $data = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } else {
            echo "Error: " . $this->koneksi->error;
        }

        return $data;
    }

    public function tambah_siswa($nisn, $nama, $jeniskelamin, $kodejurusan, $kelas, $alamat, $agama, $nohp)
    {
        $stmt = $this->koneksi->prepare("INSERT INTO siswa (nisn, nama, jeniskelamin, kodejurusan, kelas, alamat, agama, nohp) 
                                          VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssss", $nisn, $nama, $jeniskelamin, $kodejurusan, $kelas, $alamat, $agama, $nohp);
        return $stmt->execute();
    }

    public function get_siswa_by_nisn($nisn)
    {
        $sql = "SELECT * FROM siswa WHERE nisn = ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("s", $nisn);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function update_siswa($nisn, $nama, $jeniskelamin, $kodejurusan, $kelas, $alamat, $agama, $nohp)
    {
        $jeniskelamin = ($jeniskelamin == "Laki-laki") ? "L" : "P";
        $sql = "UPDATE siswa SET 
                    nama = ?, 
                    jeniskelamin = ?, 
                    kodejurusan = ?, 
                    kelas = ?, 
                    alamat = ?, 
                    agama = ?, 
                    nohp = ?
                WHERE nisn = ?";

        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ssssssss", $nama, $jeniskelamin, $kodejurusan, $kelas, $alamat, $agama, $nohp, $nisn);

        return $stmt->execute();
    }


    public function hapus_siswa($nisn)
    {
        $query = "DELETE FROM siswa WHERE nisn = ?";
        $stmt = $this->koneksi->prepare($query);
        $stmt->bind_param("s", $nisn);
        return $stmt->execute();
    }

}
?>