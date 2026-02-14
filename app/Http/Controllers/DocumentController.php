<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpWord\TemplateProcessor;

class DocumentController extends Controller
{
    public function dashboard()
    {
        return view('dashboard');
    }

    public function generate(Request $request)
    {
         $request->validate([
        'template' => 'required|mimes:docx',
        'proyek' => 'required',
        'kontrak' => 'required',
        'surat_pesanan' => 'required',
        'witel' => 'required',
        'lokasi' => 'required',
        'pelaksana' => 'required',

        // TAMBAHAN VALIDASI
        'tanggal_kontrak' => 'required',
        'nama_telkom' => 'required',
        'nik_telkom' => 'required',
        'nama_akses' => 'required',
        'nik_akses' => 'required',
        'hari' => 'required',
        'tanggal' => 'required',
        'bulan' => 'required',
        'tahun' => 'required',
        'pengadaan' => 'required',
        'area' => 'required',
        'id_ihld' => 'required',
        'no_amd' => 'required',
        'pemasangan' => 'required',
        'tim_uji_telkom' => 'required',
        'nik_tim_uji_telkom' => 'required',
        'tim_uji_akses' => 'required',
        'nik_tim_uji_akses' => 'required',
        'no_kontrak' => 'required',
    ]);

        /*
        |--------------------------------------------------------------------------
        | 1. Folder Temp
        |--------------------------------------------------------------------------
        */

        $tempFolder = storage_path('app/temp');
        if (!file_exists($tempFolder)) {
            mkdir($tempFolder, 0777, true);
        }

        $uploadedFile = $request->file('template');
        $tempFileName = time() . '_' . $uploadedFile->getClientOriginalName();
        $uploadedFile->move($tempFolder, $tempFileName);

        $fullTemplatePath = $tempFolder . '/' . $tempFileName;

        if (!file_exists($fullTemplatePath)) {
            return back()->with('error', 'Template gagal disimpan.');
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Load Template
        |--------------------------------------------------------------------------
        */

        $templateProcessor = new TemplateProcessor($fullTemplatePath);

        /*
        |--------------------------------------------------------------------------
        | 3. Isi Placeholder (Lowercase + Uppercase Support)
        |--------------------------------------------------------------------------
        */

         $data = [
            
        'proyek'        => $request->proyek,
        'kontrak'       => $request->kontrak,
        'surat_pesanan' => $request->surat_pesanan,
        'witel'         => $request->witel,
        'lokasi'        => $request->lokasi,
        'pelaksana'     => $request->pelaksana,
        'tanggal_kontrak' => $request->tanggal_kontrak,
        'nama_telkom'     => $request->nama_telkom,
        'nik_telkom'      => $request->nik_telkom,
        'nama_akses'      => $request->nama_akses,
        'nik_akses'       => $request->nik_akses,
        'hari'            => $request->hari,
        'tanggal'         => $request->tanggal,
        'bulan'           => $request->bulan,
        'tahun'           => $request->tahun,
        'pengadaan'       => $request->pengadaan,
        'area'            => $request->area,
        'id_ihld'         => $request->id_ihld,
        'no_amd'          => $request->no_amd,
        'pemasangan'      => $request->pemasangan,
        'tim_uji_telkom'  => $request->tim_uji_telkom,
        'nik_tim_uji_telkom' => $request->nik_tim_uji_telkom,
        'tim_uji_akses'   => $request->tim_uji_akses,
        'nik_tim_uji_akses'  => $request->nik_tim_uji_akses,
        'no_kontrak'       => $request->no_kontrak,
    ];

        foreach ($data as $key => $value) {
            $templateProcessor->setValue($key, $value);                 // ${proyek}
            $templateProcessor->setValue(strtoupper($key), $value);     // ${PROYEK}
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Folder Generated
        |--------------------------------------------------------------------------
        */

        $generatedFolder = storage_path('app/public/generated');
        if (!file_exists($generatedFolder)) {
            mkdir($generatedFolder, 0777, true);
        }

        $fileName = 'Dokumen_' . time();
        $docxName = $fileName . '.docx';
        $pdfName  = $fileName . '.pdf';

        $docxPath = $generatedFolder . '/' . $docxName;
        $pdfPath  = $generatedFolder . '/' . $pdfName;

        $templateProcessor->saveAs($docxPath);

        /*
        |--------------------------------------------------------------------------
        | 5. Convert ke PDF (Full Path Windows)
        |--------------------------------------------------------------------------
        */

        $libreOfficePath = '"C:\Program Files\LibreOffice\program\soffice.exe"';

        $command = $libreOfficePath
            . ' --headless --convert-to pdf '
            . escapeshellarg($docxPath)
            . ' --outdir '
            . escapeshellarg($generatedFolder)
            . ' 2>&1';

        exec($command, $output, $returnCode);

        /*
        |--------------------------------------------------------------------------
        | 6. Validasi Convert
        |--------------------------------------------------------------------------
        */

        if (!file_exists($pdfPath)) {
            return back()->with('error',
                'Convert ke PDF gagal. Detail: ' . implode("\n", $output)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 7. Hapus Temp
        |--------------------------------------------------------------------------
        */

        if (file_exists($fullTemplatePath)) {
            unlink($fullTemplatePath);
        }

        return redirect()
            ->route('dashboard')
            ->with('preview', $pdfName)
            ->with('success', 'Dokumen berhasil dibuat.');
    }

    public function download($file)
    {
        $path = storage_path('app/public/generated/' . $file);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path);
    }
    public function rename(Request $request)
    {
        $request->validate([
            'old_name' => 'required|string',
            'new_name' => 'required|string',
        ]);

        $generatedFolder = storage_path('app/public/generated');
        $oldPath = $generatedFolder . '/' . $request->old_name;
        $newFile = preg_replace('/[^A-Za-z0-9_\-]/', '_', $request->new_name) . '.pdf';
        $newPath = $generatedFolder . '/' . $newFile;

        if (!file_exists($oldPath)) {
            return back()->with('error', 'File tidak ditemukan!');
        }

        if (file_exists($newPath)) {
            return back()->with('error', 'Nama file baru sudah ada!');
        }

        rename($oldPath, $newPath);

        return back()->with('success', 'File berhasil diubah namanya!');
    }

    public function delete($filename)
    {
        $generatedFolder = storage_path('app/public/generated');
        $path = $generatedFolder . '/' . $filename;

        if (file_exists($path)) {
            unlink($path);
            return back()->with('success', 'File berhasil dihapus permanen!');
        }

        return back()->with('error', 'File tidak ditemukan!');
    }

    public function showGenerateForm()
    {
    return view('dashboard', ['showGenerate' => true]); // nanti Blade bisa pakai kondisi
    }
   
}
