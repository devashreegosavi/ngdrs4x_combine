<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class BehavioralTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_conf_behavioral');
        $this->setPrimaryKey('behavioral_id');
    }

}
