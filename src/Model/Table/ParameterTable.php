<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class ParameterTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_trn_parameter');
        $this->setPrimaryKey('id');
    }

}
