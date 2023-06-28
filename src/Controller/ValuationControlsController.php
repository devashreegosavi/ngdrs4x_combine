<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//KALYANI 

namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;

class ValuationControlsController extends ValuationController {

    public function level1($level_1_id = NULL, $action = NULL) {
        try {
            $result = $this->get_valuation_config(); //Adm block config
            $this->valuation_initialize($result); //Adm Block initial vlaues
            $lang = $this->request->getSession()->read('Config.language');
            $Level1 = $this->getTableLocator()->get('Level1');
            $result = $Level1->find()->toArray();
            $this->set('result', $result);
            $NGDRSErrorCode = $this->getTableLocator()->get('NGDRSErrorCode');
            $errorlist = $NGDRSErrorCode->find('list', [
                'keyField' => 'error_code_id',
                'valueField' => 'error_code'
            ]);
            $errorlistdata = $errorlist->toArray();
            $this->set('errorlistdata', $errorlistdata);
            $fieldlist = $this->fetchTable('Level1')->fieldlist(); //Validation set in function
            $this->set('fieldlistmultiform', $fieldlist);
            $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));
            $Level1 = $this->fetchTable('Level1')->newEmptyEntity();
            if ($this->request->is('post') || $this->request->is('put')) {
                $level_1_id = $this->request->getSession()->read('level_1_id');
                $request_data = $this->request->getData();
                $request_data['level_1_id'] = $level_1_id;
                $errarr = $this->validatedata($request_data, $fieldlist['level1']); //Server side validation
                if ($this->ValidationError($errarr)) {
                    $leveldata = $this->fetchTable('Level1')->patchEntity($Level1, $request_data);
                    if ($this->fetchTable('Level1')->save($leveldata)) {
                        $this->Flash->success(__('Level1 added  successfully.'));
                        return $this->redirect('/ValuationControls/level1');
                    }
                    $this->Flash->error(__('Failed.'));
                }
                $this->Flash->error(__('Your formcontrols failed.'));
            }
            if (is_numeric($level_1_id) && $action == 'E') {//Edit
                $leveldata = $this->fetchTable('Level1')->getleveldata($level_1_id, $lang); //Query for level hierarchy setup
                if (!empty($leveldata)) {
                    $Edit_request_data = $this->fetchTable('Level1')->assigndata($leveldata); //Assigning data while Edit
                    $Level1 = $this->fetchTable('Level1')->patchEntity($Level1, $Edit_request_data);
                    $this->set('Level1', $Level1);
                    $editresult = $this->CommonAdmblockEdit($leveldata); //Call to common edit 
                    $this->set(array('Subdivision_List' => $editresult['subdivision'], 'Taluka_List' => $editresult['taluka'], 'District_List' => $editresult['district'], 'Circle_List' => $editresult['circle'], 'Village_List' => $editresult['village'], 'Dtypes_List' => $editresult['dtypes'], 'Corp_List' => $editresult['corp']));
                    $this->request->getSession()->write("level_1_id", $level_1_id);
                }
            } elseif (is_numeric($level_1_id) && $action == 'D') {
                $entity = $this->fetchTable('Level1')->get($level_1_id);
                $this->fetchTable('Level1')->delete($entity);
                $this->Flash->success(__('Your Profile Deleted Successful.'));
                return $this->redirect('/ValuationControls/level1');
            }
            $this->set('Level1', $Level1);
        } catch (Exception $ex) {
          
            echo $ex->getTraceAsString();
        }
    }

    //dependency code
    public function getdistdata() {
        $lang = $this->request->getSession()->read('Config.language');
        $data = $this->request->getData();
        $this->autoRender = FALSE;
        $divisionid = $data['division_id'];
        $district = $this->getTableLocator()->get('District');

        $districtlist = $district
                ->find('list', [
                    'keyField' => 'district_id',
                    'valueField' => 'district_name_' . $lang])
                ->where(['division_id =' => $divisionid]);

        $districtlistdata = $districtlist->toArray();

        echo json_encode($districtlistdata);
        exit;
        //  $this->set('districtlistdata', $districtlistdata);
    }

