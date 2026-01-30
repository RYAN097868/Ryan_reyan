<?php
session_start();

if (!isset($_SESSION['riwayat'])) {
    $_SESSION['riwayat'] = [];
}

// Logika Hapus Riwayat
if (isset($_GET['action']) && $_GET['action'] == 'hapus') {
    $_SESSION['riwayat'] = [];
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$hasil = "";
if (isset($_POST['hitung'])) {
    $angka1 = $_POST['angka1'];
    $angka2 = $_POST['angka2'];
    $operator = $_POST['operator'];
    $simbol = "";

    switch ($operator) {
        case 'tambah': $hasil = $angka1 + $angka2; $simbol = "+"; break;
        case 'kurang': $hasil = $angka1 - $angka2; $simbol = "-"; break;
        case 'kali':   $hasil = $angka1 * $angka2; $simbol = "x"; break;
        case 'bagi':
            $simbol = "/";
            $hasil = ($angka2 != 0) ? ($angka1 / $angka2) : "Error (Bagi 0)";
            break;
    }

    $log = "$angka1 $simbol $angka2 = $hasil";
    array_unshift($_SESSION['riwayat'], $log);
}

// Skenario: Tampilkan riwayat jika parameter 'view' ada di URL
$show_history = isset($_GET['view']) && $_GET['view'] == 'history';
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kalkulator Terpadu 2026</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #e9ecef; display: flex; justify-content: center; padding-top: 50px; }
        .main-table { background: white; border-collapse: collapse; width: 350px; box-shadow: 0 10px 30px rgba(0,0,0,0.15); border-radius: 12px; overflow: hidden; }
        .header { background: #2c3e50; color: white; text-align: center; padding: 15px; position: relative; }
        .icon-jam { position: absolute; right: 15px; top: 15px; text-decoration: none; color: #bdc3c7; font-size: 1.2rem; }
        .icon-jam:hover { color: white; }
        
        td { padding: 12px 20px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn-hitung { background: #27ae60; color: white; border: none; padding: 12px; width: 100%; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-hitung:hover { background: #219150; }
        
        .riwayat-section { background: #f8f9fa; border-top: 2px solid #eee; font-size: 0.9rem; }
        .riwayat-item { padding: 8px 20px; border-bottom: 1px solid #eee; color: #555; }
        .btn-back { display: block; text-align: center; padding: 10px; background: #34495e; color: white; text-decoration: none; font-size: 0.8rem; }
        .btn-hapus { color: #e74c3c; text-decoration: none; font-size: 0.7rem; float: right; }
    </style>
</head>
<body>

<table class="main-table">
    <thead>
        <tr>
            <th class="header">
                <?php echo $show_history ? "Riwayat Perhitungan" : "Kalkulator 2026"; ?>
                <a href="?view=history" class="icon-jam" title="Lihat Riwayat">🕒</a>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php if (!$show_history): ?>
            <!-- Tampilan Kalkulator -->
            <form method="post" action="?action=hitung">
                <tr><td><input type="number" name="angka1" step="any" placeholder="Masukkan angka 1" required></td></tr>
                <tr><td><input type="number" name="angka2" step="any" placeholder="Masukkan angka 2" required></td></tr>
                <tr>
                    <td>
                        <select name="operator">
                            <option value="tambah">Tambah (+)</option>
                            <option value="kurang">Kurang (-)</option>
                            <option value="kali">Kali (x)</option>
                            <option value="bagi">Bagi (/)</option>
                        </select>
                    </td>
                </tr>
                <tr><td><button type="submit" name="hitung" class="btn-hitung">HITUNG</button></td></tr>
                <?php if ($hasil !== ""): ?>
                    <tr><td style="text-align: center; background: #d4edda; color: #155724;"><strong>Hasil: <?php echo $hasil; ?></strong></td></tr>
                <?php endif; ?>
            </form>
        <?php else: ?>
            <!-- Tampilan Riwayat (Dalam Tabel yang Sama) -->
            <tr>
                <td class="riwayat-section">
                    <a href="?action=hapus" class="btn-hapus" onclick="return confirm('Hapus semua riwayat?')">Hapus Semua</a>
                    <div style="margin-bottom: 10px; font-weight: bold; color: #333;">Daftar Terakhir:</div>
                    <?php if (!empty($_SESSION['riwayat'])): ?>
                        <?php foreach (array_slice($_SESSION['riwayat'], 0, 10) as $item): ?>
                            <div class="riwayat-item"><?php echo $item; ?></div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="riwayat-item">Tidak ada riwayat.</div>
                    <?php endif; ?>
                </td>
            </tr>
            <tr>
                <td style="padding: 0;"><a href="?" class="btn-back"> Kembali ke Kalkulator</a></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>
