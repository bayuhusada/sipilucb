<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * HTTP client untuk API SEVIMA SIAKAD Cloud.
 * Kredensial diambil dari config (getenv). Pesan error di-redact.
 */
class Sevima_api
{
    protected $base_url;
    protected $app_key;
    protected $secret_key;
    protected $timeout;
    protected $rate_limit_retry;
    protected $rate_limit_wait;
    protected $request_delay;
    protected $per_page = 100;

    public function __construct()
    {
        $CI =& get_instance();
        $CI->config->load('sevima', true);
        $this->base_url   = rtrim((string) $CI->config->item('base_url', 'sevima'), '/');
        $this->app_key    = (string) $CI->config->item('app_key', 'sevima');
        $this->secret_key = (string) $CI->config->item('secret_key', 'sevima');
        $this->timeout    = (int) $CI->config->item('timeout', 'sevima');
        $this->rate_limit_retry = (int) $CI->config->item('rate_limit_retry', 'sevima');
        $this->rate_limit_wait  = (int) $CI->config->item('rate_limit_wait', 'sevima');
        $this->request_delay    = (float) $CI->config->item('request_delay', 'sevima');
    }

    public function is_configured()
    {
        return $this->app_key !== '' && $this->secret_key !== '';
    }

    /**
     * Mengambil seluruh dosen (loop pagination) dalam satu array item.
     * Setiap item: array JSON:API {id, attributes, relationships} atau item polos.
     */
    public function fetch_all_dosen()
    {
        if (!$this->is_configured()) {
            throw new Exception('SEVIMA_APP_KEY / SEVIMA_SECRET_KEY belum diset. Isi file .env di root proyek.');
        }

        $items = array();
        $page = 1;
        $last_page = null;

        while (true) {
            $response = $this->_get('/dosen', array('page' => $page, 'limit' => $this->per_page));
            $batch = $this->_extract_items($response);
            if (empty($batch)) break;

            if ($last_page === null && isset($response['meta']['last_page'])) {
                $last_page = (int) $response['meta']['last_page'];
            }

            $items = array_merge($items, $batch);

            if ($last_page !== null && $page >= $last_page) break;
            if ($last_page === null && count($batch) < $this->per_page) break;
            $page++;
        }

        return $items;
    }

    /**
     * Satu halaman data kelas (/kelas). Response mentah (memuat meta.last_page).
     * Ada jeda antar halaman untuk menghindari rate limit (429).
     */
    public function fetch_kelas_page($page)
    {
        if ($this->request_delay > 0 && $page > 1) {
            usleep((int) ($this->request_delay * 1000000));
        }
        return $this->_get('/kelas', array('page' => (int) $page, 'limit' => $this->per_page));
    }

    /**
     * Mengambil data program studi (/program-studi). Return array item yang cocok
     * dengan $id (mis. 86206 = PGSD) atau null jika tidak ditemukan.
     */
    public function fetch_program_studi($id)
    {
        if (!$this->is_configured()) {
            throw new Exception('SEVIMA_APP_KEY / SEVIMA_SECRET_KEY belum diset. Isi file .env di root proyek.');
        }

        $response = $this->_get('/program-studi', array('limit' => $this->per_page));
        $items = $this->_extract_items($response);

        foreach ($items as $item) {
            if (!is_array($item)) continue;
            $item_id = isset($item['id']) ? $item['id'] : (isset($item['attributes']['kode_program_studi']) ? $item['attributes']['kode_program_studi'] : null);
            if ($item_id !== null && (string) $item_id === (string) $id) {
                return $item;
            }
        }

        return null;
    }

    /**
     * Menangani bentuk pembungkus respons yang beragam.
     */
    protected function _extract_items($response)
    {
        if (isset($response['data']) && is_array($response['data'])) return $response['data'];
        if (isset($response['results']) && is_array($response['results'])) return $response['results'];
        if (isset($response['items']) && is_array($response['items'])) return $response['items'];
        if (is_array($response) && isset($response[0]) && is_array($response[0])) return $response;
        return array();
    }

    protected function _get($path, $params = array())
    {
        $url = $this->base_url . $path;
        if (!empty($params)) $url .= '?' . http_build_query($params);

        $attempt = 0;
        while (true) {
            $attempt++;

            $ch = curl_init($url);
            curl_setopt_array($ch, array(
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => $this->timeout,
                CURLOPT_CONNECTTIMEOUT => 10,
                CURLOPT_HTTPHEADER => array(
                    'X-App-Key: ' . $this->app_key,
                    'X-Secret-Key: ' . $this->secret_key,
                    'Accept: application/json',
                ),
            ));

            $body = curl_exec($ch);
            $status = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $errno = curl_errno($ch);
            $error = curl_error($ch);
            curl_close($ch);

            if ($errno !== 0) {
                throw new Exception('API SEVIMA tidak merespons (timeout/koneksi). ' . $this->_redact($error));
            }

            if ($status === 429 && $attempt <= $this->rate_limit_retry) {
                sleep($this->rate_limit_wait);
                continue;
            }

            break;
        }

        if ($status === 401) throw new Exception('API SEVIMA: kredensial salah (401).');
        if ($status === 403) throw new Exception('API SEVIMA: tidak memiliki akses (403).');
        if ($status === 404) throw new Exception('API SEVIMA: endpoint tidak ditemukan (404).');
        if ($status === 422) throw new Exception('API SEVIMA: parameter query tidak didukung (422).');
        if ($status === 429) throw new Exception('API SEVIMA: rate limit tercapai (429). Coba lagi nanti.');
        if ($status >= 500) throw new Exception('API SEVIMA: server vendor bermasalah (HTTP ' . $status . ').');
        if ($status !== 200) throw new Exception('API SEVIMA: respons tidak dikenal (HTTP ' . $status . ').');

        $decoded = json_decode($body, true);
        if (!is_array($decoded)) {
            throw new Exception('API SEVIMA: respons bukan JSON yang valid.');
        }

        return $decoded;
    }

    protected function _redact($message)
    {
        if ($this->app_key !== '') $message = str_replace($this->app_key, '[REDACTED]', $message);
        if ($this->secret_key !== '') $message = str_replace($this->secret_key, '[REDACTED]', $message);
        return $message;
    }
}
