<?php

declare(strict_types = 1);

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

use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\Datasource\ConnectionManager;

//use Cake\ORM\Locator\LocatorAwareTrait;
/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class GeneralinfoController extends AppController {

    public function generalinfoentry() {
        $lang = $this->request->getSession()->read('Config.language');
        $Selectedtoken = $this->request->getSession()->read('Selectedtoken');
        //echo 'token : ';pr($Selectedtoken);
        $usertype = 'C';
        $articlelistdata = $this->fetchTable('Article')->getarticle($lang);

        $docexetypedata = $this->fetchTable('DocumentExecutionType')->find('list', [
                    'keyField' => 'id',
                    'valueField' => 'execution_type_' . $lang
                ])->order(['id' => 'ASC'])->toArray();

        $officelistdata = $this->fetchTable('Office')->find('list', [
                    'keyField' => 'office_id',
                    'valueField' => 'office_name_' . $lang
                ])->order(['office_name_en' => 'ASC'])->toArray();

        $districtlistdata = $this->fetchTable('District')->find('list', [
                    'keyField' => 'district_id',
                    'valueField' => 'district_name_' . $lang
                ])->order(['district_name_en' => 'ASC'])->toArray();

        $annexure_config = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(1);

        $advname_config = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(2);

        $tehsil_config = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(3);

        $village_config = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(4);

        $old_reg_flag = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(5);
        
        $suo_motu_applicable = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(6);
        
        $linkoffice_applicable = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(7);
        
        $office_details_applicable = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(8);
        
        $presentationdt = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(10);
               
        $sroapproveflg = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(11);
        
        $getresult = $this->fetchTable('Generalinformation')->find()
                    ->select(['suo_motu_flag'])
                    ->where(['token_no =' => '20220000000001'])
                    ->toArray();        
   
        $getresult=$getresult[0]->toArray();
        
        $sizesradio = ['Y' => ' Yes ', 'N' => ' No '];
        
        $this->set('exe_date', date('d-m-Y'));
        $this->set(compact('presentationdt','office_details_applicable','linkoffice_applicable','sizesradio','suo_motu_applicable','getresult','Selectedtoken','articlelistdata', 'docexetypedata', 'officelistdata', 'districtlistdata', 'annexure_config', 'advname_config', 'tehsil_config', 'village_config','old_reg_flag'));

        $fieldlist=array();
        $fieldlist = $this->fetchTable('Generalinformation')->fieldlist();

        $this->set('fieldlistmultiform', $fieldlist);
        $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));
        $fields = $this->set_common_fields();
 
        
             
        if ($this->request->is('post')) {
            pr($this->request->getData());
            $article_id = $this->request->getData('article_id');
            $getresult = $this->fetchTable('FeeRule')->find('all')
                    ->where(['article_id =' => $article_id])
                    ->toArray();   
            
            if(sizeof($getresult)<=0){
                $this->Flash->success(__('Fee rule not found for this article ,Document not saved !'));
                return $this->redirect(['controller' => 'Generalinfo', 'action' => 'generalinfoentry']);
            }
            $mainlanguage = $this->getTableLocator()->get('MainLanguage');
            $languagelist = $mainlanguage->MainLanguagelistdata($lang);
          
            $this->set('languagelist', $languagelist);
            $this->set('Selectedtoken', $tokenval = $this->request->getSession()->read('Selectedtoken'));
        
            $generalinfodet = $this->getTableLocator()->get('Generalinformation');
            $gen_add = $generalinfodet->newEmptyEntity();
            $this->set('$gen_add', $gen_add);
            
            $setdata = $this->set_value_tosave_generalinfo($this->request->getData(), $fields['user_id'], $fields['stateid'], $usertype);
            //pr($setdata);
            $data = ['org_type_id' => '4','user_type' => $usertype, 'local_language_id'=>$languagelist[0]['mainlanguage']['id']];
            
            $gen_add = $generalinfodet->patchEntity($gen_add, $data);
            $gen_add = $generalinfodet->patchEntity($gen_add, $this->request->getData());
            $gen_add = $generalinfodet->patchEntity($gen_add, $setdata);

            if ($this->request->getData('general_info_id') == '') {
                $connection = ConnectionManager::get('default');
                $results = $connection->execute('SELECT * FROM generate_token_number()')->fetchAll('assoc');
                //pr($results[0]['generate_token_number']);
                $citizenuser_id = $this->request->getAttribute('identity')->user_id;
                $data1 = ['token_no' => $results[0]['generate_token_number'], 'token_created_userid' => $citizenuser_id];
                $gen_add = $generalinfodet->patchEntity($gen_add, $data1);
            }
            
            
            $sessiousertype = $this->request->getSession()->read('Config.session_usertype');
            //$sessiousertype='O';
            if($sessiousertype == 'O'){
                $offid=$this->request->getAttribute('identity')->office_id;
                if($offid!=''){
                    $offuser_id = $this->request->getAttribute('identity')->user_id;
                    if ($this->request->getData('general_info_id') == '') {
                        $dtd = date('Y-m-d H:i:s');
                        $data2= ['office_id' =>$offid, 'org_user_id' => $offuser_id , 'org_created' => $dtd, 'registration_type_id' => '1'];
                    }
                    else{
                        $dtd = date('Y-m-d H:i:s');
                        $data2= ['office_id' =>$offid, 'org_user_id' => $offuser_id , 'org_updated' => $dtd, 'registration_type_id' => '1'];
                    }
                    $gen_add = $generalinfodet->patchEntity($gen_add, $data2);
                }
            }
            
            pr($gen_add);
            
             
             
            if ($generalinfodet->save($gen_add)) {
                $last_id = $gen_add->general_info_id;
                if (!is_numeric($last_id)) {
                    $last_id = $this->request->getData('general_info_id');
                }
                $getresultdt = $this->fetchTable('Generalinformation')->find('all')
                                                        ->where(['general_info_id =' => $last_id])
                                                        ->toArray(); 
                //pr($getresultdt);
                $getresultdt=$getresultdt[0]->toArray();
                pr($getresultdt);
                if ($getresultdt) {
                    if (!is_numeric($Selectedtoken)){
                        $this->save_documentstatus(1, $getresultdt['token_no'], $getresultdt['office_id']);
                    }
                    $this->request->getSession()->write('Selectedtoken', $getresultdt['token_no']);
                    $this->request->getSession()->write('article_id', $getresultdt['article_id']);
                    $this->request->getSession()->write('major_minor', $getresultdt['major_minor_flag']);
                    $this->request->getSession()->write('reg_type_id', $getresultdt['registration_type_id']);
                    $this->set('delay_flag', $getresultdt['delay_flag']);
                    
                    $getlang = $this->fetchTable('MainLanguage')->find('all')
                                        ->where(['id =' => $getresultdt['local_language_id']])
                                        ->toArray(); 
                    $getlang=$getlang[0]->toArray();
                    if ($getlang) {
                        if ($getlang['language_code'] == 'en') {
                            $this->request->getSession()->write('doc_lang', 'en');
                        } else {
                            $this->request->getSession()->write('doc_lang', 'll');
                        }
                    }
                    
                    $property_exists=$this->fetchTable('ArticleScreenMapping')->find('all')
                                        ->where(['minorfun_id' => 2, 'article_id' => $getresultdt['article_id']]); 
                    $property_cnt = $property_exists->count();
                    if($property_cnt<=0){
                        $ids = $this->fetchTable('PropertyDetailsEntry')
                                ->find()
                                ->select(['property_id'])
                                ->where(['token_no =' => $getresultdt['token_no']])
                                ->toArray(); 
                        
                        if (count($ids) > 0) {
                            foreach ($ids as $id) {
                                $pid = $id->toArray();
                                $this->property_remove($pid['property_id'], 'G');
                            }
                        }
               
                    }
                    
                    $stampgetresultdt = $this->fetchTable('StampDuty')->find('all')
                            ->where(['token_no' => $getresultdt['token_no']])
                            ->toArray(); 
                    if(sizeof($stampgetresultdt)>0)
                    {
                        for($p=0;$p<sizeof($stampgetresultdt);$p++){
                            $stampresdel = $stampgetresultdt[$p];
                            $this->fetchTable('StampDuty')->delete($stampresdel);
                        }
                    }

                    $adjstampgetresultdt = $this->fetchTable('StampDutyAdjustment')->find('all')
                            ->where(['token_no' => $getresultdt['token_no']])
                            ->toArray(); 
                    if(sizeof($adjstampgetresultdt)>0)
                    {
                        for($q=0;$q<sizeof($adjstampgetresultdt);$q++){
                            $stampresdel = $adjstampgetresultdt[$q];
                            $this->fetchTable('StampDutyAdjustment')->delete($stampresdel);
                        }
                    }
    
                }
                
                //$prop_applicable = $this->fetchTable('ArticleDepFields')->savedependent_field($lang,$gen_add,$Selectedtoken,$fields,$usertype);
                $prop_applicable = $this->fetchTable('ArticleScreenMappingTable')->find('all')
                            ->where(['minorfun_id' => 2, 'article_id' => $article_id ])
                            ->toArray(); 
                
                if(sizeof($prop_applicable)>0){
                    $this->request->getSession()->write('prop_applicable', 'Y');
                    $tokentoup = $this->request->getSession()->read('Selectedtoken');
                    
                    $quryupprop = $generalinfodet->query()
                                    ->update()
                                    ->set(['property_applicable' => 'Y'])
                                    ->where(['token_no' => $tokentoup])
                                    ->execute();
                    
                    
                }
                else{
                    $this->request->getSession()->write('prop_applicable', 'N');
                    $tokentoup = $this->request->getSession()->read('Selectedtoken');
                    
                    $quryupprop = $generalinfodet->query()
                                    ->update()
                                    ->set(['property_applicable' => 'N'])
                                    ->where(['token_no' => $tokentoup])
                                    ->execute();
                    
                    $ids = $this->fetchTable('PropertyDetailsEntry')
                                ->find()
                                ->select(['property_id'])
                                ->where(['token_no =' => $tokentoup])
                                ->toArray(); 

                    if (count($ids) > 0) {
                        foreach ($ids as $id) {
                            $pid = $id->toArray();
                            $this->property_remove($pid['property_id'], 'G');
                        }
                    }
                        
                }
                   
                $no_of_pages = $this->request->getData('no_of_pages');
                if (isset($no_of_pages)) {
                    $pages = $no_of_pages;
                } else {
                    $pages = NULL;
                }
                
                
            }
            $tokentoup = $this->request->getSession()->read('Selectedtoken');
            $frmData = $gen_add;
            $this->set_csrf_token();
            if ($sroapproveflg['is_boolean'] == 'Y' && $sroapproveflg['conf_bool_value'] == 'Y') {
                $srflg = $this->fetchTable('Generalinformation')
                                ->find()
                                ->select(['sro_approve_flag'])
                                ->where(['token_no =' => $tokentoup])
                                ->toArray(); 
                if($srflg[0]['sro_approve_flag'] == 'Y'){
                    $this->Flash->success(__('Saved Successfully'));
                    return $this->redirect(['controller' => 'Generalinfo', 'action' => 'property_details']);
                }else{
                    $this->Flash->success(__('Saved Successfully'));
                    return $this->redirect(['controller' => 'Generalinfo', 'action' => 'upload_document']);
                }
            }
            else{
                $this->Flash->success(__('Saved Successfully'));
                return $this->redirect(['controller' => 'Generalinfo', 'action' => 'property_details']);
            }
            
           
        }else{
            /// update
        }
        
    }

    public function set_common_fields(){
        //pr($this->request->getAttribute('identity'));//exit;
        $data['stateid'] = $this->request->getAttribute('identity')->state_id;//$this->Auth->User("state_id");
        $data['ip'] = $_SERVER['REMOTE_ADDR'];//getenv("REMOTE_ADDR");
        $data['created_date'] = date('Y-m-d H:i:s');
        $data['user_id'] = $this->request->getAttribute('identity')->user_id;//$this->Session->read("citizen_user_id");
        return $data;
    }
    public function set_value_tosave_generalinfo($data, $user_id, $stateid, $user_type){
        $data['user_id'] = $user_id;
        $data['req_ip'] = $this->request->clientIp();
        $data['state_id'] = $stateid;
        $data['user_type'] = $user_type;
        $data['created'] = date('Y-m-d H:i:s');
        $data['ref_doc_date'] = (@$data['ref_doc_date']) ? date('Y-m-d', strtotime(str_replace('/', '-', $data['ref_doc_date']))) : NULL;
        $role_id = $this->request->getAttribute('identity')->role_id;
        if ($role_id == '999901' || $role_id == '999902' || $role_id == '999903') {
            $manualflg = $this->request->getSession()->read('Config.manual_flag');
            if(isset($manualflg))
            {
                if ($this->request->getSession()->read('Config.manual_flag') != 'Y') {
                    $data['presentation_date'] = date('Y-m-d');
                }
            }
        }
        else{
            $data['presentation_date'] = (@$data['presentation_date']) ? date('Y-m-d', strtotime(str_replace('/', '-', $data['presentation_date']))) : NULL;
        }
        $data['exec_date'] = (@$data['exec_date']) ? date('Y-m-d', strtotime(str_replace('/', '-', $data['exec_date']))) : NULL;
        $data['link_doc_date'] = (@$data['link_doc_date']) ? date('Y-m-d', strtotime(str_replace('/', '-', $data['link_doc_date']))) : NULL;
        $data['entry_date_india'] = (@$data['entry_date_india']) ? date('Y-m-d', strtotime(str_replace('/', '-', $data['entry_date_india']))) : NULL;
        $data['court_order_date'] = ($data['doc_execution_type_id'] == 3) ? (($data['court_order_date']) ? date('Y-m-d', strtotime(str_replace('/', '-', $data['court_order_date']))) : NULL) : NULL;
        $getresult = $this->fetchTable('Generalinformation')->find()
                    ->select(['last_status_id'])
                    ->where(['token_no =' => '20220000000001'])
                    ->toArray();        
   
        $getresult=$getresult[0]->toArray();
        if (!empty($getresult)) {
            $data['last_status_id'] = $getresult['last_status_id'];
        }else{
            $data['last_status_id'] = 1;
        }
        $data['last_status_date'] = date('Y-m-d');
        return $data;
    }
    public function property_remove($id = NULL, $flag = NULL){
        try {
                if (is_numeric($id)) {
                        $token = $this->request->getSession()->read('Selectedtoken');
                        $user_id = $this->request->getAttribute('identity')->user_id;
                        $article_id = $this->request->getSession()->read('article_id');
                        
                        $getresultdt = $this->fetchTable('Parameter')->find('all')
                            ->where(['property_id' => $id , 'token_id' => $token ])
                            ->toArray(); 
                        if(sizeof($getresultdt)>0)
                        {
                            for($p=0;$p<sizeof($getresultdt);$p++){
                                $resdel = $getresultdt[$p];
                                $this->fetchTable('Parameter')->delete($resdel);
                            }
                        }
                        
                        $behaviroldt = $this->fetchTable('BehavioralPatterns')->find('all')
                            ->where(['mapping_ref_val' => 1 , 'mapping_ref_val' => $id, 'token_no' => $token])
                            ->toArray();
                        if(sizeof($behaviroldt)>0)
                        {
                            for($q=0;$q<sizeof($behaviroldt);$q++){
                                $behaviroldel = $behaviroldt[$q];
                                $this->fetchTable('BehavioralPatterns')->delete($behaviroldel);
                            }
                        }
                        
                        $propfields = $this->fetchTable('PropertyFields')->find('all')
                                ->where(['property_id' => $id , 'token_no' => $token])
                                ->toArray();
                        if(sizeof($propfields)>0)
                        {
                            for($r=0;$r<sizeof($propfields);$r++){
                                $propfielddel = $propfields[$r];
                                $this->fetchTable('PropertyFields')->delete($propfielddel);
                            }
                        }
                        
                        $propdetails = $this->fetchTable('PropertyDetailsEntry')->find('all')
                                ->where(['property_id' => $id , 'token_no' => $token])
                                ->toArray();
                        if(sizeof($propdetails)>0)
                        {
                            for($s=0;$s<sizeof($propdetails);$s++){
                                $propdetailsdel = $propdetails[$s];
                                $this->fetchTable('PropertyDetailsEntry')->delete($propdetailsdel);
                            }
                        }
                        
                        $ids = $this->fetchTable('FeeCalculation')
                                ->find()
                                ->select(['fee_calc_id'])
                                ->where(['token_no =' => $token, 'property_id' => $id, 'article_id' => $article_id ])
                                ->toArray(); 
                        
                        if(sizeof($ids)>0){
                            foreach ($ids as $id) {
                                $pid = $id->toArray();
                                $fee_calc_id = $pid['fee_calc_id'];
                                
                                $feecalc = $this->fetchTable('FeeCalculationDetail')->find('all')
                                ->where(['fee_calc_id' => $fee_calc_id])
                                ->toArray();
                                if(sizeof($feecalc)>0)
                                {
                                    for($t=0;$t<sizeof($feecalc);$t++){
                                        $feecalcdel = $feecalc[$t];
                                        $this->fetchTable('FeeCalculationDetail')->delete($feecalcdel);
                                    }
                                }
                                
                            }
                        }
                        
                        $fee = $this->fetchTable('FeeCalculation')->find('all')
                                ->where(['token_no =' => $token, 'property_id' => $id, 'article_id' => $article_id ])
                                ->toArray(); 
                        if(sizeof($fee)>0)
                        {
                            for($u=0;$u<sizeof($fee);$u++){
                                $feedel = $fee[$u];
                                $this->fetchTable('FeeCalculation')->delete($feedel);
                            }
                        }
                        
                        $partyentry = $this->fetch('PartyEntry')->find('all')
                                ->where(['token_no =' => $token, 'property_id' => $id ])
                                ->toArray(); 
                        if(sizeof($partyentry)>0)
                        {
                            for($v=0;$v<sizeof($partyentry);$v++){
                                $partydel = $partyentry[$v];
                                $this->fetchTable('PartyEntry')->delete($partydel);
                            }
                        }
                        
                        if ($flag == 'G') {
                            return true;
                        } else {
                            $this->Flash->success(__('Record Deleted Successfully.'));
                            return $this->redirect(['controller' => 'citizenentry', 'action' => 'property_details'], $this->request->getSession()->read('csrftoken'));
                        }
                    
                        
                }
            } catch (Exception $ex) {
                    $this->Session->setFlash(
                    __('Record Cannot be displayed. Error :' . $ex->getMessage())
            );
            return $this->redirect(array('controller' => 'Error', 'action' => 'exception_occurred'));
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

    public function getOfficeFromDist() {
        try {
            $lang = $this->request->getSession()->read('Config.language');
            $data = $this->request->getData();
            if (isset($data['taluka_id']) && is_numeric($data['taluka_id'])) {
                $taluka_id = $data['taluka_id'];
                if (isset($data['village_id']) && is_numeric($data['village_id'])) {
                    $village_id = $data['village_id'];
                    $officelist = $this->fetchTable('Office')
                                    ->find('list', [
                                        'keyField' => 'office_id',
                                        'valueField' => 'office_name_' . $lang])
                                    ->join([
                                        'OfficeVillageLinking' => [
                                            'table' => 'ngdrstab_trn_office_village_linking',
                                            'type' => 'INNER',
                                            'conditions' => 'OfficeVillageLinking.office_id = Office.office_id',
                                        ]
                                    ])->where(['OfficeVillageLinking.village_id =' => $village_id])->toArray();
                } else {

                    $officelist = $this->fetchTable('Office')
                                    ->find('list', [
                                        'keyField' => 'office_id',
                                        'valueField' => 'office_name_' . $lang])
                                    ->join([
                                        'OfficeVillageLinking' => [
                                            'table' => 'ngdrstab_trn_office_village_linking',
                                            'type' => 'INNER',
                                            'conditions' => 'OfficeVillageLinking.office_id = Office.office_id',
                                        ]
                                    ])->where(['OfficeVillageLinking.taluka_id =' => $taluka_id])->toArray();
                }
            } else {
//                $officevillagelinkingdata = $this->getTableLocator()->get('OfficeVillageLinking');
//                $officedata = $this->getTableLocator()->get('Office');
                //pr($data); exit;
                $district_id = $data['district_id'];
                $officelist = $this->fetchTable('Office')
                                ->find('list', [
                                    'keyField' => 'office_id',
                                    'valueField' => 'office_name_' . $lang])
                                ->join([
                                    'OfficeVillageLinking' => [
                                        'table' => 'ngdrstab_trn_office_village_linking',
                                        'type' => 'INNER',
                                        'conditions' => 'OfficeVillageLinking.office_id = Office.office_id',
                                    ]
                                ])->where(['OfficeVillageLinking.district_id =' => $district_id])->toArray();
            }
            echo json_encode($officelist);
            exit;
        } catch (exception $ex) {
            pr($ex);
            exit;
        }
    }
    public function getdependentarticle(){
        try {
            $data = $this->request->getData();
            //pr($data);exit;
            $article_id=$data['article_id'];
            $lang = $this->request->getSession()->read('Config.language');
            $token = $this->request->getSession()->read('Selectedtoken');
           
            $fieldlist = $this->fetchTable('ConfArticleFeeruleItems')
                        ->find()
                        ->select(['DISTINCT ConfArticleFeeruleItems.fee_param_code','ArticleFeeItems.fee_item_desc_' . $lang, 'ArticleFeeItems.display_order', 'ArticleFeeItems.is_date'])
                        ->join([
                            'ArticleFeeItems' => [
                                'table' => 'ngdrstab_mst_article_fee_items',
                                'type' => 'INNER',
                                'conditions' => 'ArticleFeeItems.fee_item_id = ConfArticleFeeruleItems.fee_item_id',
                            ]
                        ])->where(['ConfArticleFeeruleItems.article_id =' => $article_id,'ArticleFeeItems.gen_dis_flag' => 'Y', 'ConfArticleFeeruleItems.level1_flag' => 'Y'])
                        ->order(['ArticleFeeItems.display_order' => 'ASC'])
                        ->toArray();
            //pr($fieldlist);exit;
            $genderlist = $this->fetchTable('Gender')
                    ->find('list', [
                        'keyField' => 'gender_id',
                        'valueField' => 'gender_desc_' . $lang])
                    ->order(['gender_desc_en' => 'ASC'])
                    ->toArray(); 
            
            if ($token != '') {
                $result = $this->fetchTable('ConfArticleFeeruleItems')->gettrnarticledependentfeild($lang, $article_id, $token);
            }else{
                $result = $this->fetchTable('ConfArticleFeeruleItems')->gettrnarticledependentfeild($lang, $article_id);
            }
            //pr($result);exit;
            $items_list = array();

            if (isset($result)) {
                foreach ($result as $FeeItem) {
                    //pr($FeeItem['ArticleFeeItems']['list_flag']);
                    $feeitamid = $FeeItem['ArticleFeeItems']['fee_item_id'];
                    if ($FeeItem['ArticleFeeItems']['list_flag'] == 'Y') {
                        $items_list[$FeeItem[0]['fee_param_code']] = $this->fetchTable('ConfArticleFeeItemsList')->find('list', [                                                            'keyField' => 'fee_item_list_id',
                                                                        'valueField' => 'fee_item_list_desc_' . $lang])
                                                                    ->where(['fee_item_id'=>$feeitamid]);

                    }
                }
                $this->set(compact('result', 'items_list'));
            }
                
            $this->set(compact('fieldlist','genderlist'));
           
              
        } catch (Exception $ex) {
            $this->Session->setFlash(
                    __('Record Cannot be displayed. Error :' . $ex->getMessage())
            );
            return $this->redirect(array('controller' => 'Error', 'action' => 'exception_occurred'));
        }
    }

}
