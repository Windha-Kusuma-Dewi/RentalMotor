<?php
class Data {
    public $member;
    public $jenis;
    public $waktu;
    public $diskon;
    protected $pajak;
    private $Beat, $Vario, $NMax, $Mio;
    private $listMember = ['ana', 'gina', 'dina', 'lina'];

    public function __construct() {
        $this->pajak = 10000;
    }

    public function getMember() {
        // Menggunakan strtolower saat memeriksa status member
        if (in_array(strtolower($this->member), $this->listMember)) {
            return "Member";
        } else {
            return "Non Member";
        }
    }

    public function setHarga($jenis1, $jenis2, $jenis3, $jenis4) {
        $this->Beat = $jenis1;
        $this->Vario = $jenis2;
        $this->NMax = $jenis3;
        $this->Mio = $jenis4;
    }

    public function getHarga() {
        $data["Beat"] = $this->Beat;
        $data["Vario"] = $this->Vario;
        $data["NMax"] = $this->NMax;
        $data["Mio"] = $this->Mio;
        return $data;
    }
}

class Rental extends Data {
    public function hargaRental() {
        $dataHarga = $this->getHarga()[$this->jenis];
        $diskon = $this->getMember() == "Member" ? 5 : 0;
        if ($this->waktu === 1) {
            $bayar = ($dataHarga - ($dataHarga * $diskon / 100)) + $this->pajak;
        } else {
            $bayar = (($dataHarga * $this->waktu) - ($dataHarga * $diskon / 100)) + $this->pajak;
        }
        return [$bayar, $diskon];
    }

    public function pembayaran() {
        echo "<center>";
        echo $this->member . " berstatus sebagai " . $this->getMember() . " mendapatkan diskon sebesar " . $this->hargaRental()[1] . "%";
        echo "<br />";
        echo "Jenis motor yang dirental adalah " . $this->jenis . " selama " . $this->waktu . " hari ";
        echo "<br />";
        echo "Harga rental per-harinya : Rp. " . number_format($this->getHarga()[$this->jenis], 0, ',', '.');
        echo "<br />";
        echo "<br />";
        echo "Besar yang harus dibayarkan adalah Rp. " . number_format($this->hargaRental()[0], 0, ',', '.');
        echo "</center>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="rentalmotor.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .navbar {
            overflow: hidden;
            background-color: #333;
        }

        .navbar a {
            float: left;
            color: #f2f2f2;
            text-align: center;
            padding: 14px 700px;
            text-decoration: none;
            font-weight: bold;
            font-size: 20px;
        }

        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#home">Rental Motor</a>
    </div>

    <div class="content">
        <center>
            <table>
                <form action="" method="post">
                    <tr>
                        <td>Nama Pelanggan</td>
                        <td>:</td>
                        <td><input type="text" name="nama" required autocomplete="off"></td>
                    </tr>
                    <tr>
                        <td>Lama Waktu Rental (Per hari)</td>
                        <td>:</td>
                        <td><input type="text" name="lamaRental" required autocomplete="off"></td>
                    </tr>
                    <tr>
                        <td>Jenis Motor</td>
                        <td>:</td>
                        <td>
                            <select name="jenis" required>
                                <option value="">Pilih Jenis Motor</option>
                                <option value="Beat">Beat</option>
                                <option value="Vario">Vario</option>
                                <option value="NMax">NMax</option>
                                <option value="Mio">Mio</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td colspan="2"><input type="submit" value="Submit" name="submit"></td>
                    </tr>
                </form>
            </table>
            <div style="border: 1px solid black; width: 40%; padding: 10px; margin: 10px">
                <?php
                // Menampilkan hasil dari pembayaran
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $proses = new Rental();
                    $proses->setHarga(70000, 80000, 90000, 100000);
                    $proses->member = strtolower($_POST['nama']);
                    $proses->jenis = $_POST['jenis'];
                    $proses->waktu = $_POST['lamaRental'];

                    $proses->pembayaran();
                }
                ?>
            </div>
        </center>
    </div>
</body>
</html>
