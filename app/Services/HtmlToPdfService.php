<?php

namespace App\Services;

use App\Common\Services\BaseService;
use Spipu\Html2Pdf\Html2Pdf;


class HtmlToPdfService extends BaseService
{
    protected $html2pdf;

    public $outputMode = 'I';

    protected $file;

    public function __construct(){
        parent::__construct();
        $this->html2pdf =  new Html2Pdf();
        $this->html2pdf->setDefaultFont('stsongstdlight');
    }



    public function setOutputField($file){
        $this->outputMode = 'F';
        $this->file = $file;
        return $this;
    }


    public function get(){
//        $str = file_get_contents( dirname(__DIR__).'/demo.html');
//
//        $this->html2pdf->writeHTML($str);
//        $file = dirname(__DIR__).'/demo.pdf';
//        $this->html2pdf->output($file,$this->outputMode);
        $this->toImg();
    }


    public function toImg(){
        $pdfpath =  dirname(__DIR__).'/demo.pdf';
        $im = new \Imagick();
//        $im->setRegistry('temporary-path',dirname(__DIR__).'/test');
        $im->readImage($pdfpath);
        $im->resetIterator();
        $imgs = $im->appendImages(true);
        $imgs->setImageFormat( "jpg" );
        $img_name = '/demo.jpg';
        $imgs->writeImage(  dirname(__DIR__).$img_name);
        $imgs->clear();
        $imgs->destroy();
        $im->clear();
        $im->destroy();

    }
}
