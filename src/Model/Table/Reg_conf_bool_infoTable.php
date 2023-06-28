<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class Reg_conf_bool_infoTable extends Table {

public function initialize(array $config): void {
$this->setTable('ngdrstab_conf_reg_bool_info');
$this->setPrimaryKey('reg_id');
}

}
?>