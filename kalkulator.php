<!DOCTYPE html>
<html>
<head>
    <title>Kalkulator Sederhana PHP</title>
</head>
<body>
    <h2>Kalkulator Sederhana</h2>
    <form method="post" action="">
        <input type="number" name="angka1" placeholder="Masukkan Angka 1" required>
        <input type="number" name="angka2" placeholder="Masukkan Angka 2" required>
        <select name="operator" >
            <option value ="operasi">operasi</option>
            <option value="tambah">tambah</option>
            <option value="kurang">kurang</option>
            <option value="kali">kali</option>
            <option value="bagi">bagi</option>
        </select>
         <button type="submit" name="hitung">Hitung</button>
    </form>

    <?php
    if (isset($_POST['hitung'])) {
        $angka1 = $_POST['angka1'];
        $angka2 = $_POST['angka2'];
        $operator = $_POST['operator'];
        $operasi = $_POST['operasi'];
        $hasil = "";

        switch ($operator) {
            case 'tambah':
                $hasil = $angka1 + $angka2;
                break;
            case 'kurang':
                $hasil = $angka1 - $angka2;
                break;
            case 'kali':
                $hasil = $angka1 * $angka2;
                break;
            case 'bagi':
                if ($angka2 != 0) {
                    $hasil = $angka1 / $angka2;
                } else {
                    $hasil = "Kesalahan";
                }
                break;
            case 'operasi':
                $hasil = $angka1 pilih operasi $angka2;
                else
                    $hasil = "kesalahan";
        }
        echo "<h3>Hasil perhitungan: $hasil</h3>";
    }
    ?>
</body>
</html>
