<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class BehavioralDetailsTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_conf_behavioral_details');
        $this->setPrimaryKey('behavioral_details_id');
    }

}
