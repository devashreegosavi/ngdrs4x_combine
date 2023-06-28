<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class DivisionTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_conf_admblock2_division');
        $this->setPrimaryKey('division_id');
    }
    
      public function Divisionlistdata($lang) {
        $Divisionlistdata = $this->find('list', [
                    'keyField' => 'division_id',
                    'valueField' => 'division_name_' . $lang
                ])->toArray();
        return $Divisionlistdata;
    }
    
    

}

?>