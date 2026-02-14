<!DOCTYPE html>
<html>
<head>
    <title>Preview Dokumen</title>
</head>
<body>

<h2>Dokumen Berhasil Dibuat</h2>

<a href="{{ route('document.download', $file) }}">
    Download Dokumen
</a>

<br><br>

<a href="/document">Kembali</a>

</body>
</html>
