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
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
//use Cake\ORM\Locator\LocatorAwareTrait;
/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class MasterController extends AppController
{
    public function districtentry(){

        //$districtsTable = TableRegistry::getTableLocator()->get('Districts');
        //$user = $usersTable->newEntity();
       
        $state_id = $this->request->getAttribute('identity')->state_id;
        //pr($state_id);
        $districts_disp = $this->getTableLocator()->get('District');
        $district = $districts_disp->newEmptyEntity();
        $result = $districts_disp->find('all')->toArray();
        $this->set("result", $result);
        $this->set("state_id", $state_id);
        if ($this->request->is('post')) {
            $data=$this->request->getData();
            //pr($data);
            $data = ['district_id' => $this->request->getData('updatedistid')];
            $data1 = ['id' => $this->request->getData('updateid')];
            
            $district = $districts_disp->patchEntity($district, $this->request->getData());
            $district = $districts_disp->patchEntity($district, $data);
            $district = $districts_disp->patchEntity($district, $data1);
           // $district = $this->Districts->patchEntity($district, $this->request->getData());
            
            //pr($district); exit;

            if ($districts_disp->save($district)) {
                    if(($this->request->getData('hfaction')=='U'))
                    {
                        $this->Flash->success(__('District has been updated successfully.'));
                    }
                    else{
                        $this->Flash->success(__('District has been added successful.'));
                    }
                        
                    return $this->redirect(['controller' => 'Master', 'action' => 'districtentry']);
              }
        }
    }
    
    public function districtdisplay() {
        $districts = $this->getTableLocator()->get('District');
        $result = $districts
                        ->find('all')->toArray();
        $this->set("result", $result);
    }
    
    public function districtedit($distid= NULL){
        //$this->loadModel('Districts');
        //$this->loadModel('States');
        //pr($distid);

        //$this->Security->csrfCheck = false;
        $distid=$_POST['distid'];
        $district = $this->getTableLocator()->get('District');
        $distarr=$district->find()->where(['district_id' => $distid])->toArray();
        //$this->set("distarr", $distarr);
        pr($distarr);exit;




        //$distarr=$this->Districts->query("select dist.district_name_en, state.state_name_en from ngdrstab_conf_admblock3_district dist 
        //join ngdrstab_conf_admblock1_state state ON dist.state_id=state.state_id  ")->where(['Districts.district_id' => $distid])->toArray();
        //$distarr = $this->Districts->find('all')->toArray('condition'=> array ('district_id' => $distid));

        /*$district = $this->getTableLocator()->get('Districts');
        $result = $district
        ->find()
        ->select(['Districts.district_name_en', 'States.state_name_en', 'Talukas.taluka_name_en'])
        ->join([
            'States'=>  [
                
                'table'      => 'ngdrstab_conf_admblock1_state',                
                'type'       => 'INNER',
                'conditions' => 'States.state_id = Districts.state_id',
            ],

            'Talukas'=>  [
                
                'table'      => 'ngdrstab_conf_admblock5_taluka',                
                'type'       => 'INNER',
                'conditions' => 'Talukas.district_id = Districts.district_id',
            ]
        ])
        ->where(['Districts.district_id' => $distid])->toArray();
        pr($result);exit;
        */

    }
    
    public function districtdelete($dist_id = null){
        if (isset($dist_id) && is_numeric($dist_id)) {
            $district = $this->getTableLocator()->get('District');
            $entity = $district->get($dist_id);
            $result = $district->delete($entity);
            $this->Flash->success(
                __('District Deleted Successfully.')
            );
            return $this->redirect(['controller' => 'Master', 'action' => 'districtentry']);
        }
    }
    
    public function talukaentry(){
        
        $state_id = $this->request->getAttribute('identity')->state_id;
        $this->set("state_id", $state_id);
        $admconfig = $this->getTableLocator()->get('AdminLevelConfig');
        $admconfigarr=$admconfig->find()->where(['config_id' => '1'])->toArray();
        //pr($admconfigarr);exit;
        $this->set('admconfigarr', $admconfigarr);

        $distdata = $this->getTableLocator()->get('District');
        $districtlist = $distdata->find('list', [
            'keyField' => 'district_id',
            'valueField' => 'district_name_en'
        ]);
        $districtlistdata = $districtlist->toArray();
        $this->set('districtlistdata', $districtlistdata);

        $subdivdata = $this->getTableLocator()->get('Subdivision');
        $subdivisionlist = $subdivdata->find('list', [
            'keyField' => 'subdivision_id',
            'valueField' => 'subdivision_name_en'
        ]);
        $subdivisionlistdata = $subdivisionlist->toArray();
        $this->set('subdivisionlistdata', $subdivisionlistdata);

        $taluka_disp = $this->getTableLocator()->get('Taluka');
        
        //$taluka = $taluka_disp->newEmptyEntity();

        $talukalistdata = $taluka_disp
        ->find()
        ->select(['Taluka.state_id','District.district_name_en', 'Taluka.district_id', 'Taluka.taluka_id', 'Taluka.taluka_name_en', 'Taluka.subdivision_id','Taluka.taluka_code','Taluka.census_code_2001','Taluka.census_code_2011','Taluka.census_code_2021'])
        ->join([
            'District'=>  [
                'table'      => 'ngdrstab_conf_admblock3_district',                
                'type'       => 'INNER',
                'conditions' => 'District.district_id = Taluka.district_id',
            ]
        ])
        ->order(['District.district_name_en' => 'ASC'])->toArray();
        //pr($talukalistdata);

        $this->set("talukalistdata", $talukalistdata);

        if ($this->request->is('post')) {
            $data=$this->request->getData();
            
            $taluka = $taluka_disp->newEmptyEntity();
            //update code start
            $data = ['taluka_id' => $this->request->getData('updatetaukaid')]; 
            $data1 = ['id' => $this->request->getData('updateid')]; 
            //pr($this->request->getData());       exit;  
            $taluka = $taluka_disp->patchEntity($taluka, $data);
            $taluka = $taluka_disp->patchEntity($taluka, $data1);
            //update code end

            $taluka = $taluka_disp->patchEntity($taluka, $this->request->getData());
            //$taluka->district_id = 2;
           // $taluka->taluka_name_en = 'test taluka';
            //pr($taluka); exit;
           
            if ($taluka_disp->save($taluka)) {
                if(($this->request->getData('hfaction')=='U'))
                {
                    $this->Flash->success(__('Taluka has been updated successfully.'));
                }
                else{
                    $this->Flash->success(__('Taluka has been added successful.'));
                }
                    
                return $this->redirect(['controller' => 'Master', 'action' => 'talukaentry']);
            }

        }

    }
    
    public function formcontrols() {

        $NGDRSErrorCode = $this->getTableLocator()->get('NGDRSErrorCode');
        
        $errorlist = $NGDRSErrorCode->find('list', [
            'keyField' => 'error_code_id',
            'valueField' => 'error_code'
        ]);
        $errorlistdata = $errorlist->toArray();
        $this->set('errorlistdata', $errorlistdata);
        $sizesradio = ['s' => 'Small', 'm' => 'Medium', 'l' => 'Large'];
        $this->set('sizesradio', $sizesradio);


        $fieldlist = array();
        $fieldlist['notes']['text'] = 'is_alpha';
        $fieldlist['Checkbox']['checkbox'] = 'is_alpha';
        $fieldlist['published']['text'] = 'is_alpha';
        $fieldlist['size']['select'] = 'is_alpha';
        $this->set('fieldlist', $fieldlist);
        $this->set('result_codes', $this->getvalidationruleset($fieldlist));

        if ($this->request->is('post')) {

            $errarr = $this->validatedata($this->request->getData(), $fieldlist);

            if ($this->ValidationError($errarr)) {

                if ($this->Users->save($user)) {

                    $this->Flash->success(__('Your formcontrols saved  successfully.'));
                }
            }


            $this->Flash->error(__('Your formcontrols failed.'));
        }
    }

    public function talukadelete($taluka_id = null){
        if (isset($taluka_id) && is_numeric($taluka_id)) {
            $taluka = $this->getTableLocator()->get('Taluka');
            $entity = $taluka->get($taluka_id);
            $result = $taluka->delete($entity);
            $this->Flash->success(
                __('Taluka Deleted Successfully.')
            );
            return $this->redirect(['controller' => 'Master', 'action' => 'talukaentry']);
        }
    }

    public function villageentry($village_id = null) {
//        $state_id= $this->Identity->get('state_id');
//        pr($this->Identity->get('state_id')); exit;
//        $identity=$this->Authentication->getIdentity()->getIdentifier();
        $identity = $this->request->getAttribute('identity')->user_id;
        //pr($identity);
        $distdata = $this->getTableLocator()->get('District');
        $talukadata = $this->getTableLocator()->get('Taluka');
        $villagedata = $this->getTableLocator()->get('Village');
        $developedlandtypedata = $this->getTableLocator()->get('DevelopedLandType');
        $admlevelconfig = $this->getTableLocator()->get('AdminLevelConfig');
        $divisiondata = $this->getTableLocator()->get('Division');
        $subdivisiondata = $this->getTableLocator()->get('Subdivision');
        $circledata = $this->getTableLocator()->get('Circle');

        $village = $villagedata->newEmptyEntity();
//        $talukalist = $talukadata->find('list', [
//            'keyField' => 'taluka_id',
//            'valueField' => 'taluka_name_en'
//        ]);
//        $talukalistdata = $talukalist->toArray(); 

        $areatypelist = $developedlandtypedata->find('list', [
            'keyField' => 'developed_land_types_id',
            'valueField' => 'developed_land_types_desc_en'
        ]);
        $areatypedata = $areatypelist->toArray();
        $this->set('areatypedata', $areatypedata);

        $admlevelconfigres = $admlevelconfig->find()->toArray();
        //$admlevelconfigres=$admlevelconfigres->toArray();
        //pr($admlevelconfigres); exit;
        if ($admlevelconfigres[0]['is_div'] == 'Y') {
            $divisionlist = $divisiondata->find('list', [
                'keyField' => 'division_id',
                'valueField' => 'division_name_en'
            ]);
            $divisionlistres = $divisionlist->toArray();
            $this->set('divisionlistres', $divisionlistres);

            $districtlistdata = array();
            $this->set('districtlistdata', $districtlistdata);
        } else {
            $districtlist = $distdata->find('list', [
                'keyField' => 'district_id',
                'valueField' => 'district_name_en'
            ]);
            $districtlistdata = $districtlist->toArray();
            $this->set('districtlistdata', $districtlistdata);
        }

        if ($admlevelconfigres[0]['is_subdiv'] == 'Y') {
            $subdivisionlist = $subdivisiondata->find('list', [
                'keyField' => 'subdivision_id',
                'valueField' => 'subdivision_name_en'
            ]);
            $subdivisionlistres = $subdivisionlist->toArray();
            $this->set('subdivisionlistres', $subdivisionlistres);
        }
        
        if ($admlevelconfigres[0]['is_circle'] == 'Y') {
            $circlelist = $circledata->find('list', [
                'keyField' => 'circle_id',
                'valueField' => 'circle_name_en'
            ]);
            $circlelistres = $circlelist->toArray();
            $this->set('circlelistres', $circlelistres);
        }

        $talukalistdata = $corpdata = $subdivisiondata = array();
        $villageresult = $villagedata
                        ->find()
                        ->select(['Village.state_id', 'Village.village_id', 'Village.village_name_en', 'District.district_name_en', 'District.district_id', 'Taluka.taluka_id', 'Taluka.taluka_name_en'])
                        ->join([
                            'District' => [
                                'table' => 'ngdrstab_conf_admblock3_district',
                                'type' => 'INNER',
                                'conditions' => 'District.district_id = Village.district_id',
                            ],
                            'Taluka' => [
                                'table' => 'ngdrstab_conf_admblock5_taluka',
                                'type' => 'INNER',
                                'conditions' => 'Taluka.taluka_id = Village.taluka_id',
                            ],
                        ])->toArray();

        // pr($villageresult); exit;

        $this->set("villageresult", $villageresult);

        if ($this->request->is('post')) {
            $village = $villagedata->patchEntity($village, $this->request->getData());
            //pr($this->request->getData()); exit;
            if ($villagedata->save($village)) {
                if (($this->request->getData('hfaction') == 'U')) {
                    $this->Flash->success(__('Village has been updated successfully.'));
                } else {
                    $this->Flash->success(__('Village has been added successfully.'));
                }

                return $this->redirect(['controller' => 'Master', 'action' => 'villageentry']);
            }
        }

        $village = null;

        if (!is_null($village_id) && is_numeric($village_id)) {

            /* $session = $this->request->getSession();
              $village_id_session = $session->write('$village_id');
              $villageid_read=$session->read($village_id);
              pr($villageid_read); exit; */
            $village = $villagedata->get($village_id);
            $village_arr = $village->toArray();
           // pr($village_arr); exit;

            if (!empty($village_arr['division_id'])) {
                $selected_division_id = $village_arr['division_id'];
                $districtlist = $distdata->find('list', [
                            'keyField' => 'district_id',
                            'valueField' => 'district_name_en'
                        ])->where(['division_id =' => $selected_division_id]);
                
                $districtlistdata = $districtlist->toArray();
                //pr($selected_division_id); exit;
                $this->set('districtlistdata', $districtlistdata);
            }

            if (!empty($village_arr['district_id'])) {
                $selected_district_id = $village_arr['district_id'];
                $talukalist = $talukadata
                        ->find('list', [
                            'keyField' => 'taluka_id',
                            'valueField' => 'taluka_name_en'])
                        ->where(['district_id =' => $selected_district_id]);
                $talukalistdata = $talukalist->toArray();
                $this->set('talukalistdata', $talukalistdata);
            }
            
            if (!empty($village_arr['subdivision_id'])) {
                $selected_subdivision_id = $village_arr['subdivision_id'];
                $subdivisionlist = $subdivisiondata->find('list', [
                'keyField' => 'subdivision_id',
                'valueField' => 'subdivision_name_en'
                    ])
                    ->where(['subdivision_id =' => $selected_subdivision_id]);
                    $subdivisionlistres = $subdivisionlist->toArray();                
                $this->set('subdivisionlistres', $subdivisionlistres);
            }
                       
            $selected_circle_id = $village_arr['circle_id'];
            $selected_district_id = $village_arr['district_id'];
            $selected_taluka_id = $village_arr['taluka_id'];
             
            $governingbodydata = $this->getTableLocator()->get('GoverningBodyList');
            $selected_governing_body_list = $village_arr['corp_id'];
             $corplistdata = $governingbodydata
                        ->find('list', [
                            'keyField' => 'corp_id',
                            'valueField' => 'governingbody_name_en'])
                        ->where(['district_id =' => $selected_district_id, 'taluka_id =' => $selected_taluka_id]);
            
                    $corpdata = $corplistdata->toArray();                
                $this->set('corpdata', $corpdata);
            

            //pr($talukalistdata); exit;
            if ($this->request->is(['patch', 'put', 'post'])) {
                $village = $villagedata->patchEntity($village, $this->request->getData());
                //pr($village); exit;
                if ($villagedata->save($village)) {
                    $this->Flash->success(__('Village has been updated successfully.'));
                    return $this->redirect(['controller' => 'Master', 'action' => 'villageentry']);
                }
            }
        }

        $this->set(compact('talukalistdata', 'village', 'corpdata', 'admlevelconfigres'));
//        $this->set("talukalistdata", $talukalistdata);
//        $this->set('village', $village);  
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

    public function getsubdivisiondist(){
        $data = $this->request->getData();
        $this->autoRender = FALSE;
        $districtid = $data['district_id'];
        $subdiv = $this->getTableLocator()->get('Subdivision');

        $subdivlist = $subdiv
                ->find('list', [
                    'keyField' => 'subdivision_id',
                    'valueField' => 'subdivision_name_en'])
                ->where(['district_id =' => $districtid]);

        $subdivlistdata = $subdivlist->toArray();
        echo json_encode($subdivlistdata);
        exit;
    }
    
    public function getgovtbody() {
        try {
            $this->autoRender = FALSE;
            $data = $this->request->getData();
            $districtid = $data['district_id'];
            $talukaid = $data['taluka_id'];
            $governingbodydata = $this->getTableLocator()->get('GoverningBodyList');

            if (isset($data['district_id']) && is_numeric($data['district_id'])) {
                $governingbodylist = $governingbodydata
                        ->find('list', [
                            'keyField' => 'corp_id',
                            'valueField' => 'governingbody_name_en'])
                        ->where(['district_id =' => $districtid, 'taluka_id =' => $talukaid]);

                $governingbodydata = $governingbodylist->toArray();
                echo json_encode($governingbodydata);
                exit;
            }
        } catch (Exception $e) {
            $this->redirect(array('controller' => 'Error', 'action' => 'exception_occurred'));
        }
    } 

    public function villagedelete($village_id = null) {
        if (isset($village_id) && is_numeric($village_id)) {
            $Village = $this->getTableLocator()->get('Village');
            $entity = $Village->get($village_id);
            $result = $Village->delete($entity);
            $this->Flash->success(
                    __('Village Deleted Successfully.')
            );
            return $this->redirect(['controller' => 'Master', 'action' => 'villageentry']);
        }
    }

    public function getdistrictlist() {
        try {
            $data = $this->request->getData();
            $divisionid = $data['division_id'];
            $distdata = $this->getTableLocator()->get('District');
            //pr($data); exit;
            $districtlist = $distdata
                    ->find('list', [
                        'keyField' => 'district_id',
                        'valueField' => 'district_name_en'])
                    ->where(['division_id =' => $divisionid]);

            $districtlistdata = $districtlist->toArray();
            echo json_encode($districtlistdata);
            exit;
        } catch (exception $ex) {
            pr($ex);
            exit;
        }
    }

    public function getsubdivlist() {
        try {
            $data = $this->request->getData();
            // pr($data); 
            $district_id = $data['district_id'];
            $subdivisiondata = $this->getTableLocator()->get('Subdivision');
            //pr($data); exit;
            $subdivdata = $subdivisiondata
                    ->find('list', [
                        'keyField' => 'subdivision_id',
                        'valueField' => 'subdivision_name_en'])
                    ->where(['district_id =' => $district_id]);

            $subdivlistdata = $subdivdata->toArray();
            echo json_encode($subdivlistdata);
            exit;
        } catch (exception $ex) {
            pr($ex);
            exit;
        }
    } 
    
    public function getcircle() {
        try {
            $data = $this->request->getData();
            // pr($data); 
            $taluka_id = $data['taluka_id'];
            $circledata = $this->getTableLocator()->get('Circle');
            //pr($data); exit;
            $circlelist = $circledata
                    ->find('list', [
                        'keyField' => 'circle_id',
                        'valueField' => 'circle_name_en'])
                    ->where(['taluka_id =' => $taluka_id]);

            $circlelistres = $circlelist->toArray();
            echo json_encode($circlelistres);
            exit;
        } catch (exception $ex) {
            pr($ex);
            exit;
        }
    }
    
    public function getvillage() {
        try {
            $this->autoRender = FALSE;
            $data = $this->request->getData();
            $districtid = $data['district_id'];
            $talukaid = $data['taluka_id'];
            $villagedata = $this->getTableLocator()->get('Village');

            if (isset($data['district_id']) && is_numeric($data['district_id'])) {
                $villagelist = $villagedata
                        ->find('list', [
                            'keyField' => 'village_id',
                            'valueField' => 'village_name_en'])
                        ->where(['district_id =' => $districtid, 'taluka_id =' => $talukaid]);

                $villagelistdata = $villagelist->toArray();
                echo json_encode($villagelistdata);
                exit;
            }
        } catch (Exception $e) {
            $this->redirect(array('controller' => 'Error', 'action' => 'exception_occurred'));
        }
    }

}