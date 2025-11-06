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

        .container {
            width: 600px;
            background: white;
            margin: 40px auto;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        h2,
        h1 {
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
    </style>
</head>

<body>
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
            $jenis_bunga = isset($_POST['jenis_bunga']) ? $_POST['jenis_bunga'] : 'awal';
            $bunga  = 0.0335;
            $admin  = 12500;


            echo "<h1>Hasil Perhitungan</h1>";

            // ============== METODE TARGET BULAN ===================
            if ($mode == "bulan") {
                $bulan = $nilai;
                $setoran = ($target / $bulan);

                echo "<p>Target tabungan Rp " . number_format($target, 0, ',', '.') . " dicapai dalam $bulan bulan.</p>";
                echo "<table>
                        <tr>
                            <th>Bulan</th>
                            <th>Setoran</th>
                            <th>Bunga</th>
                            <th>Saldo Akhir</th>
                        </tr>";

                $saldo = 0;
                for ($i = 1; $i <= $bulan; $i++) {
                    $saldo_awal = $saldo;
                    $saldo += $setoran;

                    if ($i > 1) {
                        if ($jenis_bunga == "awal") {
                            $bunga_bulan = $saldo_awal * $bunga;
                        } else {
                            $bunga_bulan = $saldo * $bunga;
                        }
                        $saldo += $bunga_bulan;
                        $saldo -= $admin;
                    } else {
                        $bunga_bulan = 0;
                    }

                    echo "<tr>
                            <td>$i</td>
                            <td>Rp " . number_format($setoran, 0, ',', '.') . "</td>
                            <td>Rp " . number_format($bunga_bulan, 0, ',', '.') . "</td>
                            <td>Rp " . number_format($saldo, 0, ',', '.') . "</td>
                        </tr>";
                }
                echo "</table>";
                echo "<p><b>Total Saldo Akhir: Rp " . number_format($saldo, 0, ',', '.') . "</b></p>";
            }

            // ============== METODE SETORAN TETAP ===================
            else if ($mode == "setoran") {
                $setoran = $nilai;
                $saldo = 0;
                $bulan = 0;

                echo "<table>
                        <tr>
                            <th>Bulan</th>
                            <th>Setoran</th>
                            <th>Bunga</th>
                            <th>Saldo Akhir</th>
                        </tr>";

                while ($saldo < $target) {
                    $bulan++;
                    $saldo_awal = $saldo;
                    $saldo += $setoran;

                    if ($bulan > 1) {
                        if ($jenis_bunga == "awal") {
                            $bunga_bulan = $saldo_awal * $bunga;
                        } else {
                            $bunga_bulan = $saldo * $bunga;
                        }
                        $saldo += $bunga_bulan;
                        $saldo -= $admin;
                    } else {
                        $bunga_bulan = 0;
                    }

                    echo "<tr>
                            <td>$bulan</td>
                            <td>Rp " . number_format($setoran, 0, ',', '.') . "</td>
                            <td>Rp " . number_format($bunga_bulan, 0, ',', '.') . "</td>
                            <td>Rp " . number_format($saldo, 0, ',', '.') . "</td>
                        </tr>";
                }

                echo "</table>";
                echo "<p>Dengan setoran Rp " . number_format($setoran, 0, ',', '.') .
                    " per bulan, target Rp " . number_format($target, 0, ',', '.') .
                    " tercapai dalam <b>$bulan bulan</b>.</p>";
            }
        }
        ?>
    </div>
</body>

</html>