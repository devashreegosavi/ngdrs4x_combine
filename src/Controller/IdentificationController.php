<?php
class IdentificationController extends AppController {
    var $base_path = WWW_ROOT;

    public function identification(){
        $this->restrict_edit_after_submit($Selectedtoken);
        if (!is_numeric($Selectedtoken)) {
            $this->Flash->success(__('Saved Successfully'));
                return $this->redirect(['controller' => 'Generalinfo', 'action' => 'generalinfoentry']);
        }
        if($reschedule_flag=='Y'){
            return $this->redirect(['controller' => 'Appointment', 'action' => 'appointment']);
        }


        $witnessdet = $this->getTableLocator()->get('Identification');
        $NGDRSErrorCode = $this->getTableLocator()->get('NGDRSErrorCode');
        $last_status_id = $this->request->getSession()->read('last_status_id');
        $lang = $this->request->getSession()->read('Config.language');
        $Selectedtoken = $this->request->getSession()->read('Selectedtoken');
        $reschedule_flag = $this->request->getSession()->read('reschedule_flag');
        $session_usertype = $this->request->getSession()->read('session_usertype');
        $Selectedtoken='202300000004';
        $state_id = $this->request->getAttribute('identity')->state_id;
        $user_id = $this->request->getAttribute('identity')->user_id;
        $citizen_user_id = $this->request->getAttribute('identity')->citizen_user_id;
      
        $identificationrec = $this->fetchTable('Identification')
                                    ->find('all')
                                    ->where(['token_no =' => $Selectedtoken])
                                    ->toArray(); 
    }
}


?>