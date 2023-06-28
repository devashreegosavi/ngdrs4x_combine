<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class DistrictTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_conf_admblock3_district');
        $this->setPrimaryKey('district_id');
    }

}

?>