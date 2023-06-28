<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class Current_StateTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrs_current_state');
        $this->setPrimaryKey('state_id');
    }

}
