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

class PaymentController extends AppController {
    var $base_path = WWW_ROOT;

    public function payment(){
        $Selectedtoken = $this->request->getSession()->read('Selectedtoken');
        $Selectedtoken='202300000004';
        $reschedule_flag = $this->request->getSession()->read('reschedule_flag');
        $userrole_id = $this->request->getSession()->read('user_role_id');
        $this->restrict_edit_after_submit($Selectedtoken);

        if($reschedule_flag=='Y'){
            return $this->redirect(['controller' => 'Appointment', 'action' => 'appointment']);
        }

        $NGDRSErrorCode = $this->getTableLocator()->get('NGDRSErrorCode');
        $last_status_id = $this->request->getSession()->read('last_status_id');
        $lang = $this->request->getSession()->read('Config.language');
        
        $session_usertype = $this->request->getSession()->read('session_usertype');
        $state_id = $this->request->getAttribute('identity')->state_id;
        $user_id = $this->request->getAttribute('identity')->user_id;
        $citizen_user_id = $this->request->getAttribute('identity')->citizen_user_id;


        if ($this->request->getSession()->read("manual_flag") == 'Y') {
            $payment_mode = $this->fetchTable('PaymentMode')
                                ->find('list', [
                                    'keyField' => 'payment_mode_id',
                                    'valueField' => 'payment_mode_desc_en'
                                ])->where(['verification_flag =' => 'N','active_flag' => 'Y'])
                                ->order(['payment_mode_id' => 'ASC'])->toArray();
        }else{
            $payment_mode = $this->fetchTable('PaymentMode')
                                ->find('list', [
                                    'keyField' => 'payment_mode_id',
                                    'valueField' => 'payment_mode_desc_en'
                                ])->where(['verification_flag =' => 'Y','active_flag' => 'Y'])
                                ->order(['payment_mode_id' => 'ASC'])->toArray();
        }
        $this->set('payment_mode', $payment_mode);
    }

    public function getpaymentdetails(){
        $data = $this->request->getData();
        //pr($data);exit;
        $lang = $this->request->getSession()->read('Config.language');
        $Selectedtoken = $this->request->getSession()->read('Selectedtoken');
        $Selectedtoken='202300000004';
        $generalinfodet = $this->getTableLocator()->get('Generalinformation');
        //pr($data);

        $paymentfields = array();
        $payment = array();
        if (isset($data['mode']) && is_numeric($data['mode'])) {
            
            $paymentfields=$this->fetchTable('PaymentFields')
                        ->find()
                        ->where(['payment_mode_id' => $data['mode'], 'is_input_flag' => 'Y'])
                        ->order(['srno' => 'ASC'])->toArray();
        }
        $data['id']=1;
        if (isset($data['id']) && is_numeric($data['id'])) {
            $payment = $this->fetchTable('TrnCitizenPaymentEntry')
            ->find()
            ->where(['payment_mode_id' => $data['mode'], 'payment_id' => $data['id'], 'token_no' =>$Selectedtoken ])
            ->toArray();;
        }
        //pr($payment);
        $this->set("paymentfields", $paymentfields);
        $this->set("payment", $payment);


        //pr($paymentfields);
        $bank_master = $branch_master = $office = $bank_trn_id = array();
        foreach ($paymentfields as $field) {
            //pr($field);
            if($field['field_name'] == 'bank_id'){
                $bank_master = $this->fetchTable('BankMaster')
                            ->find('list', [
                                'keyField' => 'bank_id',
                                'valueField' => 'bank_name_en'])
                            ->order(['bank_name_en' => 'ASC'])->toArray();
                if (isset($payment) and is_numeric($payment[0]['bank_id'])) {
                    $branch_master = $this->fetchTable('BankBranch')
                                    ->find('list', [
                                    'keyField' => 'branch_id',
                                    'valueField' => 'branch_name_en'])
                                    ->where(['bank_id' => $payment[0]['bank_id']])
                                    ->toArray();
                }
                
   
            }
            if($field['field_name'] == 'cos_id'){
                $office = $this->fetchTable('Office')
                                ->find('list', [
                                'keyField' => 'office_id',
                                'valueField' => 'office_name_en'])
                                ->where(['hierarchy_id' => '45'])
                                ->toArray();
            }
            if($field['field_name'] == 'bank_trn_id'){
                $bank_trn_id = $this->fetchTable('BankPayment')
                            ->find('list', [
                            'keyField' => 'transaction_id',
                            'valueField' => 'transaction_id'])
                            ->where(['payment_mode_id' => $data['mode'], 'token_no'=> $Selectedtoken, 'payment_status'=> 'SUCCESS'])
                            ->toArray();
            }
        }
        
        $this->set("bank_master", $bank_master);
        $this->set("branch_master", $branch_master);
        $this->set("office", $office);
        $this->set("bank_trn_id", $bank_trn_id);

        $accounthead = $this->fetchTable('ArticleFeeItems')
                        ->find('list', [
                        'keyField' => 'fee_item_id',
                        'valueField' => 'fee_item_desc_en'])
                        ->where(['fee_param_type_id' => '2'])
                        ->toArray();
        $this->set("accounthead", $accounthead);
        $this->set("lang", $lang);
        //exit;
    }
}

