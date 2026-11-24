<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('compress_image')) {
    function compress_image($source_path, $max_width = 1920, $max_height = 1920, $quality = 80)
    {
        if (!file_exists($source_path)) return false;

        $info = getimagesize($source_path);
        if (!$info) return false;

        list($orig_w, $orig_h) = $info;
        $mime = $info['mime'];

        // Re-encode GIF through GD (first frame) to strip any embedded script/polyglot payload
        if ($mime === 'image/gif') {
            $src = @imagecreatefromgif($source_path);
            if (!$src) return false;
            $dst = imagecreatetruecolor($orig_w, $orig_h);
            imagecopy($dst, $src, 0, 0, 0, 0, $orig_w, $orig_h);
            $temp_path = $source_path . '.tmp';
            if (imagegif($dst, $temp_path)) {
                imagedestroy($src);
                imagedestroy($dst);
                rename($temp_path, $source_path);
                return true;
            }
            imagedestroy($src);
            imagedestroy($dst);
            return false;
        }

        // Calculate new dimensions
        $new_w = $orig_w;
        $new_h = $orig_h;

        if ($new_w > $max_width) {
            $ratio = $max_width / $new_w;
            $new_w = $max_width;
            $new_h = round($orig_h * $ratio);
        }

        if ($new_h > $max_height) {
            $ratio = $max_height / $new_h;
            $new_h = $max_height;
            $new_w = round($orig_w * $ratio);
        }

        // If already small enough, recompress only if JPEG
        if ($new_w >= $orig_w && $new_h >= $orig_h) {
            if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
                // Recompress JPEG even if same size
            } else {
                return true;
            }
        }

        // Create source image
        switch ($mime) {
            case 'image/jpeg':
            case 'image/jpg':
                $src = @imagecreatefromjpeg($source_path);
                $save_as_jpeg = true;
                break;
            case 'image/png':
                $src = @imagecreatefrompng($source_path);
                $save_as_jpeg = false;
                break;
            case 'image/webp':
                $src = @imagecreatefromwebp($source_path);
                $save_as_jpeg = true;
                break;
            default:
                return false;
        }

        if (!$src) return false;

        // Create destination image
        $dst = imagecreatetruecolor($new_w, $new_h);

        // Preserve PNG transparency
        if (!$save_as_jpeg) {
            imagealphablending($dst, false);
            imagesavealpha($dst, true);
        }

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_w, $new_h, $orig_w, $orig_h);

        $temp_path = $source_path . '.tmp';

        if ($save_as_jpeg) {
            imagejpeg($dst, $temp_path, $quality);
        } else {
            $png_quality = max(0, min(9, round((100 - $quality) / 10)));
            imagepng($dst, $temp_path, $png_quality);
        }

        imagedestroy($src);
        imagedestroy($dst);

        if (file_exists($temp_path)) {
            rename($temp_path, $source_path);
            return true;
        }

        return false;
    }
}

if (!function_exists('youtube_embed_url')) {
    function youtube_embed_url($url, $autoplay = true)
    {
        if (empty($url)) return '';
        $video_id = '';
        $parsed = parse_url($url);
        if (isset($parsed['host'])) {
            $host = str_replace('www.', '', $parsed['host']);
            if ($host === 'youtu.be') {
                $video_id = ltrim($parsed['path'] ?? '', '/');
            } elseif (in_array($host, ['youtube.com', 'm.youtube.com'])) {
                if (isset($parsed['query'])) {
                    parse_str($parsed['query'], $query);
                    $video_id = $query['v'] ?? '';
                }
                if (empty($video_id) && isset($parsed['path'])) {
                    $path_parts = explode('/', trim($parsed['path'], '/'));
                    if (isset($path_parts[0]) && $path_parts[0] === 'embed' && isset($path_parts[1])) {
                        $video_id = $path_parts[1];
                    }
                }
            }
        }
        if (empty($video_id)) return '';
        $params = 'rel=0&showinfo=0';
        if ($autoplay) $params .= '&autoplay=1&muted=1';
        return 'https://www.youtube.com/embed/' . $video_id . '?' . $params;
    }
}
