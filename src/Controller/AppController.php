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

use Cake\Controller\Controller;
use Cake\I18n\I18n;
use Cake\Datasource\ConnectionManager;

 

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        // Add this line to check authentication result and lock your site
        $this->loadComponent('Authentication.Authentication');

        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');


        $lang = $this->request->getSession()->read('Config.language');
        if (!empty($lang)) {
            I18n::setLocale($lang);
        } else {
            I18n::setLocale('en');
            $this->request->getSession()->write('Config.language', 'en');
        }
        
         $result = $this->Authentication->getResult();
         if ($result && $result->isValid() && !$this->request->is('ajax')) {
            $this->viewBuilder()->setLayout('admin_layout');   
         }
    }

    public function beforeFilter(\Cake\Event\EventInterface $event) {
        parent::beforeFilter($event);
        $this->Authentication->allowUnauthenticated(['organizationLogin', 'citizenLogin','register', 'index', 'menu', 'checkmobilenocitizen', 'checkemailcitizen', 'checkusercitizen', 'organizationLogin',]);
        
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['organizationLogin']);
//        $session = $this->request->getSession();
//        $session->renew();

$connection = ConnectionManager::get('default');
        $user_type = $this->request->getSession()->read('Auth.user_type');
        $user_id = $this->request->getSession()->read('Auth.user_id');
		//pr($user_type);exit;

        $role_id_array1 = array();
        if (isset($user_type) && !empty($user_type) && $user_type == 'O') {
            $user_data_sro = $this->getTableLocator()->get('User_role');
            $user_data_list = $user_data_sro->find()
                ->select(['user_id', 'module_id', 'role_id'])
                ->where(['user_id' => $user_id])
                ->all();
				
				//pr($user_data_list);exit;
            $userDetails = $user_data_list->toArray();
			//pr($userDetails);exit;
            foreach ($userDetails as $role_id) {
                $role_idarray = $role_id;
                array_push($role_id_array1, $role_idarray);
            }
        } elseif (isset($user_type) && !empty($user_type) && $user_type == 'C') {
            $user_data_citizen = $this->getTableLocator()->get('User_citizen_role');
            $user_data_list = $user_data_citizen->find()
                ->select(['user_id', 'module_id', 'role_id'])
                ->where(['user_id' => $user_id])
                ->all();
            $userDetails = $user_data_list->toArray();
            foreach ($userDetails as $role_id) {
                $role_idarray = $role_id['role_id'];
                array_push($role_id_array1, $role_idarray);
            }
        }
        
        $menu_arr1 = array();
        foreach ($role_id_array1 as $role) {
            $role_id_data = $role->role_id;
            $result = $connection
                ->execute('select distinct (u.menu_id),u.role_id , m.name_en from ngdrstab_mst_menu m,ngdrstab_mst_userpermissions u 
            where m.id = CAST(u.menu_id AS integer) and u.role_id= :id order by m.name_en', ['id' => $role_id_data])
                ->fetchAll('assoc');

            foreach ($result as $menu1) {
                $menuid = $menu1['menu_id'];
                array_push($menu_arr1, $menu1);
            }
        }

        $menus = array();
        foreach ($menu_arr1 as $mmenu1) {
            $menuid = $mmenu1['menu_id'];
            $Menustbl = $this->getTableLocator()->get('Menus');
            $MenustblList = $Menustbl->find('all', ['contain' => ['submenus']])
                ->where(['id' => $menuid])
                ->order(['id' => 'ASC']);
            foreach ($MenustblList as $menus11) {
                array_push($menus, $menus11);
            }
        }

        $this->set('menus', $menus);
    }

 function get_client_ip()
    {
        $IP = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $IP = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $IP = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $IP = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $IP = getenv('HTTP_FORWARDED_FOR');
        } elseif (getenv('HTTP_FORWARDED')) {
            $IP = getenv('HTTP_FORWARDED');
        } else {
            $IP = $_SERVER['REMOTE_ADDR'];
        }
        return $IP;
    }
	
    public function beforeRender(\Cake\Event\EventInterface $event) {
        
       
       
        
    }

    //-----------------------------------Validation dynamic control for server side(KALYANI)----------------------------------------------
    public function validatedata($data, $fieldlist) {
        $this->loadModel("NGDRSErrorCode");

        // $laug = $this->Session->read("sess_langauge");
        $laug = 'en';
//          pr($laug);exit;
        $result_codes = $this->NGDRSErrorCode->find("all")->toArray();

//       echo  $result_codes[0]->error_code_id;
//       exit;
        //  pr($result_codes);exit;
        $errorarray = array();
        foreach ($fieldlist as $frmkey => $valrule) {
            $errorarray[$frmkey . '_error'] = "";
        }
        //in these function data firstly passed from check function of cakephp which does not allow to save  all statements like drop,delete,truncate,select,insert,update,table, from,where.
//        if (!Sanitize::check($data)) {
//            $errorarray['error'] = "proper data";
//            $this->Session->setFlash(__('Do not enter Invalid Data'));
//            return $errorarray;
//        }
        // read    fields   from  $fieldlist
        foreach ($fieldlist as $listkey => $listcontrol) {
            // read form  fields       
            $fieldexist = 0;
            foreach ($data as $frmkey => $frmval) {
//pr($frmkey);exit;
                if ($frmkey == $listkey) { // emp_name == emp_name
                    $fieldexist = 1;
                    // pr($listcontrol); exit;
                    foreach ($listcontrol as $controltype => $valrule) {//  $controltype-> text/select  $valrule -> is_alpha/is_numeric
                        // get error_code  from errorcode result                
                        $valrule_arr = explode(",", $valrule);
                        // pr($valrule_arr);exit;
                        $messflag = 0;
                        foreach ($valrule_arr as $singlerule) {
                            foreach ($result_codes as $errorkey => $error_record) { /// is_alpha  
                                //     pr($singlerule);
                                //   pr($error_record->error_code);
                                if ($error_record->error_code == $singlerule) {// ERROR CODE MATCHING
                                    //get pattern from errorkey
                                    $pattern = $error_record->pattern_rule;

                                    // pr($pattern);exit;
                                    if (!empty($pattern)) {

                                        //  pr($frmval);exit;
                                        if (is_array($frmval)) {

                                            foreach ($frmval as $singleval) {
                                                if (!preg_match($pattern, $singleval)) {//PATTERN MATCHING
                                                    $errorarray[$frmkey . "_error"] = $error_record->error_messages_en;
                                                    $messflag = 1;
                                                }
                                            }
                                        } else {

                                            if (!preg_match($pattern, $frmval)) {//PATTERN MATCHING
                                                $errorarray[$frmkey . "_error"] = $error_record->error_messages_en;
                                                $messflag = 1;
                                            }
                                        }
                                    }
                                }
                            }
                            if ($messflag == 1) {
                                break;
                            }
                        }
                    }
                }
            }

            if ($fieldexist == 0) {
                $errorarray[$listkey . "_error"] = 'Error in some form fields';
            }
        }
        //pr($errorarray);
        //  exit;

        return $errorarray;
    }

    //-----------------------------------Validation RULE SETTING for server AND client side(KALYANI)----------------------------------------------

    public function getvalidationruleset($fieldlist, $multiform = False) {
        $this->loadModel('NGDRSErrorCode');
        $errarr = array();
        $fielderrorarray = array();
        if ($multiform) {
            foreach ($fieldlist as $fieldlist1) {
                foreach ($fieldlist1 as $key => $valrule) {
                    $errarr[$key . '_error'] = "";
                }
            }
            foreach ($fieldlist as $fieldlist1) {
                foreach ($fieldlist1 as $fielderrarr) {
                    foreach ($fielderrarr as $field) {
                        $rulesset = explode(",", $field);
                        foreach ($rulesset as $rules) {

                            $fielderrorarray[$rules] = $rules;
                        }
                    }
                }
            }
            $this->set("errarr", $errarr);
        } else {
            foreach ($fieldlist as $key => $valrule) {
                $errarr[$key . '_error'] = "";
            }
            $this->set("errarr", $errarr);

            foreach ($fieldlist as $fielderrarr) {
                foreach ($fielderrarr as $field) {
                    $rulesset = explode(",", $field);
                    foreach ($rulesset as $rules) {

                        $fielderrorarray[$rules] = $rules;
                    }
                }
            }
        }

//pr($fielderrorarray);exit;
        $result_codes = $this->NGDRSErrorCode->find("all")->toArray();
        // pr($result_codes);exit;
        return $result_codes;
    }

