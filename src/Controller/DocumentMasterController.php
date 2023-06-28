<?php

declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;
use DateTime;

class DocumentMasterController extends AppController {
    
    public function article($article_id = NULL) {
        $admlevelconfig = $this->getTableLocator()->get('AdminLevelConfig');
        $articletbl = $this->getTableLocator()->get('Article');
        $mainlanguage = $this->getTableLocator()->get('MainLanguage');
        $lang = $this->request->getSession()->read('Config.language');
        $this->set('lang', $lang);
        $state_id = $this->request->getAttribute('identity')->state_id;
        $user_id = $this->request->getAttribute('identity')->user_id;
        
        $date = date('Y/m/d H:i:s');
        $created_date = date('Y/m/d');
       
        $NGDRSErrorCode = $this->getTableLocator()->get('NGDRSErrorCode');
        $errorlistdata = $NGDRSErrorCode->NGDRSErrorCodelistdata();
        $this->set('errorlistdata', $errorlistdata);
        
        $this->set('only_one_party_flag', null);
        $this->set('home_visit_flag', null);
        $this->set('dock_expiry_applicable_flag', null);
        $this->set('e_reg_applicable_flag', null);
        $this->set('e_file_applicable_flag', null);
        $this->set('property_applicable_flag', null);
        $this->set('template_applicable_flag', null);
        $this->set('leave_licence_flag_flag', null);
        $this->set('use_common_rule_flag_flag', null);
        $this->set('display_flag_flag', null);
        $this->set('index1_flag_flag', null);
        $this->set('index2_flag_flag', null);
        $this->set('index3_flag_flag', null);
        $this->set('index4_flag_flag', null);
        $this->set('index_reg_flag1_flag', null);
        $this->set('index_reg_flag2_flag', null);
        $this->set('index_reg_flag3_flag', null);
        $this->set('index_reg_flag4_flag', null);
        $this->set('titlewise_book_number_flag', null);
        
        $sizesradio = ['Y' => ' Yes ', 'N' => ' No '];    
        $this->set('sizesradio', $sizesradio);
        $article = $articletbl->newEmptyEntity();
        $this->set('article', $article);
        $articlelist = $articletbl->find('all')->order(['article_desc_en' => 'ASC'])->toArray();
        $this->set("articlelist", $articlelist);   

        $languagelist = $mainlanguage->MainLanguagelistdata($lang);
        $this->set('languagelist', $languagelist);
        $this->set('titlewise_book_number_flag', 'N');
        
        $fieldlist = $articletbl->fieldlist(); //Validation set in function
        $this->set('fieldlistmultiform', $fieldlist);
        $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));
        
        if ($this->request->is('post')) {
            $request_data = $this->request->getData();
            //pr($request_data);
            $errarr = $this->validatedata($request_data, $fieldlist['article']); 
            if ($this->ValidationError($errarr)) {
                $article = $articletbl->patchEntity($article, $this->request->getData());

                if ($articletbl->save($article)) {
                    if (($this->request->getData('hfaction') == 'U')) {
                        $this->Flash->success(__('Article has been updated successfully.'));
                    } else {
                        $this->Flash->success(__('Article has been added successfully.'));
                    }

                    return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'article']);
                }
            }
            else{
                $this->Flash->success(__('There is some validation errors'));
                return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'article']);
            }
        }
        if (!is_null($article_id) && is_numeric($article_id)) {
            $article = $articletbl->get($article_id);

            $this->set('article', $article);
            if ($this->request->is(['patch', 'put', 'post'])) {
                $data=$this->request->getData();

                $article = $articletbl->patchEntity($article, $this->request->getData());
                if ($articletbl->save($article)) {
                    $this->Flash->success(__('Document Title has been updated successfully.'));
                    return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'article']);
                }
            }
        }
        
    }
    
    public function articledelete($article_id = null){
        if (isset($article_id) && is_numeric($article_id)) {
            $articletbl = $this->getTableLocator()->get('Article');
            
            $article = $articletbl->get($article_id);
            $delres = $articletbl->delete($article);
            $this->Flash->success(
                    __('Article has been Deleted Successfully.')
            );
            return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'article']);
        }
    }
    public function documenttitle($articledescription_id = NULL) {
        $admlevelconfig = $this->getTableLocator()->get('AdminLevelConfig');
       // $user = $this->getTableLocator()->get('User');
        $article = $this->getTableLocator()->get('Article');
        $articledesc = $this->getTableLocator()->get('ArticleDescDetails');
        $mainlanguage = $this->getTableLocator()->get('MainLanguage');
        
        $documenttitle = $articledesc->newEmptyEntity();
        $lang = $this->request->getSession()->read('Config.language');
        $this->set('lang', $lang);
        $state_id = $this->request->getAttribute('identity')->state_id;
        $user_id = $this->request->getAttribute('identity')->user_id;
        
        $date = date('Y/m/d H:i:s');
        $created_date = date('Y/m/d');
       
        $NGDRSErrorCode = $this->getTableLocator()->get('NGDRSErrorCode');
        $errorlistdata = $NGDRSErrorCode->NGDRSErrorCodelistdata();
        $this->set('errorlistdata', $errorlistdata);
        
        $fieldlist = $articledesc->fieldlist(); //Validation set in function
        $this->set('fieldlistmultiform', $fieldlist);
        $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));
            
        $this->set('documenttitle', $documenttitle);
        $articlelist = $article
                ->find('list', [
                    'keyField' => 'article_id',
                    'valueField' => 'article_desc_'.$lang])
                ->order(['article_desc_en' => 'ASC'])->toArray();
        $this->set('articlelist', $articlelist);

        $document = $articledesc
        ->find()
        ->select(['article.article_id','article.article_desc_en', 'ArticleDescDetails.articledescription_en', 'ArticleDescDetails.articledescription_ll', 'ArticleDescDetails.book_number', 'ArticleDescDetails.articledescription_id'])
        ->join([
            'article'=>  [
                'table'      => 'ngdrstab_mst_article',                
                'type'       => 'INNER',
                'conditions' => 'article.article_id = ArticleDescDetails.article_id',
            ]
        ])
        ->order(['article_desc_en' => 'ASC','articledescription_en'=>'ASC'])        
        ->toArray();
        $this->set('document', $document);
        
        $languagelist = $mainlanguage->MainLanguagelistdata($lang);
        $this->set('languagelist', $languagelist);
        
        if ($this->request->is('post')) {

            $request_data = $this->request->getData();
            $errarr = $this->validatedata($request_data, $fieldlist['document_title']); //Server side validation
            
            if ($this->ValidationError($errarr)) {
                $documenttitle = $articledesc->patchEntity($documenttitle, $this->request->getData());

                if ($articledesc->save($documenttitle)) {
                    if (($this->request->getData('hfaction') == 'U')) {
                        $this->Flash->success(__('Document Title has been updated successfully.'));
                    } else {
                        $this->Flash->success(__('Document Title has been added successfully.'));
                    }

                    return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'documenttitle']);
                }
            }
            else{
                $this->Flash->success(__('There is some validation errors'));
                return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'documenttitle']);
            }
        }
        
        if (!is_null($articledescription_id) && is_numeric($articledescription_id)) {
            
            $documenttitle = $articledesc->get($articledescription_id);

            $this->set('documenttitle', $documenttitle);
            
            if ($this->request->is(['patch', 'put', 'post'])) {
                $data=$this->request->getData();

                $documenttitle = $articledesc->patchEntity($documenttitle, $this->request->getData());
                if ($articledesc->save($documenttitle)) {
                    $this->Flash->success(__('Document Title has been updated successfully.'));
                    return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'documenttitle']);
                }
            }

            
        }
    }
    public function documenttitledelete($articledescription_id = null){
        if (isset($articledescription_id) && is_numeric($articledescription_id)) {
            $article = $this->getTableLocator()->get('Article');
            $articledesc = $this->getTableLocator()->get('ArticleDescDetails');
            
            $articledescdel = $articledesc->get($articledescription_id);
            $delres = $articledesc->delete($articledescdel);
            $this->Flash->success(
                    __('Document Title has been Deleted Successfully.')
            );
            return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'documenttitle']);
        }
    }
    public function uploadDocumententry($document_id = NULL){
        $mainlanguage = $this->getTableLocator()->get('MainLanguage');
        $lang = $this->request->getSession()->read('Config.language');
        $this->set('lang', $lang);
        $state_id = $this->request->getAttribute('identity')->state_id;
        $user_id = $this->request->getAttribute('identity')->user_id;
        $req_ip = $_SERVER['REMOTE_ADDR'];
        $date = date('Y/m/d H:i:s');
        $created_date = date('Y/m/d');
       
        $uploaddoctbl = $this->getTableLocator()->get('UploadDocument');
        $NGDRSErrorCode = $this->getTableLocator()->get('NGDRSErrorCode');
      
        $errorlistdata = $NGDRSErrorCode->NGDRSErrorCodelistdata();
        $this->set('errorlistdata', $errorlistdata);

        $languagelist = $mainlanguage->MainLanguagelistdata($lang);
        $this->set('languagelist', $languagelist);

        $getdoclist_arr=$uploaddoctbl->getdoclist();
        $this->set('getdoclist_arr', $getdoclist_arr);
        
        $documentupload = $uploaddoctbl->newEmptyEntity();
        $this->set('documentupload', $documentupload);
        
        $fieldlist = $uploaddoctbl->fieldlist($languagelist); //Validation set in function
     
        $this->set('fieldlistmultiform', $fieldlist);
        $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));
        
        if ($this->request->is('post')) {

            $request_data = $this->request->getData();
            $errarr = $this->validatedata($request_data, $fieldlist['upload_document']); //Server side validation
            
            if ($this->ValidationError($errarr)) {
                $documentupload = $uploaddoctbl->patchEntity($documentupload, $this->request->getData());

                if ($uploaddoctbl->save($documentupload)) {
                    if (($this->request->getData('hfaction') == 'U')) {
                        $this->Flash->success(__('Upload Document Entry has been updated successfully.'));
                    } else {
                        $this->Flash->success(__('Upload Document Entry has been added successfully.'));
                    }

                    return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'uploadDocumententry']);
                }
            }
            else{
                $this->Flash->success(__('There is some validation errors'));
                return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'uploadDocumententry']);
            }
        }
        
        if (!is_null($document_id) && is_numeric($document_id)) {
            
            $documentupload = $uploaddoctbl->get($document_id);
            $this->set('documentupload', $documentupload);
            
            if ($this->request->is(['patch', 'put', 'post'])) {
                $data=$this->request->getData();

                $documentupload = $uploaddoctbl->patchEntity($documentupload, $this->request->getData());
                if ($uploaddoctbl->save($documentupload)) {
                    $this->Flash->success(__('Upload Document Entry has been updated successfully.'));
                    return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'uploadDocumententry']);
                }
            }
            
        }
    }
    public function uploaddocumentdelete($document_id = NULL){
        if (isset($document_id) && is_numeric($document_id)) {
            $uploaddoctbl = $this->getTableLocator()->get('UploadDocument');
            
            $uploaddocdel = $uploaddoctbl->get($document_id);
            $delres = $uploaddoctbl->delete($uploaddocdel);
            $this->Flash->success(
                    __('Upload Document entry has been Deleted Successfully.')
            );
            return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'uploadDocumententry']);
        }
    }
    public function articleDocumentMap($article_doc_map_id = NULL){
        $mainlanguage = $this->getTableLocator()->get('MainLanguage');
        $lang = $this->request->getSession()->read('Config.language');
        $this->set('lang', $lang);
        $state_id = $this->request->getAttribute('identity')->state_id;
        $user_id = $this->request->getAttribute('identity')->user_id;
        $req_ip = $_SERVER['REMOTE_ADDR'];
        $date = date('Y/m/d H:i:s');
        $created_date = date('Y/m/d');
        
        $article_titlewise_map = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(9);
        $this->set('article_titlewise_map', $article_titlewise_map);
        
        $NGDRSErrorCode = $this->getTableLocator()->get('NGDRSErrorCode');
        $errorlistdata = $NGDRSErrorCode->NGDRSErrorCodelistdata();
        $this->set('errorlistdata', $errorlistdata);

        $languagelist = $mainlanguage->MainLanguagelistdata($lang);
        $this->set('languagelist', $languagelist);
        
        $article = $this->getTableLocator()->get('Article');
        $getarticlelist = $article->getarticle($lang);
        $this->set('getarticlelist', $getarticlelist);

        $artdocmap = $this->getTableLocator()->get('ArticleDocMapping');
        $articledocumentmap = $artdocmap->newEmptyEntity();
        $this->set('articledocumentmap', $articledocumentmap);
        
        $uploaddoctbl = $this->getTableLocator()->get('UploadDocument');
        $getuploaddoc = $uploaddoctbl->getuploaddoc($lang);
        $this->set('getuploaddoc', $getuploaddoc);
        
        $arrCategory = array('Y' => "Yes", 'N' => "No");
        $this->set('arrCategory', $arrCategory);
        
        $articlegrid = $artdocmap->getallrec($article_titlewise_map['conf_bool_value']);
        $this->set('articlegrid', $articlegrid); 
        
        $fieldlist = $artdocmap->fieldlist($languagelist); //Validation set in function
     
        $this->set('fieldlistmultiform', $fieldlist);
        $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));
        
        if ($this->request->is('post')) {

            $request_data = $this->request->getData();
            pr($request_data);//exit;
            $errarr = $this->validatedata($request_data, $fieldlist['articledocumentmap']); //Server side validation
            
            if ($this->ValidationError($errarr)) {
                $data = ['state_id' => '13'];
                $articledocumentmap = $artdocmap->patchEntity($articledocumentmap, $data);
                $articledocumentmap = $artdocmap->patchEntity($articledocumentmap, $this->request->getData());
                pr($articledocumentmap);//exit;
                if ($artdocmap->save($articledocumentmap)) {
                    if (($this->request->getData('hfaction') == 'U')) {
                        $this->Flash->success(__('Document Title has been updated successfully.'));
                    } else {
                        $this->Flash->success(__('Document Title has been added successfully.'));
                    }

                    return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'articleDocumentMap']);
                }
            }
            else{
                $this->Flash->success(__('There is some validation errors'));
                return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'articleDocumentMap']);
            }
        }
        if (!is_null($article_doc_map_id) && is_numeric($article_doc_map_id)) {
            
            $articledocumentmap = $artdocmap->get($article_doc_map_id);
            $this->set('articledocumentmap', $articledocumentmap);
            
            if ($this->request->is(['patch', 'put', 'post'])) {
                $data=$this->request->getData();

                $articledocumentmap = $artdocmap->patchEntity($articledocumentmap, $this->request->getData());
                if ($artdocmap->save($articledocumentmap)) {
                    $this->Flash->success(__('Article Document Mapping has been updated successfully.'));
                    return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'articleDocumentMap']);
                }
            }
            
        }        
    }
    public function articleDocumentMapDelete($article_doc_map_id = NULL){
        if (isset($article_doc_map_id) && is_numeric($article_doc_map_id)) {
            $artdocmap = $this->getTableLocator()->get('ArticleDocMapping');
            $artdocdel = $artdocmap->get($article_doc_map_id);
            $delres = $artdocmap->delete($artdocdel);
            $this->Flash->success(
                    __('Article Document Mapping has been Deleted Successfully.')
            );
            return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'articleDocumentMap']);
        }
    }
    public function articleScreenMap($id = NULL){
        $mainlanguage = $this->getTableLocator()->get('MainLanguage');
        $lang = $this->request->getSession()->read('Config.language');
        $this->set('lang', $lang);
        $state_id = $this->request->getAttribute('identity')->state_id;
        $user_id = $this->request->getAttribute('identity')->user_id;
        $req_ip = $_SERVER['REMOTE_ADDR'];
        $date = date('Y/m/d H:i:s');
        $created_date = date('Y/m/d');
        
        $NGDRSErrorCode = $this->getTableLocator()->get('NGDRSErrorCode');
        $errorlistdata = $NGDRSErrorCode->NGDRSErrorCodelistdata();
        $this->set('errorlistdata', $errorlistdata);

        $languagelist = $mainlanguage->MainLanguagelistdata($lang);
        $this->set('languagelist', $languagelist);
        
        $article = $this->getTableLocator()->get('Article');
        $getarticlelist = $article->getarticle($lang);
        $this->set('getarticlelist', $getarticlelist);

        $artscreenmap = $this->getTableLocator()->get('ArticleScreenMapping');
        $articlescreenmap = $artscreenmap->newEmptyEntity();
        $this->set('articlescreenmap', $articlescreenmap);
        
        $minorfuntbl = $this->getTableLocator()->get('MinorFunction');
        $getminorfundoc = $minorfuntbl->getminorfunctionlist($lang);
        $this->set('getminorfundoc', $getminorfundoc);
        
        $articlegrid = $artscreenmap->getallartscreenrec();
        $this->set('articlegrid', $articlegrid);
        
        $fieldlist = $artscreenmap->fieldlist($languagelist); //Validation set in function
     
        $this->set('fieldlistmultiform', $fieldlist);
        $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));
        
        if ($this->request->is('post')) {

            $request_data = $this->request->getData();
            $errarr = $this->validatedata($request_data, $fieldlist['articlescreenmap']); //Server side validation
            
            if ($this->ValidationError($errarr)) {
                
                $data = ['minorfun_id' => $this->request->getData('minor_id')];
                $articlescreenmap = $artscreenmap->patchEntity($articlescreenmap, $this->request->getData());
                $articlescreenmap = $artscreenmap->patchEntity($articlescreenmap, $data);
                if ($artscreenmap->save($articlescreenmap)) {
                    if (($this->request->getData('hfaction') == 'U')) {
                        $this->Flash->success(__('Article Screen Mapping has been updated successfully.'));
                    } else {
                        $this->Flash->success(__('Article Screen Mapping has been added successfully.'));
                    }

                    return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'articleScreenMap']);
                }
            }
            else{
                $this->Flash->success(__('There is some validation errors'));
                return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'articleScreenMap']);
            }
        }
        if (!is_null($id) && is_numeric($id)) {
            
            $articlescreenmap = $artscreenmap->get($id);
            $this->set('articlescreenmap', $articlescreenmap);
            
            if ($this->request->is(['patch', 'put', 'post'])) {
                //$data=$this->request->getData();

                $data = ['minorfun_id' => $this->request->getData('minor_id')];
                $articlescreenmap = $artscreenmap->patchEntity($articlescreenmap, $this->request->getData());
                $articlescreenmap = $artscreenmap->patchEntity($articlescreenmap, $data);
                
                if ($artscreenmap->save($articlescreenmap)) {
                    $this->Flash->success(__('Article Screen Mapping has been updated successfully.'));
                    return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'articleScreenMap']);
                }
            }
            
        }        
    }
    public function articleScreenMapDelete($id = NULL){
        if (isset($id) && is_numeric($id)) {
            $artscreenmap = $this->getTableLocator()->get('ArticleScreenMapping');
            $artscreendel = $artscreenmap->get($id);
            $delres = $artscreenmap->delete($artscreendel);
            $this->Flash->success(
                    __('Article Screen Mapping has been Deleted Successfully.')
            );
            return $this->redirect(['controller' => 'DocumentMaster', 'action' => 'articleScreenMap']);
        }
    }
    public function getarticledescdetailslist() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $data = $this->request->getData();
            // pr($data); 
            $article_id = $data['article_id'];
            $artciledesclist = $this->fetchTable('ArticleDescDetails')
                    ->find('list', [
                        'keyField' => 'articledescription_id',
                        'valueField' => 'articledescription_' . $lang])
                    ->where(['article_id =' => $article_id])
                    ->order(['articledescription_en' => 'ASC']);
