<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class Citizen_RegistrationTable extends Table {

public function initialize(array $config): void {
$this->setTable('ngdrstab_trn_usercitizen_registartion');
$this->setPrimaryKey('reg_id');
}

public function findbyecitizenuser($getUserName){
	$getUserName = $getUserName;
	if(isset($getUserName) && !empty($getUserName)){
                $userName = $this->find()->select(['user_name'])->where(['user_name =' => $getUserName])->all();
                $count = count($userName);
                if ($count > 0) {
                    echo 1;exit;
                } else {
                    echo 0;exit;
                }
	}
}

public function findbyecitizenemail($getEmail){
	$getEmail = $getEmail;
	if(isset($getEmail) && !empty($getEmail)){
                $email_id = $this->find()->select(['email_id'])->where(['email_id =' => $getEmail])->all();
                $count = count($email_id);
                if ($count > 0) {
                    echo 1;exit;
                } else {
                    echo 0;exit;
                }
	}
}

public function findbyecitizenmobileno($getMobileno){
	$getMobileno = $getMobileno;
	if(isset($getMobileno) && !empty($getMobileno)){
                $mobileNo =$this->find()->select(['mobile_no'])->where(['mobile_no =' => $getMobileno])->all();
                $count = count($mobileNo);
                if ($count > 0) {
                    echo 1;exit;
                } else {
                    echo 0;exit;
                }
	}
}

}
?>