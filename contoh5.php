<html>
    <head>
        <title>Test Penyisipan PHP Pada HTML</title>
    </head>
    <body>
    Kapal Asing, Silakan identifikasikan diri Anda! <br>
    <?php
    // Berikut ini adalah inisiasi beberapa variabel
    $namad = "Jean";
    $namat = "Luc";
    $namab = "Piccard";
    ?>
    <b>Ini adalah kapal Federasi Planet USS Enterprise.<br>
    <?php
    echo "Saya $namab, $namad $namat $namab, kapten kapal.</b>";
    ?>
</body>
</html>