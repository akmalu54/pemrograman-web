<?php
// Pengaturan Koneksi Database XAMPP
$servername = "localhost";
$username = "root"; // Username default XAMPP
$password = "";     // Password default XAMPP
$dbname = "db_kalkulator"; // Ganti jika nama database berbeda

// Buat Koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek Koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah data form telah dikirim melalui POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dan bersihkan (sanitasi)
    $angka1 = (int)$_POST['angka1'];
    $operator = $_POST['operator'];
    $angka2 = (int)$_POST['angka2'];
    $hasil = 0;

    // Lakukan Operasi Aritmatika
    switch ($operator) {
        case '+':
            $hasil = $angka1 + $angka2;
            break;
        case '-':
            $hasil = $angka1 - $angka2;
            break;
        default:
            echo "Operator tidak valid!";
            exit; // Hentikan eksekusi jika operator tidak valid
    }

    // Siapkan query INSERT menggunakan Prepared Statements (Penting untuk keamanan!)
    $sql = "INSERT INTO perhitungan (angka1, operator, angka2, hasil) VALUES (?, ?, ?, ?)";
    
    // Inisialisasi Prepared Statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameter (i=integer, s=string). Di sini: 3 integer, 1 string
    $stmt->bind_param("isii", $angka1, $operator, $angka2, $hasil);

    // Eksekusi query
    if ($stmt->execute()) {
        echo "Operasi " . $operator . " berhasil!<br>";
        echo "Hasil: " . $angka1 . " " . $operator . " " . $angka2 . " = " . $hasil . "<br>";
        echo "Data berhasil disimpan ke database.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
} else {
    echo "Akses tidak sah.";
}

// Tutup koneksi database
$conn->close();
?>