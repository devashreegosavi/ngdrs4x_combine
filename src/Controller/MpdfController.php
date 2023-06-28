<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use DateTime;
use Cake\Controller\Component;
use Cake\Core\App;
/**
 * 
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class MpdfController extends AppController{

    public function createPdf () {
        $this->Mpdf->cre;
          $mpdf =$this->Mpdf->mPDF('utf-8', 'A4');
        exit;
        $mpdf->autoScriptToLang = true;
        $mpdf->baseScript = 1;
        $mpdf->autoVietnamese = true;
        $mpdf->autoArabic = true;
        $mpdf->autoLangToFont = true;

        $mpdf->SetWatermarkText('Hello');
        $mpdf->watermarkTextAlpha = 0.2;
        $mpdf->showWatermarkText = true;
        $html_design = '<h1>Test</h1>';

        $mpdf->WriteHTML($html_design);
        $mpdf->Output("test.pdf", 'I'); // 'I' for Display PDF in Next Tab            
        exit;
    }

}
