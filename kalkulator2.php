<?php
// Memulai session untuk menyimpan riwayat perhitungan
session_start();

// Jika session riwayat belum ada, buat array kosong
if (!isset($_SESSION['riwayat'])) {
    $_SESSION['riwayat'] = [];
}

// =====================
// HAPUS RIWAYAT
// =====================
// Jika URL mengandung ?action=hapus
if (isset($_GET['action']) && $_GET['action'] === 'hapus') {
    $_SESSION['riwayat'] = [];   // Kosongkan riwayat
    header("Location: ?");       // Refresh halaman
    exit;
}

// Variabel hasil awal
$hasil = "";

// =====================
// PROSES PERHITUNGAN
// =====================
if (isset($_POST['hitung'])) {

    // Mengganti koma menjadi titik agar bisa dibaca float
    $angka1 = str_replace(',', '.', $_POST['angka1']);
    $angka2 = str_replace(',', '.', $_POST['angka2']);

    // Mengubah input ke tipe float
    $angka1 = (float)$angka1;
    $angka2 = (float)$angka2;

    // Ambil operator
    $operator = $_POST['operator'];
    $simbol = ""; // Simbol operasi

    // Menentukan operasi
    switch ($operator) {
        case 'tambah':
            $hasil = $angka1 + $angka2;
            $simbol = "+";
            break;

        case 'kurang':
            $hasil = $angka1 - $angka2;
            $simbol = "-";
            break;

        case 'kali':
            $hasil = $angka1 * $angka2;
            $simbol = "×";
            break;

        case 'bagi':
            $simbol = "/";
            // Cegah pembagian dengan nol
            $hasil = ($angka2 != 0) ? ($angka1 / $angka2) : "Tidak bisa dibagi 0";
            break;
    }

    // Simpan hasil ke riwayat (paling baru di atas)
    array_unshift($_SESSION['riwayat'], "$angka1 $simbol $angka2 = $hasil");
}

// Cek apakah sedang melihat halaman riwayat
$show_history = isset($_GET['view']) && $_GET['view'] === 'history';
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Kalkulator UKK 2026</title>

<style>
/* Style halaman */
body{
    font-family:'Segoe UI', sans-serif;
    background:#e9ecef;
    display:flex;
    justify-content:center;
    padding-top:50px;
}
.container{
    display:flex;
    flex-direction:column;
    align-items:center;
}
.main-table{
    width:350px;
    background:white;
    border-collapse:collapse;
    border-radius:12px;
    overflow:hidden;
    box-shadow:0 10px 30px rgba(0,0,0,.15);
}
.header{
    background:#2c3e50;
    color:white;
    padding:15px;
    text-align:center;
    position:relative;
}
.icon-jam{
    position:absolute;
    right:15px;
    top:15px;
    text-decoration:none;
    color:#bdc3c7;
}
.icon-jam:hover{color:white;}
td{padding:12px 20px;}
input,select{
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:5px;
}
.btn-hitung{
    width:100%;
    padding:12px;
    background:#27ae60;
    color:white;
    border:none;
    border-radius:5px;
    font-weight:bold;
    cursor:pointer;
}
.btn-hitung:hover{background:#219150;}
.hasil{
    text-align:center;
    background:#d4edda;
    color:#155724;
    font-weight:bold;
}
.riwayat-item{
    padding:8px 20px;
    border-bottom:1px solid #eee;
    font-size:.9rem;
}
.btn-back{
    display:block;
    text-align:center;
    padding:10px;
    background:#34495e;
    color:white;
    text-decoration:none;
    font-size:.8rem;
}
.btn-hapus{
    float:right;
    font-size:.7rem;
    color:#e74c3c;
    text-decoration:none;
}
.footer{
    margin-top:15px;
    font-size:.8rem;
    color:#555;
    text-align:center;
}
</style>
</head>

<body>
<div class="container">

<table class="main-table">
<thead>
<tr>
<th class="header">
<?= $show_history ? "Riwayat Perhitungan" : "Kalkulator UKK 2026"; ?>
<a href="?view=history" class="icon-jam">🕒</a>
</th>
</tr>
</thead>

<tbody>

<?php if (!$show_history): ?>
<!-- ================= FORM KALKULATOR ================= -->
<form method="post">
<tr><td>
<input type="number" name="angka1" placeholder="Masukan Angka 1" required>
</td></tr>

<tr><td>
<input type="number" name="angka2" placeholder="Masukan Angka 2" required>
</td></tr>

<tr><td>
<select name="operator" required>
    <option value="" disabled selected>Pilih Operasi</option>
    <option value="tambah">Tambah (+)</option>
    <option value="kurang">Kurang (-)</option>
    <option value="kali">Kali (×)</option>
    <option value="bagi">Bagi (/)</option>
</select>
</td></tr>

<tr><td>
<button class="btn-hitung" name="hitung">HITUNG</button>
</td></tr>

<?php if ($hasil !== ""): ?>
<tr>
<td class="hasil">Hasil: <?= $hasil ?></td>
</tr>
<?php endif; ?>
</form>

<?php else: ?>
<!-- ================= HALAMAN RIWAYAT ================= -->
<tr>
<td>
<a href="?action=hapus" class="btn-hapus"
onclick="return confirm('Hapus semua riwayat?')">Hapus</a>
<strong>Riwayat Terakhir:</strong>
</td>
</tr>

<?php if (!empty($_SESSION['riwayat'])): ?>
<?php foreach (array_slice($_SESSION['riwayat'], 0, 10) as $item): ?>
<tr><td class="riwayat-item"><?= $item ?></td></tr>
<?php endforeach; ?>
<?php else: ?>
<tr><td class="riwayat-item">Belum ada riwayat.</td></tr>
<?php endif; ?>

<tr>
<td style="padding:0">
<a href="?" class="btn-back">Kembali</a>
</td>
</tr>
<?php endif; ?>

</tbody>
</table>

<div class="footer">
UKK 2026 • Ryan Aries Anugrah
</div>

</div>
</body>
</html>
