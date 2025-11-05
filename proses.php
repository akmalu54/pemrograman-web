<?php
// Tautan ke CSS
echo '<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Perhitungan</title>
    <link rel="stylesheet" href="css/style_proses.css"> 
</head>
<body>
    <div class="container">';

// Pengaturan Koneksi Database XAMPP
$servername = "localhost";
$username = "root"; 
$password = "";     
$dbname = "db_kalkulator"; 

// Buat Koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek Koneksi
if ($conn->connect_error) {
    echo '<p class="error">Koneksi gagal: ' . $conn->connect_error . '</p>';
    echo '</div></body></html>';
    exit;
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
            echo '<p class="error">Operator tidak valid!</p>';
            $conn->close();
            echo '</div></body></html>';
            exit;
    }

    // Siapkan query INSERT menggunakan Prepared Statements
    $sql = "INSERT INTO perhitungan (angka1, operator, angka2, hasil) VALUES (?, ?, ?, ?)";
    
    // Inisialisasi Prepared Statement
    $stmt = $conn->prepare($sql);
    
    // Bind parameter
    $stmt->bind_param("isii", $angka1, $operator, $angka2, $hasil);

    // Eksekusi query
    if ($stmt->execute()) {
        echo '<div class="result-box success">';
        echo '<h3>✅ Operasi Berhasil!</h3>';
        echo '<p class="calculation">' . $angka1 . ' ' . $operator . ' ' . $angka2 . ' = <strong>' . $hasil . '</strong></p>';
        echo '<p class="message">Data berhasil disimpan ke database.</p>';
        echo '</div>';
    } else {
        echo '<div class="result-box error">';
        echo '<h3>❌ Gagal Menyimpan Data</h3>';
        echo '<p class="message">Error: ' . $stmt->error . '</p>';
        echo '</div>';
    }

    // Tutup statement
    $stmt->close();
} else {
    echo '<p class="error">Akses tidak sah. Silakan kembali ke halaman input.</p>';
}

// Tutup koneksi database
$conn->close();

echo '<a href="index.php" class="button-back">Kembali ke Kalkulator</a>';
echo '</div></body></html>';
?>