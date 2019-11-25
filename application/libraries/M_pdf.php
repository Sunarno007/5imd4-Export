<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_pdf {

    public function __construct()
    {
         require_once APPPATH.'/third_party/mpdf/mpdf.php';
    }
}
