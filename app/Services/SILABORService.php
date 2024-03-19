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

use CodeIgniter\Config\Services;

class SILABORService
{
    protected $client;
    protected $cache;
    protected $cacheKey;
    protected $silaborConfig;
    protected $refreshCache;
    
    public function __construct()
    {
        $this->client = Services::curlrequest();
        $this->cache = Services::cache();
        $this->cacheKey = 'bebasLab';
        /**
         * @var \Config\CURLRequest $silaborConfig
         */
        $this->silaborConfig = config('CURLRequest');
        
        // TODO: change to false when deploying to production or when testing
        $this->refreshCache = true;
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
            $result = json_decode($response->getBody())->data;

            // Normalize status
            foreach ($result as $data) {
                $data->status = $this->normalizeBebasLabStatus($data->status);
            }

            return $result;

        } catch (\Exception $e) {
            throw $e;
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

    public function getAllBebasLab()
    {
        if ($this->refreshCache) {
            $this->cache->delete($this->cacheKey);
        }
        
        if ($this->cache->get($this->cacheKey)) {
            return $this->cache->get($this->cacheKey);
        }

        $data = $this->requestAllBebasLab();

        $this->cache->save($this->cacheKey, $data, 3600);

        return $data;
    }

    // public function getBebasLabById($id_search, $refresh = false) : object | null
    // {
    //     foreach ($this->getAllBebasLab($refresh) as $data) {
    //         if ($data->id_bebaslab == $id_search) {
    //             return $data;
    //         }
    //     }
    //     return null;
    // }

    public function getBebasLabByNim($nim_search, $status = null) : array
    {
        $result = array();
        foreach ($this->getAllBebasLab() as $data) {
            if ($data->nim == $nim_search) {
                if ($status) {
                    if ($data->status == $status) {
                        $result[] = $data;
                    }
                } else {
                    $result[] = $data;
                }
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
            if ($a->status == $b->status) {
                return $b->id_bebaslab - $a->id_bebaslab;
            }
            return $a->status == STATUS_SELESAI ? -1 : ($a->status == STATUS_DITOLAK ? 1 : 0);
        });
        return $bebasLab ? $bebasLab[0] : null;
    }
}