//pr($artciledesclist);
            $artciledesclistres = $artciledesclist->toArray();
            echo json_encode($artciledesclistres);
            exit;
        } catch (exception $ex) {
            pr($ex);
            exit;
        }
    }
    public function pdefunctionentry(){
        
        $lang = $this->request->getSession()->read('Config.language');
        $this->set('lang', $lang);
        $state_id = $this->request->getAttribute('identity')->state_id;
        $user_id = $this->request->getAttribute('identity')->user_id;
        $req_ip = $_SERVER['REMOTE_ADDR'];
        $date = date('Y/m/d H:i:s');
        $created_date = date('Y/m/d');
        
        $NGDRSErrorCode = $this->getTableLocator()->get('NGDRSErrorCode');
        $errorlistdata = $NGDRSErrorCode->NGDRSErrorCodelistdata();
        $this->set('errorlistdata', $errorlistdata);

        $mainlanguage = $this->getTableLocator()->get('MainLanguage');
        $languagelist = $mainlanguage->MainLanguagelistdata($lang);
        $this->set('languagelist', $languagelist);
        
        $minorfuntbl = $this->getTableLocator()->get('MinorFunction');
        $getminorfundoc = $minorfuntbl->getminorfunctionlist($lang);
        $this->set('getminorfundoc', $getminorfundoc);
        
        $pdefunctionentry = $minorfuntbl->newEmptyEntity();
        $this->set('pdefunctionentry', $pdefunctionentry);
        
        $majorfuntbl = $this->getTableLocator()->get('MajorFunction');
        
    }
    
}