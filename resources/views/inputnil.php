<html>
<head>
    <title>Add Data</title>
</head>

<body>
    <a href="tampilnil.php">Kembali</a>
    <br/><br/>

    <form action="inputnil.php" method="post" name="form1">
        <table width="25%" border="1">
          <h2>Input Data Nilai</h2>
            <tr>
                <td>Nis</td>
                <td><input type="text" name="nis"></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td><input type="text" name="nama"></td>
            </tr>
            <tr>
                <td>Jurusan</td>
                <td><input type="text" name="jurusan"></td>
            </tr>
            <tr>
                <td>Matakuliah</td>
                <td><input type="text" name="matakuliah"></td>
            </tr>
            <tr>
                <td>Nmid</td>
                <td><input type="text" name="nmid"></td>
            </tr>
            <tr>
                <td>Nsem</td>
                <td><input type="text" name="nsem"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" name="submit" value="Simpan"></td>
            </tr>
        </table>
    </form>

    <?php

    // Check If form submitted, insert form data into users table.
    if(isset($_POST['submit'])) {
        $nis = $_POST['nis'];
        $nama = $_POST['nama'];
        $jurusan = $_POST['jurusan'];
        $matakuliah = $_POST['matakuliah'];
        $nmid = $_POST['nmid'];
        $nsem = $_POST['nsem'];

        // include database connection file
        include_once("connect.php");

        // Insert user data into table
        $result = mysqli_query($con, "INSERT INTO nilai(nis,nama,jurusan,matakuliah,nmid,nsem) VALUES('$nis','$nama','$jurusan','$matakuliah','$nmid','$nsem')");

        // Show message when user added
        echo "Data berhasil ditambahkan. <a href='tampilnil.php'>Lihat data</a>";
    }
    ?>
</body>
</html>
