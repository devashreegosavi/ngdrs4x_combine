<?php

namespace App\Model\Table;

use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;

class DevelopLandTypeTable extends Table {

    public function initialize(array $config): void {
        $this->setTable('ngdrstab_mst_developed_land_types');
        $this->setPrimaryKey('developed_land_types_id');
    }
	
	 public function Developmentlandtypelistdata($lang) {
        $Developmentlandtype = $this->find('list', [
                    'keyField' => 'developed_land_types_id',
                    'valueField' => 'developed_land_types_desc_' . $lang
                ])->toArray();
        return $Developmentlandtype;
    }

}

?>