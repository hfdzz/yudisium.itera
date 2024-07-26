<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class UptPerpustakaanController extends BaseController
{
    protected $helpers = ['form'];

    public function dashboard()
    {
        // Dashboard for upt_perpustakaan
        $data = [
            'belum_mengajukan' => 0,
            'selesai' => 0,
        ];

        /** @var \App\Models\YudisiumPendaftaranModel $pendaftaran_model */
        $model = model('SuratKeteranganModel');

        $data['belum_divalidasi'] = $model->where('surat_keterangan.jenis_surat', JENIS_SK_BEBAS_PERPUSTAKAAN)
            ->where('surat_keterangan.status', STATUS_MENUNGGU_VALIDASI)
            ->countAllResults();

        $data['selesai'] = $model->where('surat_keterangan.jenis_surat', JENIS_SK_BEBAS_PERPUSTAKAAN)
            ->where('surat_keterangan.status', STATUS_SELESAI)
            ->orWhere('surat_keterangan.jenis_surat', STATUS_SELESAI_BEASISWA)
            ->orWhere('surat_keterangan.status', STATUS_DITOLAK)
            ->countAllResults();

        return view('upt_perpustakaan/dashboard', $data);
    }

    public function validasiSuratKeterangan()
    {
        if (! $this->request->is('post')) {
            /** @var \App\Models\SuratKeteranganModel $suratKeteranganModel */
            $suratKeteranganModel = model('SuratKeteranganModel');

            $db = db_connect();

            // list of month and year for filter
            $tanggal_pengajuan_month_year_list = $db->table('surat_keterangan')
                ->select('DATE_FORMAT(tanggal_pengajuan, "%m") month, DATE_FORMAT(tanggal_pengajuan, "%Y") year')
                ->where('surat_keterangan.jenis_surat', JENIS_SK_BEBAS_PERPUSTAKAAN)
                ->groupBy('year(tanggal_pengajuan), month(tanggal_pengajuan)')
                ->orderBy('year(tanggal_pengajuan)', 'desc')
                ->orderBy('month(tanggal_pengajuan)', 'desc')
                ->get()
                ->getResultArray();
            
            // get filter value
            $get_tanggal_pengajuan = (string)$this->request->getGet('tanggal_pengajuan');
            $get_tanggal_pengajuan_array = explode('_', $get_tanggal_pengajuan);
            
            $tanggal_pengajuan_filter = count($get_tanggal_pengajuan_array) === 2 ?
                [['month' => $get_tanggal_pengajuan_array[0], 'year' => $get_tanggal_pengajuan_array[1]]] : null;

            // get data
            $query = $suratKeteranganModel->where('surat_keterangan.jenis_surat', JENIS_SK_BEBAS_PERPUSTAKAAN)
                ->where('surat_keterangan.status', STATUS_MENUNGGU_VALIDASI)
                ->orderBy('tanggal_pengajuan', 'asc')
                ->join('users', 'users.id = surat_keterangan.mahasiswa_id')
                ->select('surat_keterangan.*, users.username as mahasiswa_username, users.nim as mahasiswa_nim, users.program_studi as mahasiswa_program_studi');
            
            if ($tanggal_pengajuan_filter) {
                $query->where('YEAR(tanggal_pengajuan)', (int)$tanggal_pengajuan_filter[0]['year'])
                    ->where('MONTH(tanggal_pengajuan)', (int)$tanggal_pengajuan_filter[0]['month']);
            }

            $data = [
                'surat_keterangan' => $query->findAll(),
                'tanggal_pengajuan_month_year_list' => $tanggal_pengajuan_month_year_list,
                'tanggal_pengajuan_filter' => $get_tanggal_pengajuan,
                'pager' => $suratKeteranganModel->pager,
            ];

            return view('upt_perpustakaan/validasi_surat_keterangan', $data);
        }

        $data = $this->request->getPost();

        // dd($data);

        $rules = [
            'id' => 'required|numeric',
            'action' => [
                'rules' => 'required|in_list[validasi,tolak]',
                'errors' => [
                    'in_list' => 'Invalid action.'
                ]
            ]
        ];

        if ($data['action'] === 'validasi') {
            $rules['nomor_surat'] = [
                'label' => 'Nomor Surat',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi.'
                ]
            ];
        }

        if (! $this->validateData($data, $rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        /** @var \App\Entities\SuratKeterangan $skEntity */
        $skEntity = model('SuratKeteranganModel')->find($data['id']);

        $action = $data['action'];

        // Check if action is previosly done
        if ($skEntity->status !== STATUS_MENUNGGU_VALIDASI) {
            return redirect()->route('upt_perpustakaan.validasi_surat_keterangan')->with('error', 'Surat keterangan sudah divalidasi atau ditolak sebelumnya.');
        }

        switch ($action) {
            case 'validasi':
                $skEntity->validasi(auth()->user()->id, $data['nomor_surat'], $data['keterangan']);
                break;
            case 'tolak':
                $skEntity->tolak(auth()->user()->id, $data['keterangan']);
                break;
        }

        if (model('SuratKeteranganModel')->errors()) {
            return redirect()->route('upt_perpustakaan.validasi_surat_keterangan')->with('errors', model('SuratKeteranganModel')->errors());
        }

        return redirect()->route('upt_perpustakaan.validasi_surat_keterangan')->with('success', 'Surat keterangan berhasil ' . ($action === 'validasi' ? 'divalidasi' : 'ditolak'));
    }
}
