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

use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
//use Cake\ORM\Locator\LocatorAwareTrait;
/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */

class IdentificationController extends AppController {
    var $base_path = WWW_ROOT;

    public function identification(){

                 

        $Selectedtoken = $this->request->getSession()->read('Selectedtoken');
        $Selectedtoken='202300000004';
        $reschedule_flag = $this->request->getSession()->read('reschedule_flag');
        $userrole_id = $this->request->getSession()->read('user_role_id');
        $this->restrict_edit_after_submit($Selectedtoken);
        if (!is_numeric($Selectedtoken)) {
            $this->Flash->success(__('Saved Successfully'));
                return $this->redirect(['controller' => 'Generalinfo', 'action' => 'generalinfoentry']);
        }
        if($reschedule_flag=='Y'){
            return $this->redirect(['controller' => 'Appointment', 'action' => 'appointment']);
        }


        $identificationdet = $this->getTableLocator()->get('Identification');
        $NGDRSErrorCode = $this->getTableLocator()->get('NGDRSErrorCode');
        $last_status_id = $this->request->getSession()->read('last_status_id');
        $lang = $this->request->getSession()->read('Config.language');
        
        $session_usertype = $this->request->getSession()->read('session_usertype');
        $state_id = $this->request->getAttribute('identity')->state_id;
        $user_id = $this->request->getAttribute('identity')->user_id;
        $citizen_user_id = $this->request->getAttribute('identity')->citizen_user_id;
      
        $identificationrec = $this->fetchTable('Identification')
                                    ->find('all')
                                    ->where(['token_no =' => $Selectedtoken])
                                    ->toArray(); 

        
        if ($userrole_id == '999901' || $userrole_id == '999902' ||$userrole_id == '999903') {                            
            $identifieropt = $this->fetchTable('IdentifierType')
                                ->find('list', [
                                    'keyField' => 'type_id',
                                    'valueField' => 'desc_en'
                                ])->where(['witness_flag =' => 'Y'])->toArray();
                                       
        }
        else{
            $identifieropt = $this->fetchTable('IdentifierType')
                        ->find('list', [
                            'keyField' => 'type_id',
                            'valueField' => 'desc_en'
                        ])
                        ->where(['citizen_flag =' => 'Y'])->toArray();  
        }   


        //pr($identifieropt);exit;
        $this->set('identifieropt', $identifieropt);
        $actiontypeval = $hfid = $hfupdateflag = $popupstatus = $identification_id = NULL;
        $this->set(compact('actiontypeval', 'hfid','hfupdateflag','identification_id','state_id','identificationrec','lang'));

        if ($this->request->is('post')) {
            $reqdata = $this->request->getData();
            

            $hfid = $reqdata['hfid'];
            $identification_id = $reqdata['identification_id'];
            $hfupdateflag = $reqdata['hfupdateflag'];

            if(isset($reqdata['village_id'])){
                $village_id = $reqdata['village_id'];
            }
            else{
                $village_id = 0;
            }
            $fieldlist = $this->fetchTable('IdentificationFields')->fieldlist($lang,$village_id);

            if (isset($reqdata['identification_full_name_en'])){
                if($reqdata['identification_full_name_en']==''){
                    if(isset($reqdata['fname_en']))
                    {
                        if($reqdata['fname_en']!='')
                        {        
                                $reqdata['identification_full_name_en'] = ucwords($reqdata['fname_en']).' '.ucwords($reqdata['mname_en']).' '.ucwords($reqdata['lname_en']);
                                $reqdata['fname_en'] = ucwords($reqdata['fname_en']);
                                $reqdata['mname_en'] = ucwords($reqdata['mname_en']);
                                $reqdata['lname_en'] = ucwords($reqdata['lname_en']);
                        }
                    }
                }
                else{
                    $reqdata['identification_full_name_en'] = ucwords($reqdata['identification_full_name_en']);
                }
            }
            else{
                if (isset($reqdata['fname_en']))
                {
                        if($reqdata['fname_en']!='')
                        {
                                $reqdata['identification_full_name_en'] = ucwords($reqdata['fname_en']).' '.ucwords($reqdata['mname_en']).' '.ucwords($reqdata['lname_en']);
                                $reqdata['fname_en'] = ucwords($reqdata['fname_en']);
                                $reqdata['mname_en'] = ucwords($reqdata['mname_en']);
                                $reqdata['lname_en'] = ucwords($reqdata['lname_en']);

                        }
                }
            }

            if(isset($reqdata['uid_no']))
            {
                $reqdata['uid_no']=$this->enc($reqdata['uid_no']);
            }
            
            //pr($reqdata);exit;
            $this->save_identifier($reqdata, $Selectedtoken, $state_id, $user_id, $hfid, $session_usertype,$identification_id);

            if($hfid!='')
            {
                $this->Flash->success(__('Identifier Details Updated Successfully'));
            }
            else{
                $this->Flash->success(__('Identifier Details Saved Successfully'));
            }
            return $this->redirect(['controller' => 'Identification', 'action' => 'identification']);

        }


    }

