
 <?php
    if (isset($_POST['hitung'])) {
        $angka1 = $_POST['angka1'];
        $angka2 = $_POST['angka2'];
        $operator = $_POST['operator'];
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
                    $hasil = "Kesalahan: Pembagi nol!";
                }
                break;
        }
        echo "<h3>Hasil perhitungan: $hasil</h3>";
    }
    ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quantum Calculator 2026</title>
    <link href="fonts.googleapis.com" rel="stylesheet">
    <style>
        :root {
            --primary-neon: #00f2ff;
            --accent-purple: #7000ff;
            --glass-bg: rgba(255, 255, 255, 0.1);
            --glass-border: rgba(255, 255, 255, 0.2);
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(circle at top left, #1a1a2e, #16213e, #0f3460);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        /* Dekorasi Background Latar Belakang */
        .circle {
            position: absolute;
            border-radius: 50%;
            background: linear-gradient(45deg, var(--primary-neon), var(--accent-purple));
            filter: blur(80px);
            z-index: -1;
            animation: move 10s infinite alternate;
        }
        .c1 { width: 300px; height: 300px; top: -10%; left: -10%; }
        .c2 { width: 400px; height: 400px; bottom: -15%; right: -5%; opacity: 0.6; }

        @keyframes move { from { transform: translate(0,0); } to { transform: translate(50px, 50px); } }

        /* Container Utama */
        .glass-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            border-radius: 30px;
            padding: 40px;
            width: 380px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            text-align: center;
            color: white;
            position: relative;
        }

        h2 {
            font-family: 'Orbitron', sans-serif;
            letter-spacing: 2px;
            margin-bottom: 30px;
            font-size: 1.5rem;
            background: linear-gradient(to right, #fff, var(--primary-neon));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .input-group { position: relative; margin-bottom: 20px; }

        input, select {
            width: 100%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 15px;
            padding: 15px;
            color: white;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus, select:focus {
            border-color: var(--primary-neon);
            background: rgba(255, 255, 255, 0.1);
            box-shadow: 0 0 15px rgba(0, 242, 255, 0.3);
        }

        /* Desain Select yang unik */
        select option { background: #16213e; color: white; }

        button {
            width: 100%;
            padding: 15px;
            margin-top: 10px;
            background: linear-gradient(45deg, var(--accent-purple), var(--primary-neon));
            border: none;
            border-radius: 15px;
            color: white;
            font-weight: 700;
            font-family: 'Orbitron', sans-serif;
            cursor: pointer;
            transition: 0.4s;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 15px rgba(112, 0, 255, 0.4);
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 242, 255, 0.6);
            letter-spacing: 3px;
        }

        /* Panel Hasil */
        .display-result {
            margin-top: 30px;
            padding: 20px;
            background: rgba(0, 0, 0, 0.3);
            border-radius: 20px;
            border-bottom: 2px solid var(--primary-neon);
        }

        .display-result label {
            font-size: 0.8rem;
            color: var(--primary-neon);
            text-transform: uppercase;
            display: block;
            margin-bottom: 5px;
        }

        #hasil {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.2rem;
            text-shadow: 0 0 10px var(--primary-neon);
        }
    </style>
</head>
<body>

<div class="circle c1"></div>
<div class="circle c2"></div>

<div class="glass-card">
    <h2>QUANTUM CALC</h2>
    
    <div class="input-group">
        <input type="number" id="num1" placeholder="ANGKA PERTAMA" autocomplete="off">
    </div>

    <div class="input-group">
        <select id="operator">
            <option value="" disabled selected>Pilih Perhitungan</option>
            <option value="tambah">PENJUMLAHAN (+)</option>
            <option value="kurang">PENGURANGAN (-)</option>
            <option value="kali">PERKALIAN (×)</option>
            <option value="bagi">PEMBAGIAN (÷)</option>
        </select>
    </div>

    <div class="input-group">
        <input type="number" id="num2" placeholder="ANGKA KEDUA" autocomplete="off">
    </div>
    
    <button onclick="hitung()">Execute Process</button>

    <div class="display-result">
        <label>System Output</label>
        <span id="hasil">0.00</span>
    </div>
</div>

<script>
function hitung() {
    const n1 = parseFloat(document.getElementById('num1').value);
    const n2 = parseFloat(document.getElementById('num2').value);
    const op = document.getElementById('operator').value;
    const resElem = document.getElementById('hasil');

    if (isNaN(n1) || isNaN(n2) || op === "") {
        resElem.style.color = "#ff4d4d";
        resElem.innerText = "ERROR";
        return;
    }

    resElem.style.color = "white";
    let hasil = 0;
    
    switch(op) {
        case "tambah": hasil = n1 + n2; break;
        case "kurang": hasil = n1 - n2; break;
        case "kali": hasil = n1 * n2; break;
        case "bagi": hasil = n2 !== 0 ? (n1 / n2).toFixed(2) : "NAN"; break;
    }

    // Efek angka berjalan sederhana
    resElem.innerText = hasil;
}
</script>

</body>
</html>