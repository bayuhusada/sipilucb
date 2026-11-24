<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Translator {

    private $provider;
    private $source_lang;
    private $target_langs;

    public function __construct($config = array())
    {
        $ci =& get_instance();
        $ci->load->config('translator');

        $this->provider = $config['provider'] ?? $ci->config->item('translator_provider');
        $this->source_lang = $config['source_lang'] ?? $ci->config->item('translator_source_lang');
        $this->target_langs = $config['target_langs'] ?? $ci->config->item('translator_target_langs');

        $ci->load->model('setting_model');
        $db_provider = $ci->setting_model->get('translator_provider');
        if ($db_provider) $this->provider = $db_provider;
    }

    public function translate($text, $target_lang, $source_lang = null)
    {
        if (empty($text)) return '';
        if ($target_lang === ($source_lang ?? $this->source_lang)) return $text;

        return $this->call_libre($text, $target_lang, $source_lang ?? $this->source_lang);
    }

    public function translate_batch($texts, $target_lang, $source_lang = null)
    {
        $results = array();
        foreach ($texts as $key => $text) {
            $results[$key] = $this->translate($text, $target_lang, $source_lang);
        }
        return $results;
    }

    public function test_connection()
    {
        $ci =& get_instance();
        $ci->load->model('setting_model');
        $endpoint = $ci->setting_model->get('translator_endpoint_libre');

        if (empty($endpoint)) {
            return array('status' => false, 'message' => 'Endpoint belum dikonfigurasi. Isi di Settings lalu coba lagi.');
        }

        $api_key = $ci->setting_model->get('translator_api_key_libre');
        return $this->_test_libre(rtrim($endpoint, '/'), $api_key);
    }

    private function call_libre($text, $target, $source)
    {
        $ci =& get_instance();
        $ci->load->model('setting_model');
        $endpoint = $ci->setting_model->get('translator_endpoint_libre');
        if (empty($endpoint)) return '';

        $api_key = $ci->setting_model->get('translator_api_key_libre');
        $libre_target = $target === 'cn' ? 'zh' : $target;

        $payload = array(
            'q' => strip_tags($text),
            'source' => 'auto',
            'target' => $libre_target,
            'format' => 'text',
            'alternatives' => 3,
            'api_key' => $api_key ?: '',
        );

        $url = rtrim($endpoint, '/') . '/translate';

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
        ));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            log_message('error', 'Translator::call_libre - CURL error: ' . $error . ' | endpoint: ' . $url);
            return '';
        }
        if ($http_code !== 200) {
            log_message('error', 'Translator::call_libre - HTTP ' . $http_code . ' | endpoint: ' . $url . ' | response: ' . substr($response, 0, 500));
            return '';
        }

        $decoded = json_decode($response, true);
        if (!$decoded || !isset($decoded['translatedText'])) {
            log_message('error', 'Translator::call_libre - Invalid response format | endpoint: ' . $url . ' | response: ' . substr($response, 0, 500));
            return '';
        }

        return $decoded['translatedText'];
    }

    private function _test_libre($endpoint, $api_key)
    {
        $url = rtrim($endpoint, '/') . '/translate';

        $payload = array(
            'q' => 'Hello',
            'source' => 'auto',
            'target' => 'id',
            'format' => 'text',
            'alternatives' => 3,
            'api_key' => $api_key ?: '',
        );

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 3,
            CURLOPT_TIMEOUT => 15,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HTTPHEADER => array('Content-Type: application/json'),
        ));

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) return array('status' => false, 'message' => 'CURL Error: ' . $error);
        if ($http_code !== 200) {
            $body = json_decode($response, true);
            $msg = $body['error'] ?? $response;
            if (is_array($msg)) $msg = json_encode($msg);
            return array('status' => false, 'message' => "LibreTranslate ({$http_code}): {$msg}");
        }

        $decoded = json_decode($response, true);
        if ($decoded && isset($decoded['translatedText'])) {
            return array('status' => true, 'message' => 'Koneksi berhasil. LibreTranslate siap digunakan.');
        }

        return array('status' => false, 'message' => 'LibreTranslate: Respon tidak dikenali.');
    }
}