    public function save_identifier($reqdata, $Selectedtoken, $state_id, $user_id, $hfid, $session_usertype,$identification_id){
        $identificationdet = $this->getTableLocator()->get('Identification');
        $identification_add = $identificationdet->newEmptyEntity();
        $this->set('identification_add', $identification_add);
        $identificationfieldsdet = $this->getTableLocator()->get('IdentificationFields');       
        $pan = isset($reqdata['pan_no']) ? ($reqdata['pan_no']) : ('');
        $mobile = isset($reqdata['mobile_no']) ? ($reqdata['mobile_no']) : ('');
        $uid = isset($reqdata['uid_no']) ? ($reqdata['uid_no']) : ('');
        $email = isset($reqdata['email_id']) ? ($reqdata['email_id']) : ('');

        $reqdata['state_id']=$state_id;
        $reqdata['user_id']=$user_id;
        if(isset($session_usertype)){
            $reqdata['user_type']=$session_usertype;
        }
       

        if($session_usertype=='O')
        {
            if($identification_id!='' && is_numeric($identification_id)){
                $reqdata['org_updated']=date('Y-m-d H:i:s');
                $reqdata['updated']=date('Y-m-d H:i:s');
            }else{
                $reqdata['org_created']=date('Y-m-d H:i:s');
                $reqdata['created']=date('Y-m-d H:i:s');
            }
        }

        if (isset($hfid) && $hfid!='') {
            $action = 'U';
            $dataid = ['id' => $hfid]; 
            $dataidentificationid = ['identification_id' => $identification_id]; 
            $identification_add = $identificationdet->patchEntity($identification_add, $reqdata);
            $identification_add = $identificationdet->patchEntity($identification_add, $dataid);
            $identification_add = $identificationdet->patchEntity($identification_add, $dataidentificationid);
            //pr($witness_add);exit;
            if($identificationdet->save($identification_add)){
                if(isset($reqdata['data']['property_details']['pattern_value_en'])){
                    $behavioraldet = $this->getTableLocator()->get('TrnBehavioralPatterns');
                    $behavioral_add = $behavioraldet->newEmptyEntity();

                    //delete records
                    $behavioraldet->deleteAll(['token_no' => $Selectedtoken,'mapping_ref_id'=>'5', 'mapping_ref_val' => $identification_id]);

                    $pattern_id_array = $reqdata['data']['property_details']['pattern_id'];
                    $pattern_value_array = $reqdata['data']['property_details']['pattern_value_en'];

                    for($i=0;$i<sizeof($pattern_id_array);$i++){
                        //pr($pattern_id_array[$i]);
                        //pr($pattern_value_array[$i]);

                        $savearray['token_no']=$Selectedtoken;
                        $savearray['mapping_ref_id']='5';
                        $savearray['mapping_ref_val']=$identification_id;
                        $savearray['user_id']=$user_id;
                        $savearray['user_type']=$session_usertype;
                        $savearray['field_id']=$pattern_id_array[$i];
                        $savearray['field_value_en']=$pattern_value_array[$i];
                        
                        //pr($savearray);
               
                        $behavioraldet = $this->getTableLocator()->get('TrnBehavioralPatterns');
                        $behavioral_add = $behavioraldet->newEmptyEntity();
                        $behavioral_add = $behavioraldet->patchEntity($behavioral_add, $savearray);
                        $behavioraldet->save($behavioral_add);
                    }
                }
            }

            return true;
        }else{
                $action = 'S';
                $identifier_add = $identificationdet->patchEntity($identification_add, $reqdata);
                if($identificationdet->save($identifier_add))
                {
                    $last_id = $identifier_add->identification_id;

                    if(isset($reqdata['data']['property_details']['pattern_value_en'])){
                        $behavioraldet = $this->getTableLocator()->get('TrnBehavioralPatterns');
                        $behavioral_add = $behavioraldet->newEmptyEntity();

                        //delete records
                        $behavioraldet->deleteAll(['token_no' => $Selectedtoken,'mapping_ref_id'=>'5', 'mapping_ref_val' => $last_id]);

                        $pattern_id_array = $reqdata['data']['property_details']['pattern_id'];
                        $pattern_value_array = $reqdata['data']['property_details']['pattern_value_en'];
    
                        for($i=0;$i<sizeof($pattern_id_array);$i++){
                            //pr($pattern_id_array[$i]);
                            //pr($pattern_value_array[$i]);
    
                            $savearray['token_no']=$Selectedtoken;
                            $savearray['mapping_ref_id']='5';
                            $savearray['mapping_ref_val']=$last_id;
                            $savearray['user_id']=$user_id;
                            $savearray['user_type']=$session_usertype;
                            $savearray['field_id']=$pattern_id_array[$i];
                            $savearray['field_value_en']=$pattern_value_array[$i];
                            
                            //pr($savearray);
                   
                            $behavioraldet = $this->getTableLocator()->get('TrnBehavioralPatterns');
                            $behavioral_add = $behavioraldet->newEmptyEntity();
                            $behavioral_add = $behavioraldet->patchEntity($behavioral_add, $savearray);
                            $behavioraldet->save($behavioral_add);
                        }
                    }
                }
                return true;
        }


    }

