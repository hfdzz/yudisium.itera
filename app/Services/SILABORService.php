<?php
    
/**
 * Silabor API Service
 * 
 * This service is used to interact with SILABOR API
 * 
 * CURL Request return type:
 * JSON Object
 * 
 * CURL Request JSON Structure:
 * {
 * "success": boolean,
 * "message": string,
 * "data": array
 * }
 * 
 * CURL Request JSON "data" object Structure:
 * {
 * "id_bebaslab": int,
 * "nim": string,
 * "nama_mhs": string,
 * "nama_prodi": string,
 * "nama_jurusan": string,
 * "status": string,
 * "keperluan": string,
 * "keterangan": string,
 * "surat": string,
 * }
 * 
 * status: "Selesai" | "Ditolak" | "Menunggu" (not verified yet)
 * 
 */

namespace App\Services;

class SILABORService
{
    protected $client;
    protected $cache;
    protected $cacheKey;
    protected $silaborConfig;
    protected $refreshCache;
    
    public function __construct()
    {
        /** @var \CodeIgniter\HTTP\CURLRequest $client */
        $this->client = service('curlrequest');
        /** @var \CodeIgniter\Cache\CacheInterface $cache */
        $this->cache = service('cache');
        $this->cacheKey = 'bebasLab';
        /** @var \Config\SILABOR $silaborConfig */
        $this->silaborConfig = config('SILABOR');
        
        $this->refreshCache = $this->silaborConfig->refreshCache ?? false;

        $this->urlConfigCheck();
    }

    static function withRefreshCache($refresh = true) : self
    {
        $instance = new self();
        if ($refresh) {
            $instance->refreshCache = true;
        }
        return $instance;
    }

    // CURL Request to SILABOR API to get all Bebas Lab
    protected function requestAllBebasLab() : array
    {
        try {
            $response = $this->client->request('GET', $this->silaborConfig->silaborAPIURL['getAllBebasLabURL']);
            
            if ($response->getStatusCode() != 200 || $response->getBody() == null) {
                return [];
            }

            $result = json_decode($response->getBody());

            if (!$result) {
                return [];
            }

            $result = json_decode($response->getBody())->data;

            // Normalize status
            foreach ($result as $data) {
                $data->status = $this->normalizeBebasLabStatus($data->status);
            }

            return $result;

        } catch (\Exception $e) {
            // throw $e;
            return [];
        }
    }

    protected function normalizeBebasLabStatus($status) : string
    {
        switch ($status) {
            case 'Selesai':
                return STATUS_SELESAI;
            case 'Ditolak':
                return STATUS_DITOLAK;
            default:
                return STATUS_MENUNGGU_VALIDASI;
        }
    }

    public function getAllBebasLab() : array
    {
        if ($this->refreshCache) {
            $this->cache->delete($this->cacheKey);
        }
        elseif ($this->cache->get($this->cacheKey)) {
            return $this->cache->get($this->cacheKey);
        }

        $data = $this->requestAllBebasLab();

        $this->cache->save($this->cacheKey, $data, 3600);

        return $data;
    }

    public function getBebasLabByNim($nim_search, $status = null) : array
    {
        $result = array();
        foreach ($this->getAllBebasLab() as $data) {
            if ($data->nim == $nim_search) {
                if ($status) {
                    if ($data->status !== $status) {
                        continue;
                    }
                }
                $result[] = new SkBebasLaboratorium($data);
            }
        }
        return $result;
    }

    public function getBebasLabSelesaiByNim($nim_search) : array
    {
        return $this->getBebasLabByNim($nim_search, STATUS_SELESAI);
    }

    public function isBebasLabSelesai($nim_search) : bool
    {
        // return count($this->getBebasLabSelesaiByNim($nim_search)) > 0;
        return $this->getLatestBebasLabByNim($nim_search)->status == STATUS_SELESAI;
    }

    public function getLatestBebasLabByNim($nim_search)
    {
        // sort by (in-order priority):
        // 1. status: Selesai > Ditolak > Menunggu
        // 2. id_bebaslab: descending
        $bebasLab = $this->getBebasLabByNim($nim_search);
        usort($bebasLab, function ($a, $b) {
            // sort by id_bebaslab if status is the same
            if ($a->status == $b->status) {
                return $b->id_bebaslab - $a->id_bebaslab;
            }
            // sort by status
            return $a->status == STATUS_SELESAI ? -1 : ($a->status == STATUS_DITOLAK ? 1 : 0);
        });
        return !empty($bebasLab[0]) ? new SkBebasLaboratorium($bebasLab[0]) : null;
    }

    protected function urlConfigCheck() : void
    {
        if (
            !filter_var($this->silaborConfig->silaborAPIURL['getAllBebasLabURL'], FILTER_VALIDATE_URL)
            ) 
        {
            throw new \Exception('SILABOR Sercive configuration is not set properly');
        }
    }
}

class SkBebasLaboratorium
{
    public $id_bebaslab;
    public $nim;
    public $nama_mhs;
    public $nama_prodi;
    public $nama_jurusan;
    public $status;
    public $keperluan;
    public $keterangan;
    public $surat;

    public function __construct($data)
    {
        $this->id_bebaslab = $data->id_bebaslab;
        $this->nim = $data->nim;
        $this->nama_mhs = $data->nama_mhs;
        $this->nama_prodi = $data->nama_prodi;
        $this->nama_jurusan = $data->nama_jurusan;
        $this->status = $data->status;
        $this->keperluan = $data->keperluan;
        $this->keterangan = $data->keterangan;
        $this->surat = $data->surat;
    }

    public function getJenis($humanize = false)
    {
        return $humanize ? 'Surat Keterangan Bebas Laboratorium' : JENIS_SK_BEBAS_LABORATORIUM;
    }

    public function isSelesai()
    {
        return $this->status == STATUS_SELESAI;
    }

    public function isMenungguValidasi()
    {
        return $this->status == STATUS_MENUNGGU_VALIDASI;
    }
}