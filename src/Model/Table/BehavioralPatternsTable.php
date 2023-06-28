<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class BehavioralPatternsTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_trn_behavioral_patterns');
        $this->setPrimaryKey('id');
    }

}
