<!DOCTYPE html>
<html>
<head>
    <title>Isi Dokumen</title>
</head>
<body>

<h2>Form Isi Dokumen</h2>

<form method="POST" action="/document/generate">
    @csrf

    <label>PROYEK:</label><br>
    <input type="text" name="proyek"><br><br>

    <label>KONTRAK:</label><br>
    <input type="text" name="kontrak"><br><br>

    <label>SURAT PESANAN:</label><br>
    <input type="text" name="surat_pesanan"><br><br>

    <label>WITEL:</label><br>
    <input type="text" name="witel"><br><br>

    <label>LOKASI:</label><br>
    <input type="text" name="lokasi"><br><br>

    <label>PELAKSANA:</label><br>
    <input type="text" name="pelaksana"><br><br>

    <button type="submit">Generate Dokumen</button>
</form>

</body>
</html>