    public function identificationdelete($identification_id=null) {
        //pr($witness_id);exit;
        if (isset($identification_id) && is_numeric($identification_id)) {
            $identificationrec = $this->getTableLocator()->get('Identification');
            $entity = $identificationrec->get($identification_id);
            //pr($entity);exit;
            $result = $identificationrec->delete($entity);
            $this->Flash->success(
                    __('Identifier Details Deleted Successfully.')
            );
            return $this->redirect(['controller' => 'Identification', 'action' => 'identification']);
        }
    }
    public function getidentificationfeilds(){
        $data = $this->request->getData();
        
        $lang = $this->request->getSession()->read('Config.language');
        $Selectedtoken = $this->request->getSession()->read('Selectedtoken');
        $Selectedtoken='202300000004';
        $generalinfodet = $this->getTableLocator()->get('Generalinformation');
        $identificationdet = $this->getTableLocator()->get('Identification');
        $identificationfieldsdet = $this->getTableLocator()->get('IdentificationFields');
        
        $identifier_fields = $identificationfieldsdet->newEmptyEntity();
        $this->set('identifier_fields', $identifier_fields);

        $executer = ['Y' => ' Yes ', 'N' => ' No '];
        $marital_status = ['M' => 'Married', 'U' => 'Unmarried'];
        $home_visit = ['N' => 'NO', 'Y' => 'Yes'];
        
        $bank_master = $this->fetchTable('BankMaster')->find('list', [
            'keyField' => 'bank_id',
            'valueField' => 'bank_name_' . $lang
        ])->order(['bank_name_en' => 'ASC'])->toArray();
        $this->set('bank_master', $bank_master);
        
        $nationality = $this->fetchTable('Nationality')->find('list', [
            'keyField' => 'nationality_id',
            'valueField' => 'nationality_name_' . $lang
        ])->order(['nationality_id' => 'ASC'])->toArray();
        $this->set('nationality', $nationality);
        
        $salutation = $this->fetchTable('Salutation')->find('list', [
            'keyField' => 'salutation_id',
            'valueField' => 'salutation_desc_' . $lang
        ])->order(['salutation_id' => 'ASC'])->toArray();
        $this->set('salutation', $salutation);
        
        $gender = $this->fetchTable('Gender')->find('list', [
            'keyField' => 'gender_id',
            'valueField' => 'gender_desc_' . $lang
        ])->order(['gender_desc_en' => 'ASC'])->toArray();
        $this->set('gender', $gender);
        
        $occupation = $this->fetchTable('Occupation')->find('list', [
            'keyField' => 'occupation_id',
            'valueField' => 'occupation_name_' . $lang
        ])->order(['occupation_name_en' => 'ASC'])->toArray();
        $this->set('occupation', $occupation);
        
        $exemption = $this->fetchTable('PresentationExmp')->find('list', [
            'keyField' => 'exemption_id',
            'valueField' => 'desc_' . $lang
        ])->order(['exemption_id' => 'ASC'])->toArray();
        $this->set('exemption', $exemption);
        
        $allrule = $this->fetchTable('NGDRSErrorCode')
                    ->find()
                    ->select(['DISTINCT NGDRSErrorCode.error_code','NGDRSErrorCode.pattern_rule_client', 'NGDRSErrorCode.error_messages_'. $lang])
                    ->join([
                        'IdentificationType' => [
                            'table' => 'ngdrstab_mst_identificationtype',
                            'type' => 'INNER',
                            'conditions' => 'IdentificationType.error_code_id = NGDRSErrorCode.error_code_id',
                        ]
                    ])->toArray();
        $this->set('allrule', $allrule);
        
        $districtdata = $this->fetchTable('District')->find('list', [
                    'keyField' => 'district_id',
                    'valueField' => 'district_name_' . $lang
                ])->order(['district_name_en' => 'ASC'])->toArray();
        $this->set('districtdata', $districtdata);
        
        $taluka = $this->fetchTable('Taluka')->find('list', [
            'keyField' => 'taluka_id',
            'valueField' => 'taluka_name_' . $lang
        ])->order(['taluka_name_en' => 'ASC'])->toArray();
        $this->set('taluka', $taluka);
        
        //$villagelist = array();
        $villagelist = $this->fetchTable('Village')->find('list', [
            'keyField' => 'village_id',
            'valueField' => 'village_name_' . $lang
        ])->order(['village_name_en' => 'ASC'])->toArray();
        $this->set('villagelist', $villagelist);

        $name_format = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(15);
        $this->set('name_format', $name_format);

        $identificatontype= $this->fetchTable('IdentificationType')->find('list', [
            'keyField' => 'identificationtype_id',
            'valueField' => 'identificationtype_desc_' . $lang
        ])
        ->where(['identification_flag =' => 'Y'])
        ->order(['identificationtype_desc_en' => 'ASC'])->toArray();
        $this->set('identificatontype', $identificatontype);
        
        $category=$this->fetchTable('CasteCategory')->find('list', [
            'keyField' => 'id',
            'valueField' => 'category_name_' . $lang
        ])->order(['category_name_en' => 'ASC'])->toArray();
        $this->set('category', $category);
        
        $gov_partytype=$this->fetchTable('GovPartyType')->find('list', [
            'keyField' => 'id',
            'valueField' => 'government_type_' . $lang
        ])->order(['government_type_en' => 'ASC'])->toArray();
        $this->set('gov_partytype', $gov_partytype);

        $allparty= $this->fetchTable('PartyEntry')->find('list', [
            'keyField' => 'party_id',
            'valueField' => 'party_full_name_' . $lang
        ])
        ->where(['token_no =' => $Selectedtoken])
        ->order(['party_full_name_en' => 'ASC'])->toArray();
        $this->set('allparty', $allparty);

        

        if(isset($data['type'])){
            if ($data['type'] == 3) {

                $opt = $this->fetchTable('IdentificationFields')
                        ->updateAll(['display_flag' => 'Y'],['field_id_name_en =' => 'party_id']);   

            } else {
                $opt = $this->fetchTable('IdentificationFields')
                        ->updateAll(['display_flag' => 'N'],['field_id_name_en =' => 'party_id']);   
            }
        } else {
                $opt = $this->fetchTable('IdentificationFields')
                    ->updateAll(['display_flag' => 'N'],['field_id_name_en =' => 'party_id']);   
        }

        $identifirefields = array();

        $identifirefields=$this->fetchTable('IdentificationFields')
                        ->find()
                        ->where(['display_flag' => 'Y'])
                        ->order(['IdentificationFields.order' => 'ASC'])->toArray();
            
        $this->set('identifirefields', $identifirefields);   
        //pr($identifirefields);
        $fieldlist=array();
        $fieldlist = $this->fetchTable('IdentificationFields')->fieldlist($lang);
        //pr($fieldlist);
        $this->set('fieldlistmultiform', $fieldlist);
        //pr($this->getvalidationruleset($fieldlist, TRUE));
        $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));

        if (isset($data['id']) && is_numeric($data['id'])) {
            //pr($data['id']);exit;
            $identifier_id = $data['id'];
            $identifierarr = $this->fetchTable('Identification')
                            ->find('all')
                            ->where(['token_no =' => $Selectedtoken,'id' => $identifier_id])
                            ->toArray(); 
            //pr($witnessarr);
            $this->set('identifierarr', $identifierarr);

        }
        
    }

    public function gettalukadist(){
        $data = $this->request->getData();
        $this->autoRender = FALSE;
        $districtid = $data['district_id'];
        $taluka = $this->getTableLocator()->get('Taluka');

        $talukalist = $taluka
                ->find('list', [
                    'keyField' => 'taluka_id',
                    'valueField' => 'taluka_name_en'])
                ->where(['district_id =' => $districtid]);

        $talukalistdata = $talukalist->toArray();
        echo json_encode($talukalistdata);
        exit;
    }

    public function getvillagetaluka(){
        $data = $this->request->getData();
        $this->autoRender = FALSE;
        $districtid = $data['district_id'];
        $talukaid = $data['taluka_id'];
        $village = $this->getTableLocator()->get('Village');

        $villagelist = $village
                ->find('list', [
                    'keyField' => 'village_id',
                    'valueField' => 'village_name_en'])
                ->where(['district_id' => $districtid,'taluka_id' => $talukaid]);

        $villagelistdata = $villagelist->toArray();
        //pr($villagelistdata);
        echo json_encode($villagelistdata);
        exit;
    }

    public function getdependentaddress(){
        try {
        
        $Selectedtoken = $this->request->getSession()->read('Selectedtoken');
        $Selectedtoken='202300000004';

        $data = $this->request->getData();
        $ref_id = $data['ref_id'];
        $behavioral_id = $data['behavioral_id'];
        $village_id = $data['village_id'];

        if(isset($data['ref_val_id']))
        {
            $ref_val_id = $data['ref_val_id'];
        }
        if(isset($data['ref_val_identification_id']))
        {
            $ref_val_identification_id = $data['ref_val_identification_id'];
        }

        $village = $this->getTableLocator()->get('Village');
        $behavioral = $this->getTableLocator()->get('Behavioral');
        $behavioraldetails = $this->getTableLocator()->get('BehavioralDetails');
        $behavioralpatterns = $this->getTableLocator()->get('BehavioralPatterns');
        $trnbehavioralpatterns = $this->getTableLocator()->get('TrnBehavioralPatterns');
        //DevelopLandType
        $trnbehavioral = array();
        if(is_numeric($ref_id) && is_numeric($behavioral_id))
        {
            if($ref_id==1 || $ref_id==2 || $ref_id==3 || $ref_id==4 || $ref_id==5 || $ref_id==9999){

                $villagedata = $this->fetchTable('Village')
                ->find()
                ->select(['Village.developed_land_types_id','DevelopLandType.land_type_flag'])
                ->join([
                    'DevelopLandType' => [
                        'table' => 'ngdrstab_mst_developed_land_types',
                        'type' => 'INNER',
                        'conditions' => 'DevelopLandType.developed_land_types_id = Village.developed_land_types_id',
                    ]
                ])
                ->where(['village_id' => $village_id])->toArray();

                $land_type = $villagedata[0]['developed_land_types_id'];
                $land_type_flag = $villagedata[0]['DevelopLandType']['land_type_flag'];
                //pr($land_type_flag);
                $behavioralpatterns = array();
                if(isset($data['usage_id']) && is_numeric($data['usage_id'])){
                    $usage_id = $data['usage_id'];
                    $maincategorydata = $this->fetchTable('UsageCategory')
                    ->find()
                    ->select(['usage_main_catg_id'])
                    ->where(['evalrule_id' => $usage_id])->toArray();
                    $main_cat_id = $maincategorydata[0]['usage_main_catg_id'];


                    $behavioralpatterns = $behavioral
                        ->find()
                        ->select(['BehavioralPatterns.field_id','Behavioral.behavioral_desc_display_en','BehavioralPatterns.pattern_desc_ll','BehavioralPatterns.pattern_desc_en','BehavioralPatterns.is_required'])
                        ->join([
                            'BehavioralDetails' => [
                                'table' => 'ngdrstab_conf_behavioral_details',
                                'type' => 'INNER',
                                'conditions' => 'BehavioralDetails.behavioral_id = Behavioral.behavioral_id',
                            ],
                            'BehavioralPatterns' => [
                                'table' => 'ngdrstab_conf_behavioral_patterns',
                                'type' => 'INNER',
                                'conditions' => 'BehavioralPatterns.behavioral_details_id = BehavioralDetails.behavioral_details_id',
                            ],
                        ])
                        ->where(['BehavioralPatterns.behavioral_id' =>'1','BehavioralDetails.developed_land_types_flag' => $land_type_flag, 'BehavioralDetails.main_usage_id' => $main_cat_id ])
                        ->toArray();
                    

                }else{
                        $behavioralpatterns = $behavioral
                            ->find()
                            ->select(['BehavioralPatterns.field_id','Behavioral.behavioral_desc_display_en','BehavioralPatterns.pattern_desc_ll','BehavioralPatterns.pattern_desc_en','BehavioralPatterns.is_required'])
                            ->join([
                                'BehavioralDetails' => [
                                    'table' => 'ngdrstab_conf_behavioral_details',
                                    'type' => 'INNER',
                                    'conditions' => 'BehavioralDetails.behavioral_id = Behavioral.behavioral_id',
                                ],
                                'BehavioralPatterns' => [
                                    'table' => 'ngdrstab_conf_behavioral_patterns',
                                    'type' => 'INNER',
                                    'conditions' => 'BehavioralPatterns.behavioral_details_id = BehavioralDetails.behavioral_details_id',
                                ],
                            ])
                            ->where(['BehavioralPatterns.behavioral_id' =>$behavioral_id,'BehavioralDetails.developed_land_types_flag' => $land_type_flag])
                            ->toArray();
                }
                $this->set("behavioralpatterns", $behavioralpatterns);

                $behavioralarray = array();
                for($i=0;$i<sizeof($behavioralpatterns);$i++){
                    $behavioral_desc_display_en = $behavioralpatterns[$i]['behavioral_desc_display_en'];
                    $field_id = $behavioralpatterns[$i]['BehavioralPatterns']['field_id'];
                    $pattern_desc_en = $behavioralpatterns[$i]['BehavioralPatterns']['pattern_desc_en'];

                    $behavioralarray[$i]['behavioral_desc_display_en'] = $behavioral_desc_display_en;
                    $behavioralarray[$i]['field_id'] = $field_id;
                    $behavioralarray[$i]['pattern_desc_en'] = $pattern_desc_en;
       
                }

                $user_id = $this->request->getSession()->read('Auth.user_id');
                if (file_exists($this->base_path . 'files/jsonfile_' . $user_id . '.json')) {
                    $file = new File($this->base_path . 'files/jsonfile_' . $user_id . '.json');
                } else {
                    $file = new File($this->base_path . 'files/jsonfile_' . $user_id . '.json', true, 0755);
                }

                $jsonarraystore['BehavioralPatterns'] = $behavioralarray;
                $file->write(json_encode($jsonarraystore));
                $file->close();

                /*if (file_exists($this->base_path . 'files/jsonfile_' . $user_id . '.json')) {
                    $file = new File($this->base_path . 'files/jsonfile_' . $user_id . '.json');
                } else {
                    $file = new File($this->base_path . 'files/jsonfile_' . $user_id . '.json', true, 0755);
                }
                $json = $file->read();
                $json2array = json_decode($json, TRUE);
                pr($json2array);*/

                


            }
        }
            if(isset($data['ref_val_identification_id']) && is_numeric($data['ref_val_identification_id'])){
            $trnbehavioral = $this->fetchTable('TrnBehavioralPatterns')
            ->find()
            ->where(['mapping_ref_id' => $ref_id, 'mapping_ref_val' => $data['ref_val_identification_id'], 'token_no' => $Selectedtoken])
            ->toArray();
            
            }
            $this->set("trnbehavioral", $trnbehavioral);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getvalidationrule(){
        //pr('aaaaaaaaaaaaaa');exit;
        $lang = $this->request->getSession()->read('Config.language');
        $data = $this->request->getData();
        $this->autoRender = FALSE;
        $data_sent = array();
        if(isset($data['type'])){
            $typeid = $data['type'];
            $allrule = $this->fetchTable('IdentificationType')
                    ->find()
                    ->select(['NGDRSErrorCode.error_code' ,'NGDRSErrorCode.pattern_rule_client' ,'NGDRSErrorCode.error_messages_' . $lang])
                    ->join([
                        'NGDRSErrorCode' => [
                            'table' => 'ngdrstab_mst_errorcodes',
                            'type' => 'INNER',
                            'conditions' => 'IdentificationType.error_code_id = NGDRSErrorCode.error_code_id',
                        ]
                    ])
                    ->where(['identificationtype_id' => $typeid])
                    ->toArray();
            //pr($allrule);
            $data_sent['message'] = $allrule[0]['NGDRSErrorCode']['error_messages_'.$lang];
            $data_sent['pattern'] = $allrule[0]['NGDRSErrorCode']['pattern_rule_client'];
            $data_sent['error_code'] = $allrule[0]['NGDRSErrorCode']['error_code'];
            echo json_encode($data_sent);
            exit;
        }

        
    }

}
