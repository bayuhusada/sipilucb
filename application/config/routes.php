<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'home';
$route['404_override'] = 'notfound/index';
$route['translate_uri_dashes'] = FALSE;

$route['^(id|en|cn|de|ja)$']                                             = 'home/index';
$route['^(id|en|cn|de|ja)/tentang']                                     = 'about/index';
$route['^(id|en|cn|de|ja)/program-studi']                               = 'study_programs/index';
$route['^(id|en|cn|de|ja)/program-studi/(:any)']                        = 'study_programs/detail/$2';
$route['^(id|en|cn|de|ja)/dosen']                                       = 'lecturers/index';
$route['^(id|en|cn|de|ja)/dosen/(:any)']                                = 'lecturers/detail/$2';
$route['^(id|en|cn|de|ja)/berita']                                      = 'news/index';
$route['^(id|en|cn|de|ja)/berita/(:any)']                               = 'news/detail/$2';
$route['^(id|en|cn|de|ja)/berita/kategori/(:any)']                      = 'news/category/$2';
$route['^(id|en|cn|de|ja)/agenda']                                      = 'agendas/index';
$route['^(id|en|cn|de|ja)/galeri']                                      = 'galleries/index';
$route['^(id|en|cn|de|ja)/galeri/(:any)']                               = 'galleries/album/$2';
$route['^(id|en|cn|de|ja)/download']                                    = 'downloads/index';
$route['^(id|en|cn|de|ja)/faq']                                          = 'faq/index';
$route['^(id|en|cn|de|ja)/kontak']                                      = 'contact/index';
$route['^(id|en|cn|de|ja)/search']                                      = 'home/search';

$route['maintenance'] = 'maintenance/index';
$route['tentang'] = 'about/index';
$route['program-studi'] = 'study_programs/index';
$route['program-studi/(:any)'] = 'study_programs/detail/$1';
$route['dosen'] = 'lecturers/index';
$route['dosen/(:any)'] = 'lecturers/detail/$1';
$route['berita'] = 'news/index';
$route['berita/(:any)'] = 'news/detail/$1';
$route['berita/kategori/(:any)'] = 'news/category/$1';
$route['agenda'] = 'agendas/index';
$route['galeri'] = 'galleries/index';
$route['galeri/(:any)'] = 'galleries/album/$1';
$route['download'] = 'downloads/index';
$route['faq'] = 'faq/index';
$route['kontak'] = 'contact/index';
$route['search'] = 'home/search';
