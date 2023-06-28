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

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class UsersController extends AppController {

    /**
     * Displays a view
     *
     * @param string ...$path Path segments.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Http\Exception\ForbiddenException When a directory traversal attempt.
     * @throws \Cake\View\Exception\MissingTemplateException When the view file could not
     *   be found and in debug mode.
     * @throws \Cake\Http\Exception\NotFoundException When the view file could not
     *   be found and not in debug mode.
     * @throws \Cake\View\Exception\MissingTemplateException In debug mode.
     */
    public function register() {

        $fieldlist['login']['first_name']['text'] = 'is_required';
        $fieldlist['login']['last_name']['text'] = 'is_required';

        $fieldlist['login']['email']['text'] = 'is_required';
        $fieldlist['login']['password']['text'] = 'is_required';
        $fieldlist['login']['confirm_password']['text'] = 'is_required';

        $this->set('fieldlistmultiform', $fieldlist);
        $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));

        $user = $this->Users->newEmptyEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your registration was successful.'));
                return $this->redirect('/');
            }
            $this->Flash->error(__('Your registration failed.'));
        }
    }

    public function organizationLogin() {
       
        $this->request->allowMethod(['get', 'post']);

        $fieldlist['login']['username']['text'] = 'is_required';
        $fieldlist['login']['password']['text'] = 'is_required';

        $this->set('fieldlistmultiform', $fieldlist);
        $this->set('result_codes', $this->getvalidationruleset($fieldlist, TRUE));
        $result = $this->Authentication->getResult();
      
        if ($this->request->is('post')) {
//            pr($this->request->getData());exit;
            $errarr = $this->validatedata($this->request->getData(), $fieldlist['login']);
//pr($errarr);exit;
            if ($this->ValidationError($errarr)) {
                $result = $this->Authentication->getResult();
                if ($this->request->is('post') && !$result->isValid()) {
//                      pr($result);exit;
                    $this->Flash->error(__('Invalid username or password!!!'));
                    return $this->redirect('/Users/organization-login');
                }
                if ($result && $result->isValid()) {
                    $this->request->getSession()->write('Config.language', 'en');
                    $this->Flash->success(__('Login Successfull'));
                    return $this->redirect('/Admin/index');
                }
            }
        }
    }

    public function welcome() {
        
    }

    public function logout() {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success(__('Logout Successfully'));
            return $this->redirect('/Users/organization-login');
        }
    }

    public function display() {
        $users = $this->getTableLocator()->get('Users');
        $result = $users->find()
                ->select(['user_id', 'username'])
                ->execute()
                ->fetchAll('assoc');
//                ->toArray();
//        $array = (array) $result[0];
//        array_walk_recursive($result,function(&$item){if(is_object($item))$item=(array)$item;});
        pr($result);
        exit;
        $this->set("result", $result);
    }

    public function formcontrols() {
//        $users = $this->getTableLocator()->get('Users');
//        $result = $users->find()
//                ->select(['user_id','username'])
//                ->execute()
//                ->fetchAll('assoc');
//
//$connection = ConnectionManager::get('default');
//$results = $connection
//    ->newQuery()
//    ->select (['user_id','username'])
//    ->from('ngdrstab_mst_user')
//    //->where(['created >' => new DateTime('1 day ago')], ['created' => 'datetime'])
//    ->order(['user_id' => 'DESC'])
//    ->execute()
//    ->fetchAll();
//    pr($results);exit; 
        //  $users = $this->getTableLocator()->get('Users');
//    $result = $this->Users->find('list',[
//            'keyField'=>'user_id',
//            'valueField'=>'username'
//            ])->toArray();
//        $this->loadModel('Districts');
        $result = $this->fetchTable('Districts')->find('list', [
                    'keyField' => 'district_id',
                    'valueField' => 'district_name_en'
                ])->toArray();

//        pr($result);exit;
        $this->set("options", $result);
    }

    public function testpdf() {
//       $this->Mpdf->init(); 
//       $this->Mpdf->setFilename('file.pdf'); 
//       $this->Mpdf->setOutput('D');
//       //cancallanymPDFmethodvia
//       $this->Mpdf->pdf;
//       $this->Mpdf->pdf->SetWatermarkText("Draft");
//        
//          $this->autoRender=false;
//            $this->layout='pusty';
//            error_reporting(0);
//            App::import('Vendor', 'mPDF', array('file' => 'mPDF'.DS.'mpdf.php'));
//
//            $mpdf = new mPDF();
//            $html = '<font> TEST</font>';
//
//            $mpdf->WriteHTML($html);
//            $mpdf->Output();

        $mpdf = new Mpdf();

        echo 'hii';
        exit;
    }

    public function profileUpdate($user_id = NULL, $action = NULL) {


        $Users = $this->Users->newEmptyEntity();
        if ($this->request->is('post') || $this->request->is('put')) {
            // save/update record for edit
            $profile_user_id = $this->request->getSession()->read('profile_user_id');
            $request_data = $this->request->getData();
            $request_data['user_id'] = $profile_user_id;
            $Users = $this->Users->patchEntity($Users, $request_data);
            if ($this->Users->save($Users)) {
                $this->Flash->success(__('Your Profile Updated Successful.'));
                return $this->redirect('/Users/profile_update');
            }
            $this->Flash->error(__('Your registration failed.'));
        } else {
            //dispaly single record for edit
            if (is_numeric($user_id) && $action == 'E') {
                $Users = $this->fetchTable('Users')->find()->where(['user_id' => $user_id])->firstOrFail();
                if (!empty($Users)) {
                    $this->request->getSession()->write("profile_user_id", $user_id);
                }
            } elseif (is_numeric($user_id) && $action == 'D') {
                $entity = $this->fetchTable('Users')->get($user_id);
                $this->fetchTable('Users')->delete($entity);
                $this->Flash->success(__('Your Profile Deleted Successful.'));
                return $this->redirect('/Users/profile_update');
            }
        }
        $this->set('Users', $Users);

        //dispaly
        $users = $this->getTableLocator()->get('Users');
        $result = $users->find()->toArray();
        $this->set('result', $result);
    }

    /**
     *
     * @param var the parameter
     */
    public function index() {
        $page = "Home";
        $this->set('page', $page);
    }

    /**
     * citizen login function
     *
     */
    public function citizenLogin() {
        $page = "Citizen Login";
        $this->set('page', $page);
    }

    /**
     * organization login function
     */
    
    
    public function menu() {
        echo 'Hello';
        return json_encode(array('1'=>'Hi'));
       
    }
            
    
}
