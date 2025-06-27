<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('get_status_badge_color'))
{
    function get_status_badge_color($status)
    {
        switch ($status) {
            case 'disetujui':
                return 'success';
            case 'ditolak':
                return 'danger';
            case 'kadaluarsa':
                return 'warning';
            case 'direvisi':
                return 'info';
            case 'pending':
            case 'baru': // Jika Anda punya status 'baru'
                return 'primary';
            default:
                return 'secondary';
        }
    }
}