//-----------------------------------Validation Errors(KALYANI)----------------------------------------------
    function ValidationError($errors) {
        $errorflag = 1;
        foreach ($errors as $message) {
            if (!empty($message)) {
                $errorflag = 0;
            }
        }
        if ($errorflag == 0) {
            $this->Flash->error(__('Error in Form Data. Please Check Form Data Submitted'));
            $this->set("errarr", $errors);
        }
        return $errorflag;
    }

    public function save_documentstatus($status_id, $token_no, $office_id) {
        $documentstatus = $this->getTableLocator()->get('DocumentStatus');
        $dstatus = $documentstatus->newEmptyEntity();
        $date = date('Y-m-d H:i:s');
        $stateid = $this->request->getAttribute('identity')->state_id;
        $usertype = $this->request->getSession()->read('Config.session_usertype');
        $user_id = $this->request->getAttribute('identity')->user_id;
        $usertype='C';
        if ($usertype == 'C') {
            $data = ['token_no' => $token_no,
                'status_id' => $status_id,
                'status_date' => $date,
                'state_id' => $stateid,
                'req_ip' => $_SERVER['REMOTE_ADDR'],
                'user_id' => $user_id,
                'user_type' => $usertype,
                'office_id' => $office_id,
                'created' => $date    
            ];
        } else {
            $data = ['token_no' => $token_no,
                'status_id' => $status_id,
                'status_date' => $date,
                'state_id' => $stateid,
                'req_ip' => $_SERVER['REMOTE_ADDR'],
                'org_user_id' => $user_id,
                'user_type' => $usertype,
                'office_id' => $office_id,
                'org_created' => $date
            ];
        }
        
        $dstatus = $documentstatus->patchEntity($dstatus, $data);
        $documentstatus->save($dstatus);
        return true;
    }
    
    public function restrict_edit_after_submit($token = NULL){
        $role_id = $this->request->getSession()->read('Auth.role_id');
        if (!empty($role_id)) {
            if ($role_id == 1) {
                $getresultdt = $this->fetchTable('Generalinformation')->find('all')
                                    ->where(['token_no =' => $token])
                                    ->toArray(); 
                if (!empty($getresultdt)) {
                    $last_status_id = $getresultdt[0]['last_status_id'];
                    if ($last_status_id != 1) {
                        $this->Flash->success(__('You cannot Edit Document After Submission, Please take Appointment...!!!'));
                        return $this->redirect(['controller' => 'Appointment', 'action' => 'appointment']);
                    }
                }
            }
        }
    }

    public function get_name_format(){
        $getnameformat = $this->fetchTable('ConfRegBoolInfo')->getconfvalueresult(2);
        $nameformat = $getnameformat['conf_bool_value'];
        return $nameformat;
    }
    function enc($str) {
        $key = "";
        $enc = openssl_encrypt($str, 'bf-ecb', $key);
        $final_str = (bin2hex($enc));
        return ($final_str);
    }

    function dec($str = NULL) {
        // pr($str);
        if (!empty($str) || $str != NULL || $str != '') {
            $key = "";
            $final_strv = (hex2bin(trim($str)));
            $dec = openssl_decrypt($final_strv, 'bf-ecb', $key);
            return $dec;
        } else {
            $str;
        }
    }
}