//dependency code
    public function getsubdivdata() {
        $lang = $this->request->getSession()->read('Config.language');
        $data = $this->request->getData();
        $this->autoRender = FALSE;
        $districtid = $data['district_id'];
        $Subdivision = $this->getTableLocator()->get('Subdivision');

        $Subdivisionlist = $Subdivision
                ->find('list', [
                    'keyField' => 'subdivision_id',
                    'valueField' => 'subdivision_name_' . $lang])
                ->where(['district_id =' => $districtid]);

        $Subdivisionlistdata = $Subdivisionlist->toArray();



        echo json_encode($Subdivisionlistdata);
        exit;
        //  $this->set('districtlistdata', $districtlistdata);
    }

    public function level1list($prop_level1_list_id = NULL, $action = NULL) {
        try {

            //ngdrstab_mst_loc_level_1_prop_list
            $result = $this->get_valuation_config(); //Adm block config
            $this->valuation_initialize($result); //Adm Block initial vlaues
            $lang = $this->request->getSession()->read('Config.language');
            $Level1List = $this->getTableLocator()->get('Level1List');
            $result = $Level1List->find()->toArray();
            $this->set('result', $result);
            $NGDRSErrorCode = $this->getTableLocator()->get('NGDRSErrorCode');
            $errorlist = $NGDRSErrorCode->find('list', [
                'keyField' => 'error_code_id',
                'valueField' => 'error_code'
            ]);
            $errorlistdata = $errorlist->toArray();
            $this->set('errorlistdata', $errorlistdata);
            $fieldlist = $this->fetchTable('Level1List')->fieldlist(); //Validation set in function
            $this->set('fieldlistmultiform', $fieldlist);
            $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));
            $Level1List = $this->fetchTable('Level1List')->newEmptyEntity();

            $Level1data = $this->fetchTable('Level1')->find('list', [
                        'keyField' => 'level_1_id',
                        'valueField' => 'level_1_desc_' . $lang
                    ])->toArray();
            $this->set('Level1data', $Level1data);
            if ($this->request->is('post') || $this->request->is('put')) {
                //  pr($this->request->getData());exit;

                $prop_level1_list_id = $this->request->getSession()->read('prop_level1_list_id');
                $request_data = $this->request->getData();
                $request_data['prop_level1_list_id'] = $prop_level1_list_id;
                $errarr = $this->validatedata($request_data, $fieldlist['level1list']); //Server side validation
                if ($this->ValidationError($errarr)) {
                    $levellistdata = $this->fetchTable('Level1List')->patchEntity($Level1List, $request_data);
                    if ($this->fetchTable('Level1List')->save($levellistdata)) {
                        //       exit;
                        $this->Flash->success(__('Location Level 1 List added  successfully.'));
                        return $this->redirect('/ValuationControls/level1list');
                    }
                    $this->Flash->error(__('Failed.'));
                }
                $this->Flash->error(__('Your formcontrols failed.'));
            }
            if (is_numeric($prop_level1_list_id) && $action == 'E') {//Edit
                $levellistdata = $this->fetchTable('Level1List')->getleveldata($prop_level1_list_id, $lang); //Query for level hierarchy setup
                //  pr($levellistdata);exit;
                if (!empty($levellistdata)) {
                    $Edit_request_data = $this->fetchTable('Level1List')->assigndata($levellistdata); //Assigning data while Edit
                    // pr($Edit_request_data);exit;
                    $Level1List = $this->fetchTable('Level1List')->patchEntity($Level1List, $Edit_request_data);
                    $this->set('Level1List', $Level1List);
                    $editresult = $this->CommonAdmblockEdit($levellistdata); //Call to common edit 
                    //    pr($editresult);exit;
                    $this->set(array('Subdivision_List' => $editresult['subdivision'], 'Taluka_List' => $editresult['taluka'], 'District_List' => $editresult['district'], 'Circle_List' => $editresult['circle'], 'Village_List' => $editresult['village'], 'Dtypes_List' => $editresult['dtypes'], 'Corp_List' => $editresult['corp'], 'Level1_Data' => $editresult['level1']));
                    $this->request->getSession()->write("prop_level1_list_id", $prop_level1_list_id);
                }
            } elseif (is_numeric($prop_level1_list_id) && $action == 'D') {
                $entity = $this->fetchTable('Level1')->get($prop_level1_list_id);
                $this->fetchTable('Level1')->delete($entity);
                $this->Flash->success(__('Your Profile Deleted Successful.'));
                return $this->redirect('/ValuationControls/level1list');
            }
            $this->set('Level1List', $Level1List);
        } catch (Exception $ex) {
            pr($ex);
            exit;
            echo $ex->getTraceAsString();
        }
    }

    public function CommonAdmblockEdit($data) {
        //pr($data);exit;
//Levels
//        Division –Y:  
//·         Get all division-Done
//·         Get district from division-Done
//        Division –N
//·         Get all district-Done
//        Sub Division – Y
//         Get sub division from district-Done
//         Get Taluka  from subdivision-done
//        Tehsil – Y & Sub Division – N
//         Get Taluka  from district-DONE
//        Circle – Y
//·         Get Circle From  Taluka  
//·         Get village from Circle-done
//        Village == Y  & Circle == N
//·         Get village from taluka-Done
//Array
//(
//    [AdmBlocks] => Array
//        (
//            [is_div] => Y 
//            [is_dist] => Y
//            [is_subdiv] => Y
//            [is_taluka] => Y
//            [is_circle] => 
//            [is_village] => Y
//        )
//
//)

        $result = NULL;
        $Village_id = $data['Village']['village_id'];
        $Circle_id = $data['Village']['circle_id'];
        $landtype = $data['landtype']['developed_land_types_id'];
        $corporation_id = $data['corptype']['corp_id'];
        $Taluka_id = $data['Taluka']['taluka_id'];
        $Subdivision_id = $data['Taluka']['subdivision_id'];
        $District_id = $data['District']['district_id'];
        $Division_id = $data['District']['division_id'];
        if(isset($data['level_1_id'])){
            $level_id = $data['level_1_id']; 
        }else{
           $level_id = $data['Level1']['level_1_id'];  
        }
       
        $lang = $this->request->getSession()->read('Config.language');
        $config = $this->get_valuation_config();
        //    pr($config);exit;
//District Selection from Division

        if ($config['AdmBlocks']['is_div'] == 'Y') {
            if (isset($Division_id)) {
                $result['district'] = $this->fetchTable('District')
                                ->find('list', [
                                    'keyField' => 'district_id',
                                    'valueField' => 'district_name_' . $lang])
                                ->where(['division_id =' => $Division_id])->toArray();
            } else {
                $result['district'] = $this->fetchTable('District')
                        ->find('list', [
                            'keyField' => 'district_id',
                            'valueField' => 'district_name_' . $lang])
                        ->toArray();
            }
        }

        if ($config['AdmBlocks']['is_subdiv'] == 'Y') {
            //Subdivion from district
            if (isset($District_id)) {
                $result['subdivision'] = $this->fetchTable('Subdivision')
                                ->find('list', [
                                    'keyField' => 'subdivision_id',
                                    'valueField' => 'subdivision_name_' . $lang])
                                ->where(['district_id =' => $District_id])->toArray();
            }
        }
        //Taluka From Subdivision
        if ($config['AdmBlocks']['is_subdiv'] == 'Y') {
            if (isset($Subdivision_id)) {
                $result['taluka'] = $this->fetchTable('Taluka')
                                ->find('list', [
                                    'keyField' => 'taluka_id',
                                    'valueField' => 'taluka_name_' . $lang])
                                ->where(['subdivision_id =' => $Subdivision_id])->toArray();
            }
        }
//  Get Taluka  from district
        if ($config['AdmBlocks']['is_taluka'] == 'Y' && $config['AdmBlocks']['is_subdiv'] == 'N') {
            //Taluka from District
            if (isset($District_id)) {
                $result['taluka'] = $this->fetchTable('Taluka')
                                ->find('list', [
                                    'keyField' => 'taluka_id',
                                    'valueField' => 'taluka_name_' . $lang])
                                ->where(['district_id =' => $District_id])->toArray();
            }
        }
        //Circle from taluka
        if ($config['AdmBlocks']['is_circle'] == 'Y') {



            if (isset($Taluka_id)) {
                $result['circle'] = $this->fetchTable('Circle')
                                ->find('list', [
                                    'keyField' => 'circle_id',
                                    'valueField' => 'circle_name_' . $lang])
                                ->where(['taluka_id =' => $Taluka_id])->toArray();
            }
        }
        //village from circle
        if ($config['AdmBlocks']['is_circle'] == 'Y') {
            if (isset($Circle_id)) {
                $result['village'] = $this->fetchTable('Village')
                                ->find('list', [
                                    'keyField' => 'village_id',
                                    'valueField' => 'village_name_' . $lang])
                                ->where(['circle_id =' => $Circle_id])->toArray();
            }
        }
        //Village from Taluka
        if ($config['AdmBlocks']['is_village'] == 'Y' && $config['AdmBlocks']['is_circle'] == 'N') {
            if (isset($Taluka_id)) {
                $result['village'] = $this->fetchTable('Village')
                                ->find('list', [
                                    'keyField' => 'village_id',
                                    'valueField' => 'village_name_' . $lang])
                                ->where(['taluka_id =' => $Taluka_id])->toArray();
            }
        }




        if (isset($Village_id)) {
            $result['dtypes'] = $this->fetchTable('DevelopLandType')
                            ->find('list', [
                                'keyField' => 'developed_land_types_id',
                                'valueField' => 'developed_land_types_desc_' . $lang])
                            ->join([
                                'village' => [
                                    'table' => 'ngdrstab_conf_admblock7_village_mapping',
                                    'type' => 'INNER',
                                    'conditions' => 'village.developed_land_types_id = DevelopLandType.developed_land_types_id',
                                ]
                            ])
                            ->where(['village.village_id =' => $Village_id])->toArray();

            $result['corp'] = $this->fetchTable('LocalGovBodyList')
                            ->find('list', [
                                'keyField' => 'corp_id',
                                'valueField' => 'governingbody_name_' . $lang])
                            ->join([
                                'village' => [
                                    'table' => 'ngdrstab_conf_admblock7_village_mapping',
                                    'type' => 'INNER',
                                    'conditions' => 'village.corp_id = LocalGovBodyList.corp_id',
                                ]
                            ])
                            ->where(['village.village_id =' => $Village_id])->toArray();
        }


        if (isset($level_id)) {
            $result['level1'] = $this->fetchTable('Level1')
                            ->find('list', [
                                'keyField' => 'level_1_id',
                                'valueField' => 'level_1_desc_' . $lang])
                            ->where(['village_id =' => $Village_id])->toArray();
        }



        //  pr($result);exit;
        return $result;
    }

}

?>