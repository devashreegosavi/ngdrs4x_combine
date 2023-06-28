<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class StateTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_conf_admblock1_state');
       // $this->setPrimaryKey('district_id');
    }

}

?>