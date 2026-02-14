<!-- resources/views/dashboard.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pemberkasan - Telkom Akses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; background: #f4f6f9; overflow-x: hidden; }
        /* Sidebar */
        .sidebar { width: 260px; height: 100vh; position: fixed; background: linear-gradient(to bottom, #eccaca 0%, #d90429 100%); color: #fff; display: flex; flex-direction: column; padding-top: 20px; }
        .sidebar .logo { text-align: center; margin-bottom: 30px; }
        .sidebar img { height: 50px; }
        .sidebar a { display: flex; align-items: center; color: #fff; padding: 14px 25px; font-size: 15px; text-decoration: none; transition: all 0.3s; border-radius: 8px; margin: 3px 10px; }
        .sidebar a:hover { background: rgba(255,255,255,0.15); padding-left: 35px; }
        .sidebar a i { margin-right: 12px; font-size: 18px; }
        .sidebar form { margin-top: auto; padding-bottom: 20px; }
        .sidebar form button { width: 100%; background: transparent; color: #fff; border: none; font-size: 16px; text-align: left; padding: 14px 25px; cursor: pointer; display: flex; align-items: center; border-radius: 8px; transition: background 0.3s, padding-left 0.3s; }
        .sidebar form button:hover { background: rgba(255,255,255,0.15); padding-left: 35px; }
        .sidebar form button i { margin-right: 12px; font-size: 18px; }
        /* Content */
        .content { margin-left: 260px; padding: 30px; }
        .top-navbar { background: #fff; padding: 15px 25px; border-radius: 15px; box-shadow: 0 6px 18px rgba(0,0,0,0.06); margin-bottom: 30px; display: flex; justify-content: space-between; align-items: center; }
        /* Summary Cards */
        .card-icon { position: relative; color: #fff; border-radius: 15px; padding: 25px; height: 150px; overflow: hidden; box-shadow: 0 8px 20px rgba(0,0,0,0.06); transition: transform 0.2s; }
        .card-icon:hover { transform: translateY(-4px); box-shadow: 0 12px 25px rgba(0,0,0,0.1); }
        .card-icon .text { position: absolute; top: 25px; left: 25px; display: flex; flex-direction: column; }
        .card-icon .text h6 { font-size: 18px; font-weight: 600; margin: 0; }
        .card-icon .text h2 { font-size: 36px; font-weight: 700; margin: 0; }
        .card-icon .text small { font-size: 14px; }
        .card-icon .icon { position: absolute; bottom: 15px; right: 15px; font-size: 60px; color: rgba(252, 252, 252, 0.573); }
        /* Generate Form */
        .card-modern { border-radius: 15px; box-shadow: 0 8px 20px rgba(0,0,0,0.06); transition: transform 0.2s; }
        .card-modern:hover { transform: translateY(-3px); }
        .btn-primary-custom { background: #d90429; border: none; transition: all 0.3s; }
        .btn-primary-custom:hover { background: #ffffff; color: #d90429; }
        .form-control { border-radius: 10px; padding: 10px 15px; box-shadow: inset 0 2px 5px rgba(0,0,0,0.05); }
        .form-control:focus { box-shadow: 0 0 0 0.2rem rgba(253, 253, 253, 0.25); border-color: #d90429; }
        /* Riwayat Dokumen Cards */
        .doc-card { display: flex; justify-content: space-between; align-items: center; background: #fff; padding: 15px 20px; margin-bottom: 10px; border-radius: 12px; box-shadow: 0 3px 10px rgba(0,0,0,0.05); transition: transform 0.2s; }
        .doc-card:hover { transform: translateY(-2px); box-shadow: 0 6px 15px rgba(0,0,0,0.1); }
        .doc-card .doc-info { display: flex; align-items: center; gap: 15px; }
        .doc-card .doc-info i { font-size: 30px; color: #d90429; }
        .doc-card .doc-info div { display: flex; flex-direction: column; }
        .doc-card .doc-actions button, .doc-card .doc-actions a { margin-left: 5px; }
        @media(max-width: 768px) { .sidebar { width: 200px; } .content { margin-left: 200px; padding: 20px; } .card-icon { height: 140px; padding: 20px; } .card-icon .icon { font-size: 50px; } .card-icon .text h2 { font-size: 28px; } }
    </style>
</head>
<body>

<div class="sidebar">
    <div class="logo"><img src="{{ asset('images/telkom-akses-seeklogo.png') }}"></div>
    <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i><span> Dashboard</span></a>
    <a href="{{ route('document.generate.form') }}"><i class="bi bi-file-earmark-text"></i><span> Generate Dokumen</span></a>
    <form method="POST" action="{{ route('logout') }}">@csrf<button><i class="bi bi-box-arrow-right"></i> Logout</button></form>
</div>

<div class="content">
    <div class="top-navbar">
        <h5 class="mb-0 fw-semibold">Dashboard</h5>
        <span class="text-muted">{{ Auth::user()->name ?? 'User' }}</span>
    </div>

    <!-- Dashboard View -->
    @if(request()->routeIs('dashboard'))
    <div class="row mb-4 g-4">
        <div class="col-md-6">
            <div class="card-icon" style="background: linear-gradient(135deg, #d90429, #d81414);">
                <div class="text">
                    <h6>Total Dokumen Dibuat</h6>
                    <h2>{{ count(glob(storage_path('app/public/generated/*.pdf'))) }}</h2>
                    <small>File PDF generated</small>
                </div>
                <i class="bi bi-file-earmark-text icon"></i>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-icon" style="background: linear-gradient(135deg, #d90429, #d90429);">
                <div class="text">
                    <h6>Pengguna</h6>
                    <h2>{{ count(session()->all()) > 0 ? '5' : '0' }}</h2>
                    <small>Orang Terdaftar</small>
                </div>
                <i class="bi bi-people icon"></i>
            </div>
        </div>
    </div>

    <h6 class="mb-3 fw-semibold"><i class="bi bi-folder2-open"></i> Riwayat Dokumen</h6>
    @php $files = glob(storage_path('app/public/generated/*.pdf')); @endphp
    @forelse($files as $index => $file)
        @php $filename = basename($file); @endphp
        <div class="doc-card">
            <div class="doc-info">
                <i class="bi bi-file-earmark-pdf"></i>
                <div>
                    <strong>{{ $filename }}</strong>
                    <small>{{ date("d-m-Y H:i", filemtime($file)) }}</small>
                </div>
            </div>
            <div class="doc-actions">
                <a href="{{ asset('storage/generated/' . $filename) }}" target="_blank" class="btn btn-sm btn-info">Lihat</a>
                <a href="{{ route('download', $filename) }}" class="btn btn-sm btn-success">Download</a>
                <form action="{{ route('document.rename') }}" method="POST" class="d-inline">
                    @csrf
                    <input type="hidden" name="old_name" value="{{ $filename }}">
                    <input type="text" name="new_name" class="form-control form-control-sm d-inline w-auto" required placeholder="Nama baru">
                    <button class="btn btn-sm btn-warning">Ubah</button>
                </form>
                <form action="{{ route('document.delete', $filename) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus file ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-muted">Belum ada dokumen dibuat</p>
    @endforelse
    @endif

    <!-- Generate Form View -->
    @if(request()->routeIs('document.generate.form'))
    <div class="card card-modern mb-4 p-4">
        <h6 class="mb-3 fw-semibold"><i class="bi bi-file-earmark-text"></i> Generate Dokumen</h6>

        <form method="POST" action="{{ route('document.generate') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Upload Template DOCX</label>
                <input type="file" name="template" class="form-control" required>
            </div>

            <div class="row">
                @foreach([
                    'proyek','kontrak','surat_pesanan','witel','lokasi','pelaksana',
                    'tanggal_kontrak','nama_telkom','nik_telkom','nama_akses','nik_akses',
                    'hari','tanggal','bulan','tahun','pengadaan','area','id_ihld','no_amd',
                    'pemasangan','tim_uji_telkom','nik_tim_uji_telkom','tim_uji_akses','nik_tim_uji_akses','no_kontrak'
                ] as $field)
                <div class="col-md-6 mb-3">
                    <input type="text" name="{{ $field }}" class="form-control" placeholder="{{ strtoupper(str_replace('_',' ',$field)) }}" required>
                </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary-custom text-white px-4 mt-2">
                Generate & Preview
            </button>
        </form>
    </div>
    @endif
</div>
</body>
</html>
