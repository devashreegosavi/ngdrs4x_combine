<?php

declare(strict_types=1);
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\Http\Response;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\Datasource\ConnectionManager;
use Cake\I18n\FrozenTime;

class CitizenRegistrationController extends AppController {

    public function beforeFilter(\Cake\Event\EventInterface $event) {
        $this->Authentication->allowUnauthenticated(['check_advocater_reg_count','check_citizen_reg_count','check_deedwriter_reg_count','checkmobilenocitizen', 'checkemailcitizen', 'checkusercitizen', 'register']);
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['login']);
    }
	
	public function istrim($data) {
        foreach ($data as $formkey => $formval) {
            $trimmed = trim($formval);
            $data[$formkey] = $trimmed;
        }
        return $data;
    }
	
    public function register() {

        $registrationType = $this->getTableLocator()->get('Registration_type');
        $registrationTypeList = $registrationType->find('list', ['keyField' => 'type_id','valueField' => 'type_name_en']);
        $registrationTypeListData = $registrationTypeList->toArray();
        $this->set('registrationTypeListData', $registrationTypeListData);

        $hintQuestion = $this->getTableLocator()->get('Hint_Question');
        $hintQuestionList = $hintQuestion->find('list', ['keyField' => 'id','valueField' => 'questions_en']);
        $hintQuestionListData = $hintQuestionList->toArray();
        $this->set('hintQuestionListData', $hintQuestionListData);
		
		$fieldlist['citizenRegistration']['reg_type']['select'] = 'is_required';
		$fieldlist['citizenRegistration']['contact_fname']['text'] = 'is_required';
		$fieldlist['citizenRegistration']['contact_mname']['text'] = 'is_required';
		$fieldlist['citizenRegistration']['contact_lname']['text'] = 'is_required';
		$fieldlist['citizenRegistration']['email_id']['text'] = 'is_required';
		$fieldlist['citizenRegistration']['mobile_no']['text'] = 'is_required';
		$fieldlist['citizenRegistration']['user_name']['text'] = 'is_required';
		$fieldlist['citizenRegistration']['user_pass']['text'] = 'is_required';
		$fieldlist['citizenRegistration']['re_user_pass']['text'] = 'is_required';
		$fieldlist['citizenRegistration']['hint_question']['select'] = 'is_required';
		$fieldlist['citizenRegistration']['hint_answer']['text'] = 'is_required';

        $this->set('fieldlistmultiform', $fieldlist);
        $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));
		
        $time = FrozenTime::now();
        $date = $time->i18nFormat('yyyy-MM-dd HH:mm:ss');

        if ($this->request->is('post')) {
						
		$errarr = $this->validatedata($this->request->getData(), $fieldlist['citizenRegistration']);
		//pr($errarr);exit;
			if ($this->ValidationError($errarr)) {
				
            $state_data = $this->getTableLocator()->get('Current_State');
            $state_id_list = $state_data->find('all', ['keyField' => 'state_id','valueField' => 'state_name']);
            $state_id_ListData = $state_id_list->toArray();
            $this->set('state_id_ListData', $state_id_ListData);

            $citizen_Registration = $this->getTableLocator()->get('Citizen_Registration');
            $user_citizen = $citizen_Registration->newEmptyEntity();
			
			$data = $this->request->getData();
			$data['user_name'] = base64_decode($data['user_name']);
			
			if(strlen($data['user_pass']) != 128 AND strlen($data['re_user_pass']) != 128 ){
				$data['user_pass'] = hash("sha512", $data['user_pass']);
				$data['re_user_pass'] = hash("sha512", $data['re_user_pass']);
			}
			
			
		if($data['user_pass'] == $data['re_user_pass']){
			
			if ($data['reg_type'] == 1) {
				$RegCount = $citizen_Registration->find()->where(['DATE(created)' => date('Y-m-d'),'deed_writer' => 'N', 'is_advocate' => 'N'])->all();
						$validcount = $this->check_citizen_reg_count();
			}
			if ($data['reg_type'] == 2) {
				$RegCount = $citizen_Registration->find()->where(['DATE(created)' => date('Y-m-d'),'deed_writer' => 'Y'])->all();
						$validcount = $this->check_deedwriter_reg_count();
			}
			if ($data['reg_type'] == 3) {
				$RegCount = $citizen_Registration->find()->where(['DATE(created)' => date('Y-m-d'),'is_advocate' => 'Y'])->all();
						$validcount = $this->check_advocater_reg_count();
			}
			if (!empty($RegCount) && !empty($validcount)) {
                    if ($validcount <= count($RegCount)) {
                        return $this->redirect('/');
                    }
                }
			
            $data['state_id'] = $state_id_ListData[0]->state_id;
            $data['req_ip'] = $this->get_client_ip();
            $data['user_created_flag'] = 'Y';
            $data['user_creation_date'] = $date;
            $data['approval_remark'] = '';
            $data['rejection_flag'] = 'N';
            $data['rejection_date'] = $date;
            $data['created'] = $date;
            $data['updated'] = '';
            $data['user_type'] = 'C';
            if ($data['reg_type'] == 1) {
                $data['deed_writer'] = 'N';
                $data['is_advocate'] = 'N';
            }
            if ($data['reg_type'] == 2) {
                $data['deed_writer'] = 'Y';
                $data['is_advocate'] = 'N';
            }
            if ($data['reg_type'] == 3) {
                $data['deed_writer'] = 'N';
                $data['is_advocate'] = 'Y';
            }

            $user_citizen_data = $citizen_Registration->patchEntity($user_citizen, $data);
			
			//pr($user_citizen_data);exit;
			
            if ($citizen_Registration->save($this->istrim($user_citizen_data))) {

                $user_Citizentbl = $this->getTableLocator()->get('User_citizen');
                $user_citizen_login = $user_Citizentbl->newEmptyEntity();
                $data_login = $this->request->getData();
                $data_login['username'] = $user_citizen_data->user_name;
                $data_login['password'] = $user_citizen_data->user_pass;
                $data_login['role_id'] = 1;
                $data_login['module_id'] = 3;
                $data_login['full_name'] = $user_citizen_data->contact_fname . ' ' . $user_citizen_data->contact_mname . ' ' . $user_citizen_data->contact_lname;
                $data_login['mobile_no'] = $user_citizen_data->mobile_no;
                $data_login['email_id'] = $user_citizen_data->email_id;
                $data_login['created'] = $date;
                $data_login['activeflag'] = 'Y';
                $data_login['state_id'] = $state_id_ListData[0]->state_id;
                $data_login['user_active_date'] = $date;
                $data_login['req_ip'] = $this->get_client_ip();
                $data_login['authetication_type'] = 1;
                $data_login['lang_both '] = true;
                if ($user_citizen_data['reg_type'] == 1) {
                    $data_login['deed_writer'] = 'N';
                    $data_login['deed_write_accept_flag'] = 'N';
                    $data_login['deed_write_accept_date'] = '';
                    $data_login['is_advocate'] = 'N';
                    $data_login['is_advocate_accept_flag'] = 'N';
                    $data_login['is_advocate_accept_date'] = '';
                }
                if ($user_citizen_data['reg_type'] == 2) {
                    $data_login['deed_writer'] = 'Y';
                    $data_login['deed_write_accept_flag'] = 'Y';
                    $data_login['deed_write_accept_date'] = $date;
                }
                if ($user_citizen_data['reg_type'] == 3) {
                    $data_login['is_advocate'] = 'Y';
                    $data_login['is_advocate_accept_flag'] = 'Y';
                    $data_login['is_advocate_accept_date'] = $date;
                }
                
                $user_citizen_login_data = $user_Citizentbl->patchEntity($user_citizen_login, $data_login);
				
				
                $user_Citizentbl->save($this->istrim($user_citizen_login_data));

                $query = $user_Citizentbl->find();
                $maxUserId = $query->select(['user_id'])->order(['user_id' => 'DESC'])->first(function ($max) {
                    return $max->user_id;
                });

                $user_Citizen_role_tbl = $this->getTableLocator()->get('User_citizen_role');
                $user_citizen_role_entity = $user_Citizen_role_tbl->newEmptyEntity();
                $data_citizen_role = $this->request->getData();
                $data_citizen_role['user_id'] = $maxUserId->user_id;
                $data_citizen_role['username'] = $user_citizen_data->user_name;
                $data_citizen_role['module_id'] = 3;
                $data_citizen_role['role_id'] = 1;
                $data_citizen_role['created'] = $date;
                $data_citizen_role['req_ip'] = $this->get_client_ip();
                $data_citizen_role['state_id'] = $state_id_ListData[0]->state_id;

                $user_citizen_role_data = $user_Citizen_role_tbl->patchEntity($user_citizen_role_entity, $data_citizen_role);
                $user_Citizen_role_tbl->save($this->istrim($user_citizen_role_data));

                $this->Flash->success(__('Your registration was successful.'));
                return $this->redirect('/');
            }
            $this->Flash->error(__('Your registration failed.'));
			
			}else{
				$this->Flash->error(__('Password did not match.'));
			}
			
			
		}
			
        }
    }
	
	function check_citizen_reg_count() {
        try {
			$reg_bool_info_count_citizen = $this->getTableLocator()->get('Reg_conf_bool_info');
			$RegCountCitizen = $reg_bool_info_count_citizen->find()->where(['reginfo_id' => 55])->all();
			
			$RegCountCitizenData = $RegCountCitizen->toArray();
            $this->set('RegCountCitizenData', $RegCountCitizenData);
            if (!empty($RegCountCitizenData)) {
                return $RegCountCitizenData[0]->info_value;
            }
            exit;
        } catch (Exception $ex) {
            $this->Session->setFlash( __('Record Cannot be displayed. Error :' . $ex->getMessage()) );
            return $this->redirect(array('controller' => 'Error', 'action' => 'exception_occurred'));
        }
    }
	
	function check_deedwriter_reg_count() {
        try {
           
            $reg_bool_info_count_citizen = $this->getTableLocator()->get('Reg_conf_bool_info');
			$RegCountCitizen = $reg_bool_info_count_citizen->find()->where(['reginfo_id' => 57])->all();
			
			$RegCountCitizenData = $RegCountCitizen->toArray();
            $this->set('RegCountCitizenData', $RegCountCitizenData);
            if (!empty($RegCountCitizenData)) {
                return $RegCountCitizenData[0]->info_value;
            }
            exit;
        } catch (Exception $ex) { $this->Session->setFlash( __('Record Cannot be displayed. Error :' . $ex->getMessage()) );
            return $this->redirect(array('controller' => 'Error', 'action' => 'exception_occurred'));
        }
    }
	
	function check_advocater_reg_count() {
        try {
            $reg_bool_info_count_citizen = $this->getTableLocator()->get('Reg_conf_bool_info');
			$RegCountCitizen = $reg_bool_info_count_citizen->find()->where(['reginfo_id' => 61])->all();
			
			$RegCountCitizenData = $RegCountCitizen->toArray();
            $this->set('RegCountCitizenData', $RegCountCitizenData);
            if (!empty($RegCountCitizenData)) {
                return $RegCountCitizenData[0]->info_value;
            }
            exit;
        } catch (Exception $ex) { $this->Session->setFlash( __('Record Cannot be displayed. Error :' . $ex->getMessage()) );
            return $this->redirect(array('controller' => 'Error', 'action' => 'exception_occurred'));
        }
    }
	
    function checkusercitizen() {
        try {
            $this->autoRender = FALSE;
			$getUserName = $_POST['username'];
            if (isset($getUserName) && !empty($getUserName)) {
				$citizen_Registration = $this->getTableLocator()->get('Citizen_Registration');
				$citizen_Registration->findbyecitizenuser($getUserName);
				exit;
            } else {
                $this->Flash->error(__('Something went wrong!!!'));
            }
        } catch (Exception $e) {
            pr($e);
            exit;
        }
    }

    function checkemailcitizen() {
        try {
            $this->autoRender = FALSE;
            $getEmail = $_POST['email'];
            if (isset($getEmail) && !empty($getEmail)) {
                $citizen_Registration = $this->getTableLocator()->get('Citizen_Registration');
				$citizen_Registration->findbyecitizenemail($getEmail);
                exit;
            } else {
                $this->Flash->error(__('Something went wrong!!!'));
            }
        } catch (Exception $e) {
            pr($e);
            exit;
        }
    }

    function checkmobilenocitizen() {
        try {
            $this->autoRender = FALSE;
            $getMobileno = $_POST['mobile'];
            if (isset($getMobileno) && !empty($getMobileno)) {
                $citizen_Registration = $this->getTableLocator()->get('Citizen_Registration');
                $citizen_Registration->findbyecitizenmobileno($getMobileno);
				exit;
            } else {
                $this->Flash->error(__('Something went wrong!!!'));
            }
        } catch (Exception $e) {
            pr($e);
            exit;
        }
    }

}
