<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Simulasi Tabungan Berjangka</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .header {
            width: 600px;
            margin: 30px auto 0 auto;
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }
        .row {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 5px;
        }
        .label {
            width: 80px;
            text-align: left;
        }
        .container {
            width: 600px;
            background: white;
            margin: 40px auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        label {
            font-weight: bold;
        }
        input,
        select,
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            margin-top: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        button {
            background: #007bff;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .hasil-akhir {
            border: 2px solid #007bff;
            background-color: #e6f0ff;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
            color: #333;
        }
        .hasil-akhir p {
            margin: 6px 0;
            font-size: 16px;
        }
        .hasil-akhir b {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="row">
            <span class="label">NIM</span>
            <span>:</span>
            <span>202404012</span>
        </div>
        <div class="row">
            <span class="label">Nama</span>
            <span>:</span>
            <span>Muhammad Apiransyah Ramdhani</span>
        </div>
        <div class="row">
            <span class="label">Prodi</span>
            <span>:</span>
            <span>TEKNOLOGI REKAYASA PERANGKAT LUNAK</span>
        </div>
    </div>
    <div class="container">
        <h2>Simulasi Tabungan Berjangka</h2>
        <form method="post">
            <label>Nominal Target Tabungan (Rp.) :</label>
            <input type="number" name="target" required>

            <label>Pilih Metode Perhitungan</label>
            <select name="mode" required>
                <option value="bulan">Target Bulan</option>
                <option value="setoran">Jumlah Setoran Tetap</option>
            </select>

            <label>Masukan Bulan atau Setoran Tetap :</label>
            <input type="number" name="nilai" required>

            <button type="submit" name="hitung">Hitung Tabungan</button>
        </form>

        <?php
        if (isset($_POST['hitung'])) {
            $target = $_POST['target'];
            $mode   = $_POST['mode'];
            $nilai  = $_POST['nilai'];
            $bunga  = 0.0335;
            $admin  = 12500;

            echo "<h1>Hasil Perhitungan</h1>";

            $total_bunga = 0;
            $total_admin = 0;

            if ($mode == "bulan") {
                $bulan = $nilai;
                $setoran = ($target / $bulan);

                echo "<p>Target tabungan Rp " . number_format($target, 0, ',', '.') . " dicapai dalam $bulan bulan.</p>";
                echo "<table>
                        <tr>
                            <th>Bulan</th>
                            <th>Setoran</th>
                            <th>Bunga</th>
                            <th>Potongan Admin</th>
                            <th>Saldo Akhir</th>
                        </tr>";

                $saldo = 0;
                for ($i = 1; $i <= $bulan; $i++) {
                    $saldo_awal = $saldo;
                    $saldo += $setoran;

                    if ($i > 1) {
                        $bunga_bulan = $saldo_awal * $bunga;
                        $saldo += $bunga_bulan;
                        $saldo -= $admin;
                        $potongan_admin = $admin;
                    } else {
                        $bunga_bulan = 0;
                        $potongan_admin = 0;
                    }

                    $total_bunga += $bunga_bulan;
                    $total_admin += $potongan_admin;

                    echo "<tr>
                            <td>$i</td>
                            <td>Rp " . number_format($setoran, 0, ',', '.') . "</td>
                            <td>Rp " . number_format($bunga_bulan, 0, ',', '.') . "</td>
                            <td>Rp " . number_format($potongan_admin, 0, ',', '.') . "</td>
                            <td>Rp " . number_format($saldo, 0, ',', '.') . "</td>
                        </tr>";
                }
                echo "</table>";

                echo "
                <div class='hasil-akhir'>
                    <p>Total saldo akhir setelah <b>$bulan bulan</b>: <b>Rp " . number_format($saldo, 0, ',', '.') . "</b></p>
                    <p>Total bunga yang didapat: <b>Rp " . number_format($total_bunga, 0, ',', '.') . "</b></p>
                    <p>Total biaya admin yang dipotong: <b>Rp " . number_format($total_admin, 0, ',', '.') . "</b></p>
                </div>";
            } else if ($mode == "setoran") {
                $setoran = $nilai;
                $saldo = 0;
                $bulan = 0;

                echo "<table>
                        <tr>
                            <th>Bulan</th>
                            <th>Setoran</th>
                            <th>Bunga</th>
                            <th>Potongan Admin</th>
                            <th>Saldo Akhir</th>
                        </tr>";

                while ($saldo < $target) {
                    $bulan++;
                    $saldo_awal = $saldo;
                    $saldo += $setoran;

                    if ($bulan > 1) {
                        $bunga_bulan = $saldo_awal * $bunga;
                        $saldo += $bunga_bulan;
                        $saldo -= $admin;
                        $potongan_admin = $admin;
                    } else {
                        $bunga_bulan = 0;
                        $potongan_admin = 0;
                    }

                    $total_bunga += $bunga_bulan;
                    $total_admin += $potongan_admin;

                    echo "<tr>
                            <td>$bulan</td>
                            <td>Rp " . number_format($setoran, 0, ',', '.') . "</td>
                            <td>Rp " . number_format($bunga_bulan, 0, ',', '.') . "</td>
                            <td>Rp " . number_format($potongan_admin, 0, ',', '.') . "</td>
                            <td>Rp " . number_format($saldo, 0, ',', '.') . "</td>
                        </tr>";
                }

                echo "</table>";

                echo "
                <div class='hasil-akhir'>
                    <p>Total saldo akhir setelah <b>$bulan bulan</b>: <b>Rp " . number_format($saldo, 0, ',', '.') . "</b></p>
                    <p>Total bunga yang didapat: <b>Rp " . number_format($total_bunga, 0, ',', '.') . "</b></p>
                    <p>Total biaya admin yang dipotong: <b>Rp " . number_format($total_admin, 0, ',', '.') . "</b></p>
                </div>";
            }
        }
        ?>
    </div>
</body>

</html>